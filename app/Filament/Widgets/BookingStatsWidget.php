<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class BookingStatsWidget extends BaseWidget
{
    protected static ?int  $sort         = 0;
    protected static bool  $isLazy       = false;
    protected static bool  $isDiscovered = false;

    protected function getStats(): array
    {
        $now   = Carbon::now();
        $msStart = $now->copy()->startOfMonth();
        $lmStart = $now->copy()->subMonth()->startOfMonth();
        $lmEnd   = $now->copy()->subMonth()->endOfMonth();

        $total          = Booking::count();
        $thisMonthTotal = Booking::where('created_at', '>=', $msStart)->count();
        $lastMonthTotal = Booking::whereBetween('created_at', [$lmStart, $lmEnd])->count();

        $growthPct = $lastMonthTotal > 0
            ? round((($thisMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100, 1)
            : ($thisMonthTotal > 0 ? 100 : 0);

        $pending   = Booking::pending()->count();
        $confirmed = Booking::confirmed()->where('created_at', '>=', $msStart)->count();

        $totalRevenue     = (float) Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $thisMonthRevenue = (float) Booking::whereIn('status', ['confirmed', 'completed'])
            ->where('created_at', '>=', $msStart)->sum('total_price');
        $lastMonthRevenue = (float) Booking::whereIn('status', ['confirmed', 'completed'])
            ->whereBetween('created_at', [$lmStart, $lmEnd])->sum('total_price');

        $revGrowth = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($thisMonthRevenue > 0 ? 100 : 0);

        $processed       = Booking::whereIn('status', ['confirmed', 'cancelled', 'completed'])->count();
        $cancelledCount  = Booking::cancelled()->count();
        $cancelRate      = $processed > 0 ? round(($cancelledCount / $processed) * 100, 1) : 0;

        $avgValue = (float) (Booking::whereNotNull('total_price')->where('total_price', '>', 0)->avg('total_price') ?? 0);

        // Last 7-day sparklines
        $spark7 = fn (callable $q) => collect(range(6, 0))
            ->map(fn ($d) => (int) $q($now->copy()->subDays($d)))
            ->toArray();

        $bookingsSpark = $spark7(fn ($day) => Booking::whereDate('created_at', $day)->count());
        $revenueSpark  = $spark7(fn ($day) => Booking::whereIn('status', ['confirmed', 'completed'])
            ->whereDate('created_at', $day)->sum('total_price'));
        $pendingSpark  = $spark7(fn ($day) => Booking::where('status', 'pending')->whereDate('created_at', $day)->count());

        return [
            Stat::make('Total Bookings', number_format($total))
                ->description($thisMonthTotal . ' this month '
                    . ($growthPct >= 0 ? '▲' : '▼') . ' ' . abs($growthPct) . '% vs last month')
                ->descriptionIcon($growthPct >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($growthPct >= 0 ? 'success' : 'danger')
                ->chart($bookingsSpark),

            Stat::make('Pending Bookings', $pending)
                ->description($pending > 0 ? 'Require your attention' : 'All caught up — no pending!')
                ->descriptionIcon($pending > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-badge')
                ->color($pending > 0 ? 'warning' : 'success')
                ->chart($pendingSpark),

            Stat::make('Confirmed This Month', $confirmed)
                ->description('Successfully confirmed bookings')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Revenue', 'Rs. ' . number_format($totalRevenue))
                ->description('Rs. ' . number_format($thisMonthRevenue) . ' this month '
                    . ($revGrowth >= 0 ? '▲' : '▼') . ' ' . abs($revGrowth) . '%')
                ->descriptionIcon($revGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revGrowth >= 0 ? 'success' : 'danger')
                ->chart($revenueSpark),

            Stat::make('Cancellation Rate', $cancelRate . '%')
                ->description($cancelledCount . ' cancelled out of ' . $processed . ' processed')
                ->descriptionIcon($cancelRate > 20 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-minus')
                ->color($cancelRate > 20 ? 'danger' : ($cancelRate > 10 ? 'warning' : 'success')),

            Stat::make('Avg. Booking Value', 'Rs. ' . number_format($avgValue))
                ->description('Based on bookings with a price set')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('info'),
        ];
    }
}
