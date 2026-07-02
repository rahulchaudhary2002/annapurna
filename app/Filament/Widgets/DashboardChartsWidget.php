<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Business;
use App\Models\Package;
use App\Models\PackageInquiry;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class DashboardChartsWidget extends Widget
{
    protected static string $view    = 'filament.widgets.dashboard-charts';
    protected static ?int   $sort    = 3;
    protected static bool   $isLazy  = false;
    protected static bool   $isDiscovered = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $now = Carbon::now();

        // 12-month revenue + bookings + user growth
        $months = collect(range(11, 0))->map(function ($i) use ($now) {
            $month = $now->copy()->subMonths($i);
            $start = $month->copy()->startOfMonth();
            $end   = $month->copy()->endOfMonth();

            return [
                'label'    => $month->format('M'),
                'revenue'  => (int) Booking::whereNotNull('total_price')->whereBetween('created_at', [$start, $end])->sum('total_price'),
                'bookings' => Booking::whereBetween('created_at', [$start, $end])->count(),
                'users'    => User::whereBetween('created_at', [$start, $end])->count(),
            ];
        });

        // Booking status distribution
        $statusCounts = [
            'pending'   => Booking::pending()->count(),
            'confirmed' => Booking::confirmed()->count(),
            'completed' => Booking::completed()->count(),
            'cancelled' => Booking::cancelled()->count(),
        ];

        // Business type distribution
        $businessTypes = Business::where('is_active', true)
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->orderByDesc('count')
            ->pluck('count', 'type')
            ->toArray();

        // Top 5 packages by bookings
        $topPackages = Package::with('business:id,name')
            ->withCount([
                'bookings as total_bookings',
                'bookings as confirmed_bookings' => fn ($q) => $q->where('status', 'confirmed'),
                'inquiries as total_inquiries',
            ])
            ->where('is_active', true)
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get(['id', 'name', 'business_id', 'listing_type', 'daily_rate']);

        // Daily bookings — last 30 days
        $dailyBookings = collect(range(29, 0))->map(function ($d) use ($now) {
            $date = $now->copy()->subDays($d);
            return [
                'label' => $date->format('d M'),
                'count' => Booking::whereDate('created_at', $date->toDateString())->count(),
            ];
        });

        // Confirmed rate & average value
        $total          = Booking::count();
        $totalRevenue   = (int) Booking::whereNotNull('total_price')->sum('total_price');
        $confirmedRate  = $total > 0 ? round(Booking::confirmed()->count() / $total * 100) : 0;
        $avgValue       = $total > 0 ? (int) ($totalRevenue / $total) : 0;

        // Hotel vs Package bookings
        $hotelBookings   = Booking::where('bookable_type', 'App\\Models\\Business')->count();
        $packageBookings = Booking::where('bookable_type', 'App\\Models\\Package')->count();

        // Package inquiries last 6 months
        $inquiryMonths = collect(range(5, 0))->map(function ($i) use ($now) {
            $month = $now->copy()->subMonths($i);
            return [
                'label' => $month->format('M'),
                'count' => PackageInquiry::whereBetween('created_at', [
                    $month->copy()->startOfMonth(),
                    $month->copy()->endOfMonth(),
                ])->count(),
            ];
        });

        return compact(
            'months', 'statusCounts', 'businessTypes', 'topPackages',
            'dailyBookings', 'totalRevenue', 'total', 'confirmedRate',
            'avgValue', 'hotelBookings', 'packageBookings', 'inquiryMonths'
        );
    }
}
