<?php

namespace App\Services;

use App\Models\BlogView;
use App\Models\Business;
use App\Models\BusinessPostComment;
use App\Models\BusinessPostLike;
use App\Models\BusinessRankHistory;
use App\Models\FeedPostComment;
use App\Models\FeedPostLike;
use App\Models\FeedPostShare;
use App\Models\MonthlyReport;
use App\Models\PackageView;
use App\Models\PostEngagement;
use App\Models\ProfileClick;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MonthlyReportService
{
    public function generateForBusiness(Business $business, int $year, int $month): MonthlyReport
    {
        $start     = Carbon::create($year, $month, 1)->startOfMonth();
        $end       = Carbon::create($year, $month, 1)->endOfMonth();
        $prevStart = $start->copy()->subMonth()->startOfMonth();
        $prevEnd   = $start->copy()->subMonth()->endOfMonth();

        $data = array_merge(
            $this->collectBusinessStats($business, $start, $end, $prevStart, $prevEnd),
            [
                'packages'       => $this->collectPackageStats($business, $start, $end, $prevStart, $prevEnd),
                'business_posts' => $this->collectBusinessPostStats($business, $start, $end),
                'feed_posts'     => $this->collectFeedPostStats($business, $start, $end),
                'blog_posts'     => $this->collectBlogViewStats($business, $start, $end),
            ]
        );

        [$rankingPosition, $rankingChange] = $this->computeRanking($business, $year, $month);
        $rankingTip = $this->generateRankingTip($data, $rankingChange);

        return MonthlyReport::updateOrCreate(
            [
                'business_id'  => $business->id,
                'period_month' => $month,
                'period_year'  => $year,
            ],
            [
                'user_id'          => $business->user_id,
                'report_data'      => $data,
                'ranking_position' => $rankingPosition,
                'ranking_change'   => $rankingChange,
                'ranking_tip'      => $rankingTip,
                'status'           => 'pending',
            ]
        );
    }

    public function generateAll(int $year, int $month): int
    {
        $count = 0;
        Business::where('is_active', true)
            ->whereNotNull('user_id')
            ->lazy()
            ->each(function (Business $b) use ($year, $month, &$count) {
                $this->generateForBusiness($b, $year, $month);
                $count++;
            });

        return $count;
    }

    // ─── Stats collectors ─────────────────────────────────────────────────────

    private function collectBusinessStats(
        Business $business,
        Carbon $start, Carbon $end,
        Carbon $prevStart, Carbon $prevEnd
    ): array {
        // Profile clicks from dedicated table
        $clicks     = ProfileClick::where('business_id', $business->id)
            ->whereBetween('created_at', [$start, $end])->count();
        $clicksPrev = ProfileClick::where('business_id', $business->id)
            ->whereBetween('created_at', [$prevStart, $prevEnd])->count();

        // Passive profile views (deduped per day)
        $views     = $business->profileViews()
            ->whereBetween('viewed_on', [$start->toDateString(), $end->toDateString()])->count();
        $viewsPrev = $business->profileViews()
            ->whereBetween('viewed_on', [$prevStart->toDateString(), $prevEnd->toDateString()])->count();

        $followersTotal  = $business->followers()->count();
        $followersGained = $business->followers()
            ->whereBetween('created_at', [$start, $end])->count();

        return [
            'business_name'       => $business->name,
            'business_type'       => $business->type,
            'profile_clicks'      => $clicks,
            'profile_clicks_prev' => $clicksPrev,
            'profile_clicks_change' => $clicks - $clicksPrev,
            'profile_views'        => $views,
            'profile_views_prev'   => $viewsPrev,
            'profile_views_change' => $views - $viewsPrev,
            'followers_total'      => $followersTotal,
            'followers_gained'     => $followersGained,
        ];
    }

    private function collectPackageStats(
        Business $business,
        Carbon $start, Carbon $end,
        Carbon $prevStart, Carbon $prevEnd
    ): array {
        return $business->packages()
            ->where('is_active', true)
            ->get()
            ->map(function ($pkg) use ($start, $end, $prevStart, $prevEnd) {
                // Views from package_view table
                $views     = PackageView::where('package_id', $pkg->id)
                    ->whereBetween('viewed_on', [$start->toDateString(), $end->toDateString()])->count();
                $viewsPrev = PackageView::where('package_id', $pkg->id)
                    ->whereBetween('viewed_on', [$prevStart->toDateString(), $prevEnd->toDateString()])->count();

                // Inquiries (click-throughs that converted)
                $inq     = $pkg->inquiries()->whereBetween('created_at', [$start, $end])->count();
                $inqPrev = $pkg->inquiries()->whereBetween('created_at', [$prevStart, $prevEnd])->count();

                $ctr = $views > 0 ? round($inq / $views * 100, 1) : 0.0;

                return [
                    'name'             => $pkg->name,
                    'views'            => $views,
                    'views_prev'       => $viewsPrev,
                    'views_change'     => $views - $viewsPrev,
                    'inquiries'        => $inq,
                    'inquiries_prev'   => $inqPrev,
                    'inquiries_change' => $inq - $inqPrev,
                    'ctr'              => $ctr,
                ];
            })
            ->toArray();
    }

    private function collectBusinessPostStats(Business $business, Carbon $start, Carbon $end): array
    {
        return $business->businessPosts()
            ->where('is_published', true)
            ->get()
            ->map(function ($post) use ($start, $end, $postIds) {
                // Use post_engagement log; fall back to dedicated tables
                $engagementFromLog = PostEngagement::where('post_type', 'business_post')
                    ->where('post_id', $post->id)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereIn('action', ['like', 'comment'])
                    ->count();

                if ($engagementFromLog > 0) {
                    $likes    = PostEngagement::where('post_type', 'business_post')
                        ->where('post_id', $post->id)
                        ->whereBetween('created_at', [$start, $end])
                        ->where('action', 'like')->count();
                    $comments = PostEngagement::where('post_type', 'business_post')
                        ->where('post_id', $post->id)
                        ->whereBetween('created_at', [$start, $end])
                        ->where('action', 'comment')->count();
                } else {
                    $likes    = BusinessPostLike::where('business_post_id', $post->id)
                        ->whereBetween('created_at', [$start, $end])->count();
                    $comments = BusinessPostComment::where('business_post_id', $post->id)
                        ->whereBetween('created_at', [$start, $end])->count();
                }

                return [
                    'title'      => Str::limit($post->title ?? Str::limit(strip_tags($post->content ?? ''), 80), 80),
                    'views'      => (int) ($post->views ?? 0),
                    'likes'      => $likes,
                    'comments'   => $comments,
                    'engagement' => $likes + $comments,
                ];
            })
            ->sortByDesc('engagement')
            ->values()
            ->toArray();
    }

    private function collectFeedPostStats(Business $business, Carbon $start, Carbon $end): array
    {
        return $business->feedPosts()
            ->where('is_published', true)
            ->get()
            ->map(function ($post) use ($start, $end) {
                // Use post_engagement log; fall back to dedicated tables
                $engagementLog = PostEngagement::where('post_type', 'feed_post')
                    ->where('post_id', $post->id)
                    ->whereBetween('created_at', [$start, $end]);

                $likes    = (clone $engagementLog)->where('action', 'like')->count()
                    ?: FeedPostLike::where('feed_post_id', $post->id)
                        ->whereBetween('created_at', [$start, $end])->count();
                $comments = (clone $engagementLog)->where('action', 'comment')->count()
                    ?: FeedPostComment::where('feed_post_id', $post->id)
                        ->whereBetween('created_at', [$start, $end])->count();
                $shares   = (clone $engagementLog)->where('action', 'share')->count()
                    ?: FeedPostShare::where('feed_post_id', $post->id)
                        ->whereBetween('created_at', [$start, $end])->count();

                $views = $post->views_count ?? 0;
                $ctr   = $views > 0 ? round(($likes + $comments + $shares) / $views * 100, 1) : 0.0;

                return [
                    'title'        => Str::limit($post->title ?? Str::limit(strip_tags($post->content ?? ''), 80), 80),
                    'impressions'  => $views,
                    'likes'        => $likes,
                    'comments'     => $comments,
                    'shares'       => $shares,
                    'ctr'          => $ctr,
                ];
            })
            ->sortByDesc('impressions')
            ->values()
            ->toArray();
    }

    private function collectBlogViewStats(Business $business, Carbon $start, Carbon $end): array
    {
        // Blog posts authored by the business owner
        $userId = $business->user_id;
        if (! $userId) return [];

        return \App\Models\Post::published()
            ->where('user_id', $userId)
            ->get()
            ->map(function ($post) use ($start, $end) {
                $views = BlogView::where('post_id', $post->id)
                    ->whereBetween('viewed_on', [$start->toDateString(), $end->toDateString()])
                    ->count();

                return [
                    'title'  => Str::limit($post->title, 80),
                    'views'  => $views,
                    'slug'   => $post->slug,
                ];
            })
            ->filter(fn ($p) => $p['views'] > 0)
            ->sortByDesc('views')
            ->values()
            ->toArray();
    }

    // ─── Ranking ──────────────────────────────────────────────────────────────

    private function computeRanking(Business $business, int $year, int $month): array
    {
        $rankedIds = Business::where('is_active', true)
            ->orderByRaw('COALESCE(ranking_override, ranking_score, 0) DESC')
            ->pluck('id');

        $currentPos = ($rankedIds->search($business->id) + 1) ?: null;

        // Look up previous month's rank from history table
        $prevYear  = $month === 1 ? $year - 1 : $year;
        $prevMonth = $month === 1 ? 12 : $month - 1;

        $prevHistory = BusinessRankHistory::where('business_id', $business->id)
            ->where('recorded_year', $prevYear)
            ->where('recorded_month', $prevMonth)
            ->first();

        $change = null;
        if ($prevHistory && $prevHistory->position && $currentPos) {
            // Positive = improved (moved to a lower position number)
            $change = $prevHistory->position - $currentPos;
        }

        return [$currentPos, $change];
    }

    private function generateRankingTip(array $data, ?int $rankingChange): string
    {
        $clicks    = $data['profile_clicks'] ?? 0;
        $clicksChg = $data['profile_clicks_change'] ?? 0;

        $totalEngagement = collect($data['business_posts'] ?? [])->sum('engagement')
            + collect($data['feed_posts'] ?? [])->sum(fn ($p) =>
                ($p['likes'] ?? 0) + ($p['comments'] ?? 0) + ($p['shares'] ?? 0)
            );

        $totalInquiries = collect($data['packages'] ?? [])->sum('inquiries');

        if ($rankingChange > 0) {
            if ($totalEngagement > 10) {
                return 'Great job! High engagement from your posts boosted your ranking.';
            }
            if ($clicks > 20) {
                return 'Increased profile visibility drove your ranking up this month.';
            }
            return 'Your ranking improved this month. Keep up the activity!';
        }

        if ($rankingChange < 0) {
            if ($clicks < 5) {
                return 'Low profile click-throughs this month. Try sharing your listing on social media.';
            }
            if ($totalEngagement === 0) {
                return 'No post engagement this month. Publish fresh content to regain ranking.';
            }
            return 'Competition increased — keep posting and engaging to regain your position.';
        }

        if ($clicksChg > 20) {
            return 'Profile clicks are trending up. Consider adding more packages to convert visits.';
        }
        if ($totalInquiries > 0) {
            return 'You received package inquiries this month. Respond promptly to improve conversions.';
        }

        return 'Steady performance. Publishing new content and responding to reviews can boost your ranking.';
    }
}
