<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Business;
use App\Models\ContactSubmission;
use App\Models\Guide;
use App\Models\Package;
use App\Models\PackageInquiry;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DashboardKpiWidget extends BaseWidget
{
    protected static ?int  $sort         = 2;
    protected static bool  $isLazy       = false;
    protected static bool  $isDiscovered = false;

    protected function getStats(): array
    {
        $now            = Carbon::now();
        $monthStart     = $now->copy()->startOfMonth();
        $lastStart      = $now->copy()->subMonth()->startOfMonth();
        $lastEnd        = $now->copy()->subMonth()->endOfMonth();

        // Revenue
        $totalRevenue   = (int) Booking::whereNotNull('total_price')->sum('total_price');
        $thisMonthRev   = (int) Booking::whereNotNull('total_price')->where('created_at', '>=', $monthStart)->sum('total_price');
        $lastMonthRev   = (int) Booking::whereNotNull('total_price')->whereBetween('created_at', [$lastStart, $lastEnd])->sum('total_price');
        $revGrowth      = $lastMonthRev > 0 ? round((($thisMonthRev - $lastMonthRev) / $lastMonthRev) * 100) : 0;

        // Bookings
        $totalBookings  = Booking::count();
        $thisMonthBooks = Booking::where('created_at', '>=', $monthStart)->count();
        $pendingBooks   = Booking::pending()->count();
        $confirmedBooks = Booking::confirmed()->count();

        // Users
        $totalUsers     = User::count();
        $thisMonthUsers = User::where('created_at', '>=', $monthStart)->count();
        $lastMonthUsers = User::whereBetween('created_at', [$lastStart, $lastEnd])->count();
        $userGrowth     = $lastMonthUsers > 0 ? round((($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100) : 0;

        // Businesses
        $totalBiz       = Business::where('is_active', true)->count();
        $verifiedBiz    = Business::where('is_active', true)->where('is_verified', true)->count();

        // Pending actions
        $newInquiries   = PackageInquiry::where('status', 'new')->count();
        $newMessages    = ContactSubmission::where('status', 'new')->count();
        $totalPending   = $pendingBooks + $newInquiries + $newMessages;

        // Packages & Guides
        $activePackages = Package::where('is_active', true)->count();
        $sponsoredPkgs  = Package::where('is_active', true)->where('listing_type', 'paid')
                            ->where('paid_until', '>=', $now)->count();
        $totalGuides    = Guide::where('is_active', true)->count();
        $avgRating      = (float) (Guide::where('is_active', true)->avg('rating') ?? 0);

        // Avg booking value
        $avgValue       = $totalBookings > 0 ? (int) ($totalRevenue / $totalBookings) : 0;

        // 7-day sparklines
        $spark = fn ($model, $col = null) => collect(range(6, 0))->map(
            fn ($d) => $col
                ? (int) $model::whereDate('created_at', $now->copy()->subDays($d)->toDateString())->sum($col)
                : $model::whereDate('created_at', $now->copy()->subDays($d)->toDateString())->count()
        )->toArray();

        $revSpark = collect(range(6, 0))->map(
            fn ($d) => (int) Booking::whereNotNull('total_price')
                ->whereDate('created_at', $now->copy()->subDays($d)->toDateString())
                ->sum('total_price')
        )->toArray();

        return [
            Stat::make('Total Revenue', 'Rs. ' . number_format($totalRevenue))
                ->description(
                    'Rs. ' . number_format($thisMonthRev) . ' this month'
                    . ($revGrowth !== 0 ? ' (' . ($revGrowth > 0 ? '+' : '') . $revGrowth . '%)' : '')
                )
                ->descriptionIcon($revGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($revSpark)
                ->color($revGrowth >= 0 ? 'success' : 'danger'),

            Stat::make('Total Bookings', number_format($totalBookings))
                ->description($thisMonthBooks . ' this month · ' . $pendingBooks . ' pending')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($spark(Booking::class))
                ->color('primary'),

            Stat::make('Registered Users', number_format($totalUsers))
                ->description($thisMonthUsers . ' new this month' . ($userGrowth !== 0 ? ' (' . ($userGrowth > 0 ? '+' : '') . $userGrowth . '%)' : ''))
                ->descriptionIcon($userGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($spark(User::class))
                ->color($userGrowth >= 0 ? 'success' : 'warning'),

            Stat::make('Active Businesses', number_format($totalBiz))
                ->description($verifiedBiz . ' verified · ' . ($totalBiz - $verifiedBiz) . ' unverified')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),

            Stat::make('Pending Actions', number_format($totalPending))
                ->description($pendingBooks . ' bookings · ' . $newInquiries . ' inquiries · ' . $newMessages . ' msgs')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color($totalPending > 0 ? 'warning' : 'success'),

            Stat::make('Active Packages', number_format($activePackages))
                ->description($sponsoredPkgs . ' sponsored · ' . ($activePackages - $sponsoredPkgs) . ' standard')
                ->descriptionIcon('heroicon-m-gift')
                ->color('success'),

            Stat::make('Guides Available', number_format($totalGuides))
                ->description('Avg rating: ' . number_format($avgRating, 1) . ' / 5.0')
                ->descriptionIcon('heroicon-m-map')
                ->color('primary'),

            Stat::make('Avg Booking Value', 'Rs. ' . number_format($avgValue))
                ->description('Across ' . number_format($totalBookings) . ' total bookings')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}
