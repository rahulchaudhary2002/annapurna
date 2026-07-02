<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use App\Models\ContactSubmission;
use App\Models\Package;
use App\Models\PackageInquiry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class CmsStatsWidget extends BaseWidget
{
    protected static ?int  $sort         = 1;
    protected static bool  $isDiscovered = false;

    protected function getStats(): array
    {
        $newMessages    = ContactSubmission::where('status', 'new')->count();
        $newInquiries   = PackageInquiry::where('status', 'new')->count();
        $totalPackages  = Package::where('is_active', true)->count();

        $now            = Carbon::now();
        $monthStart     = $now->copy()->startOfMonth();
        $monthEnd       = $now->copy()->endOfMonth();

        $paidPackages   = Package::where('is_active', true)
                            ->where('listing_type', 'paid')
                            ->where('paid_until', '>=', $now)
                            ->whereNotNull('daily_rate')
                            ->whereNotNull('paid_from')
                            ->get(['daily_rate', 'paid_from', 'paid_until']);

        $paidActive     = $paidPackages->count();

        $expiringSoon   = $paidPackages->filter(
                            fn ($p) => Carbon::parse($p->paid_until)->lte($now->copy()->addDays(7))
                          )->count();

        // Total listing revenue = daily_rate × full duration for each active paid package
        $totalRevenue   = $paidPackages->sum(function ($p) {
            $days = max(1, (int) Carbon::parse($p->paid_from)->diffInDays(Carbon::parse($p->paid_until)));
            return $p->daily_rate * $days;
        });

        // This month's revenue = daily_rate × days the listing is active within current month
        $monthRevenue   = $paidPackages->sum(function ($p) use ($monthStart, $monthEnd) {
            $start = Carbon::parse($p->paid_from)->max($monthStart);
            $end   = Carbon::parse($p->paid_until)->min($monthEnd);
            $days  = max(0, (int) $start->diffInDays($end, false) + 1);
            return $p->daily_rate * $days;
        });

        $totalBusinesses = Business::where('is_active', true)->count();

        return [
            Stat::make('Active Packages', $totalPackages)
                ->description('Total live packages')
                ->descriptionIcon('heroicon-m-gift')
                ->color('success'),

            Stat::make('Paid Listings', $paidActive)
                ->description('Currently sponsored')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Expiring in 7 Days', $expiringSoon)
                ->description('Paid listings expiring soon')
                ->descriptionIcon('heroicon-m-clock')
                ->color($expiringSoon > 0 ? 'danger' : 'success'),

            Stat::make('Total Listing Revenue', 'Rs. ' . number_format($totalRevenue))
                ->description('From all active paid packages')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Revenue This Month', 'Rs. ' . number_format($monthRevenue))
                ->description($now->format('F Y') . ' listing fees')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),

            Stat::make('New Inquiries', $newInquiries)
                ->description('Unread package inquiries')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color($newInquiries > 0 ? 'danger' : 'success'),

            Stat::make('Active Businesses', $totalBusinesses)
                ->description('Listed on directory')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('primary'),

            Stat::make('New Messages', $newMessages)
                ->description('Unread contact submissions')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($newMessages > 0 ? 'danger' : 'success'),
        ];
    }
}
