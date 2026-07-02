<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Business;
use App\Models\Package;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class BookingAnalyticsWidget extends Widget
{
    protected static string $view = 'filament.widgets.booking-analytics';
    protected static ?int      $sort         = 1;
    protected static bool      $isLazy       = false;
    protected static bool      $isDiscovered = false;
    protected int|string|array $columnSpan   = 'full';

    public function getViewData(): array
    {
        $now   = Carbon::now();
        $total = Booking::count();

        // Status breakdown with revenue
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        $statusData = [];
        foreach ($statuses as $status) {
            $count   = Booking::where('status', $status)->count();
            $revenue = (float) Booking::where('status', $status)->sum('total_price');
            $statusData[$status] = [
                'count'   => $count,
                'revenue' => $revenue,
                'pct'     => $total > 0 ? round(($count / $total) * 100) : 0,
            ];
        }

        // Type breakdown
        $hotelCount       = Booking::where('bookable_type', Business::class)->count();
        $packageCount     = Booking::where('bookable_type', Package::class)->count();
        $hotelRevenue     = (float) Booking::where('bookable_type', Business::class)
            ->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $packageRevenue   = (float) Booking::where('bookable_type', Package::class)
            ->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $hotelPct         = $total > 0 ? round(($hotelCount / $total) * 100) : 0;
        $packagePct       = $total > 0 ? round(($packageCount / $total) * 100) : 0;

        // Monthly trend — last 6 months
        $monthlyTrend = collect(range(5, 0))->map(function ($m) use ($now) {
            $month = $now->copy()->subMonths($m);
            $y = $month->year;
            $mo = $month->month;
            return [
                'label'     => $month->format('M Y'),
                'total'     => Booking::whereYear('created_at', $y)->whereMonth('created_at', $mo)->count(),
                'confirmed' => Booking::where('status', 'confirmed')->whereYear('created_at', $y)->whereMonth('created_at', $mo)->count(),
                'cancelled' => Booking::where('status', 'cancelled')->whereYear('created_at', $y)->whereMonth('created_at', $mo)->count(),
                'revenue'   => (float) Booking::whereIn('status', ['confirmed', 'completed'])
                    ->whereYear('created_at', $y)->whereMonth('created_at', $mo)->sum('total_price'),
            ];
        });

        // Top hotels by booking count
        $topHotels = Booking::where('bookable_type', Business::class)
            ->selectRaw('bookable_id, COUNT(*) as booking_count, SUM(total_price) as total_revenue')
            ->groupBy('bookable_id')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get()
            ->map(fn ($row) => [
                'name'    => Business::find($row->bookable_id)?->name ?? 'Unknown',
                'count'   => $row->booking_count,
                'revenue' => (float) $row->total_revenue,
            ]);

        // Top packages by booking count
        $topPackages = Booking::where('bookable_type', Package::class)
            ->selectRaw('bookable_id, COUNT(*) as booking_count, SUM(total_price) as total_revenue')
            ->groupBy('bookable_id')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get()
            ->map(fn ($row) => [
                'name'    => Package::find($row->bookable_id)?->name ?? 'Unknown',
                'count'   => $row->booking_count,
                'revenue' => (float) $row->total_revenue,
            ]);

        // Repeat guests (email with > 1 booking)
        $repeatGuests = Booking::selectRaw('guest_email, guest_name, COUNT(*) as booking_count, SUM(total_price) as total_spent')
            ->groupBy('guest_email', 'guest_name')
            ->having('booking_count', '>', 1)
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get();

        // This week vs last week
        $thisWeek = Booking::where('created_at', '>=', $now->copy()->startOfWeek())->count();
        $lastWeek = Booking::whereBetween('created_at', [
            $now->copy()->subWeek()->startOfWeek(),
            $now->copy()->subWeek()->endOfWeek(),
        ])->count();

        // Today
        $today = Booking::whereDate('created_at', $now->toDateString())->count();

        return compact(
            'total', 'statusData',
            'hotelCount', 'packageCount', 'hotelRevenue', 'packageRevenue', 'hotelPct', 'packagePct',
            'monthlyTrend',
            'topHotels', 'topPackages',
            'repeatGuests',
            'thisWeek', 'lastWeek', 'today'
        );
    }
}
