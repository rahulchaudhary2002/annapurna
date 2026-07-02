<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Business;
use App\Models\BusinessProfileView;
use App\Models\ContactSubmission;
use App\Models\FeedPost;
use App\Models\FeedPostLike;
use App\Models\FeedPostShare;
use App\Models\FeedPostView;
use App\Models\Package;
use App\Models\PackageInquiry;
use App\Models\Post;
use App\Models\ProfileClick;
use App\Models\User;
use App\Services\GoogleAnalyticsService;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class SiteAnalyticsWidget extends Widget
{
    protected static string $view        = 'filament.widgets.site-analytics';
    protected static bool   $isLazy      = false;
    protected static bool   $isDiscovered = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $days = max(7, min(90, (int) request()->query('days', 30)));
        $now  = Carbon::now();

        // ── Google Analytics ─────────────────────────────────────────────────
        $ga          = app(GoogleAnalyticsService::class);
        $gaConnected = $ga->isConfigured();
        $gaError     = null;
        $gaData      = [];

        if ($gaConnected) {
            try {
                $gaData = [
                    'overview'  => $ga->getOverview($days),
                    'trend'     => $ga->getSessionsTrend($days),
                    'sources'   => $ga->getTrafficSources($days),
                    'pages'     => $ga->getTopPages(10, $days),
                    'devices'   => $ga->getDeviceBreakdown($days),
                    'countries' => $ga->getCountries(8, $days),
                    'events'    => $ga->getTopEvents($days),
                    'realtime'  => $ga->getRealtimeUsers(),
                ];
            } catch (\Throwable $e) {
                $gaError     = $e->getMessage();
                $gaConnected = false;
            }
        }

        // ── Internal: Date window ────────────────────────────────────────────
        $since   = $now->copy()->subDays($days);
        $midSince = $now->copy()->subDays($days * 2);

        // ── Internal: Content — Blog posts (uses posts.views column) ─────────
        $totalBlogViews = Post::where('status', 'published')->sum('views');
        $topBlogPosts   = Post::where('status', 'published')
            ->orderByDesc('views')
            ->limit(8)
            ->get(['id', 'title', 'slug', 'views', 'read_time', 'published_at']);

        // Views trend: group by day (simulate from post view counts proportionally)
        // We don't have per-day blog views, so we use business_profile_views as content view proxy
        // and feed_post_views for actual daily data
        $feedViewsTrend = collect(range($days - 1, 0))->map(function ($d) use ($now) {
            $date = $now->copy()->subDays($d);
            return [
                'label' => $date->format('d M'),
                'views' => FeedPostView::whereDate('created_at', $date->toDateString())->count(),
                'likes' => FeedPostLike::whereDate('created_at', $date->toDateString())->count(),
                'shares'=> FeedPostShare::whereDate('created_at', $date->toDateString())->count(),
            ];
        });

        // ── Internal: Business profile views ─────────────────────────────────
        $totalBizViews = BusinessProfileView::where('created_at', '>=', $since)->count();
        $prevBizViews  = BusinessProfileView::whereBetween('created_at', [$midSince, $since])->count();
        $bizViewGrowth = $prevBizViews > 0
            ? round(($totalBizViews - $prevBizViews) / $prevBizViews * 100)
            : 0;

        $bizViewsTrend = collect(range(min($days, 30) - 1, 0))->map(function ($d) use ($now) {
            $date = $now->copy()->subDays($d);
            return [
                'label' => $date->format('d M'),
                'views' => BusinessProfileView::whereDate('created_at', $date->toDateString())->count(),
                'clicks'=> ProfileClick::whereDate('created_at', $date->toDateString())->count(),
            ];
        });

        $topBizByViews = Business::where('is_active', true)
            ->withCount(['profileViews as view_count' => fn ($q) => $q->where('created_at', '>=', $since)])
            ->orderByDesc('view_count')
            ->limit(5)
            ->get(['id', 'name', 'type']);

        $clickSources = ProfileClick::where('created_at', '>=', $since)
            ->selectRaw('source, count(*) as count')
            ->groupBy('source')
            ->orderByDesc('count')
            ->pluck('count', 'source')
            ->toArray();

        // ── Internal: Feed engagement ─────────────────────────────────────────
        $totalFeedViews   = FeedPost::sum('views_count');
        $totalFeedLikes   = FeedPost::sum('likes_count');
        $totalFeedComments= FeedPost::sum('comments_count');
        $totalFeedShares  = FeedPost::sum('shares_count');

        $topFeedPosts = FeedPost::orderByDesc('views_count')
            ->limit(5)
            ->get(['id', 'title', 'content', 'views_count', 'likes_count', 'comments_count', 'shares_count', 'saves_count', 'created_at']);

        // ── Internal: Conversion funnel ───────────────────────────────────────
        $funnelBizViews   = BusinessProfileView::where('created_at', '>=', $since)->count();
        $funnelInquiries  = PackageInquiry::where('created_at', '>=', $since)->count();
        $funnelBookings   = Booking::where('created_at', '>=', $since)->count();
        $funnelConfirmed  = Booking::whereIn('status', ['confirmed', 'completed'])->where('created_at', '>=', $since)->count();

        $funnelMax = max(1, $funnelBizViews);
        $funnel    = [
            ['label' => 'Profile Views',   'count' => $funnelBizViews,  'pct' => 100,                                  'color' => '#3b82f6'],
            ['label' => 'Inquiries',        'count' => $funnelInquiries, 'pct' => round($funnelInquiries / $funnelMax * 100, 1), 'color' => '#8b5cf6'],
            ['label' => 'Bookings',         'count' => $funnelBookings,  'pct' => round($funnelBookings  / $funnelMax * 100, 1), 'color' => '#f59e0b'],
            ['label' => 'Confirmed',        'count' => $funnelConfirmed, 'pct' => round($funnelConfirmed / $funnelMax * 100, 1), 'color' => '#10b981'],
        ];

        // ── Internal: Growth metrics (last 6 months) ──────────────────────────
        $growthMonths = collect(range(5, 0))->map(function ($i) use ($now) {
            $m = $now->copy()->subMonths($i);
            $s = $m->copy()->startOfMonth();
            $e = $m->copy()->endOfMonth();
            return [
                'label'       => $m->format('M'),
                'users'       => User::whereBetween('created_at', [$s, $e])->count(),
                'businesses'  => Business::whereBetween('created_at', [$s, $e])->count(),
                'bookings'    => Booking::whereBetween('created_at', [$s, $e])->count(),
                'inquiries'   => PackageInquiry::whereBetween('created_at', [$s, $e])->count(),
            ];
        });

        // ── Internal: Inquiry + Contact summary ───────────────────────────────
        $inquiryStats = [
            'total'    => PackageInquiry::count(),
            'new'      => PackageInquiry::where('status', 'new')->count(),
            'period'   => PackageInquiry::where('created_at', '>=', $since)->count(),
        ];

        $messageStats = [
            'total'  => ContactSubmission::count(),
            'new'    => ContactSubmission::where('status', 'new')->count(),
            'period' => ContactSubmission::where('created_at', '>=', $since)->count(),
        ];

        return compact(
            'days', 'gaConnected', 'gaError', 'gaData',
            'totalBlogViews', 'topBlogPosts',
            'feedViewsTrend',
            'totalBizViews', 'bizViewGrowth', 'bizViewsTrend',
            'topBizByViews', 'clickSources',
            'totalFeedViews', 'totalFeedLikes', 'totalFeedComments', 'totalFeedShares',
            'topFeedPosts',
            'funnel',
            'growthMonths',
            'inquiryStats', 'messageStats'
        );
    }
}
