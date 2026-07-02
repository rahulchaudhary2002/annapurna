<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Business;
use App\Models\ContactSubmission;
use App\Models\Guide;
use App\Models\Package;
use App\Models\PackageInquiry;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class DashboardOverviewWidget extends Widget
{
    protected static string $view        = 'filament.widgets.dashboard-overview';
    protected static ?int   $sort        = 1;
    protected static bool   $isLazy      = false;
    protected static bool   $isDiscovered = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $now            = Carbon::now();
        $period         = request()->query('period', 'year');
        $monthStart     = $now->copy()->startOfMonth();
        $lastStart      = $now->copy()->subMonth()->startOfMonth();
        $lastEnd        = $now->copy()->subMonth()->endOfMonth();

        // ── KPIs ────────────────────────────────────────────────────────────
        $totalRevenue   = (int) Booking::whereNotNull('total_price')->sum('total_price');
        $thisMonthRev   = (int) Booking::whereNotNull('total_price')->where('created_at', '>=', $monthStart)->sum('total_price');
        $lastMonthRev   = (int) Booking::whereNotNull('total_price')->whereBetween('created_at', [$lastStart, $lastEnd])->sum('total_price');
        $revGrowth      = $lastMonthRev > 0 ? round(($thisMonthRev - $lastMonthRev) / $lastMonthRev * 100, 1) : 0;

        $totalBookings  = Booking::count();
        $thisMonthBooks = Booking::where('created_at', '>=', $monthStart)->count();
        $pendingBooks   = Booking::pending()->count();

        $totalUsers     = User::count();
        $thisMonthUsers = User::where('created_at', '>=', $monthStart)->count();

        $totalBiz       = Business::where('is_active', true)->count();
        $verifiedBiz    = Business::where('is_active', true)->where('is_verified', true)->count();

        $activePackages = Package::where('is_active', true)->count();
        $sponsoredPkgs  = Package::where('is_active', true)
                            ->where('listing_type', 'paid')
                            ->where('paid_until', '>=', $now)
                            ->count();

        $totalGuides    = Guide::where('is_active', true)->count();
        $avgRating      = round((float)(Guide::where('is_active', true)->avg('rating') ?? 0), 1);

        $newInquiries   = PackageInquiry::where('status', 'new')->count();
        $newMessages    = ContactSubmission::where('status', 'new')->count();
        $totalPending   = $pendingBooks + $newInquiries + $newMessages;

        $avgValue       = $totalBookings > 0 ? (int) ($totalRevenue / $totalBookings) : 0;

        // ── Revenue Trend Chart ──────────────────────────────────────────────
        $trendCount     = match ($period) {
            'month'   => 4,
            'quarter' => 3,
            default   => 12,
        };

        $revenueMonths  = collect(range($trendCount - 1, 0))->map(function ($i) use ($now) {
            $m   = $now->copy()->subMonths($i);
            $s   = $m->copy()->startOfMonth();
            $e   = $m->copy()->endOfMonth();
            return [
                'label'    => $m->format('M'),
                'revenue'  => (int) Booking::whereNotNull('total_price')->whereBetween('created_at', [$s, $e])->sum('total_price'),
                'bookings' => Booking::whereBetween('created_at', [$s, $e])->count(),
                'users'    => User::whereBetween('created_at', [$s, $e])->count(),
            ];
        });

        // ── Status Distribution ──────────────────────────────────────────────
        $statusCounts   = [
            'pending'   => Booking::pending()->count(),
            'confirmed' => Booking::confirmed()->count(),
            'completed' => Booking::completed()->count(),
            'cancelled' => Booking::cancelled()->count(),
        ];

        // ── Business Types ───────────────────────────────────────────────────
        $businessTypes  = Business::where('is_active', true)
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'type')
            ->toArray();

        // ── Package Inquiries 6-month trend ──────────────────────────────────
        $inquiryMonths  = collect(range(5, 0))->map(function ($i) use ($now) {
            $m = $now->copy()->subMonths($i);
            return [
                'label' => $m->format('M'),
                'count' => PackageInquiry::whereBetween('created_at', [
                    $m->copy()->startOfMonth(),
                    $m->copy()->endOfMonth(),
                ])->count(),
            ];
        });

        $totalInquiries = PackageInquiry::count();
        $prev6          = PackageInquiry::where('created_at', '<', $now->copy()->subMonths(6))->count();
        $last6          = PackageInquiry::where('created_at', '>=', $now->copy()->subMonths(6))->count();
        $inquiryGrowth  = $prev6 > 0 ? round(($last6 - $prev6) / $prev6 * 100) : 0;

        // ── Top Packages ─────────────────────────────────────────────────────
        $topPackages    = Package::with('business:id,name')
            ->withCount([
                'bookings as total_bookings',
                'bookings as successful_bookings' => fn ($q) => $q->whereIn('status', ['confirmed', 'completed']),
            ])
            ->withSum('bookings', 'total_price')
            ->where('is_active', true)
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get(['id', 'name', 'business_id', 'listing_type']);

        $maxPkgBookings = max(1, $topPackages->max('total_bookings') ?? 1);

        // ── Daily Heatmap (35 days) ──────────────────────────────────────────
        $heatmapDays    = collect(range(34, 0))->map(function ($d) use ($now) {
            $date = $now->copy()->subDays($d);
            return [
                'date'  => $date->format('d M'),
                'count' => Booking::whereDate('created_at', $date->toDateString())->count(),
            ];
        });
        $heatmapMax     = max(1, $heatmapDays->max('count'));
        $heatmapRows    = $heatmapDays->chunk(7);

        // ── Recent Bookings & Messages ────────────────────────────────────────
        $recentBookings = Booking::with('bookable')->orderByDesc('created_at')->limit(8)->get();
        $recentMessages = ContactSubmission::orderByDesc('created_at')->limit(5)->get();

        return compact(
            'period',
            'totalRevenue', 'thisMonthRev', 'revGrowth',
            'totalBookings', 'thisMonthBooks', 'pendingBooks',
            'totalUsers', 'thisMonthUsers',
            'totalBiz', 'verifiedBiz',
            'activePackages', 'sponsoredPkgs',
            'totalGuides', 'avgRating',
            'totalPending', 'newInquiries', 'newMessages',
            'avgValue',
            'revenueMonths', 'statusCounts', 'businessTypes',
            'inquiryMonths', 'totalInquiries', 'inquiryGrowth',
            'topPackages', 'maxPkgBookings',
            'heatmapDays', 'heatmapMax', 'heatmapRows',
            'recentBookings', 'recentMessages'
        );
    }
}
