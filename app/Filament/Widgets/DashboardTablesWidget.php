<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\ContactSubmission;
use App\Models\PackageInquiry;
use Filament\Widgets\Widget;

class DashboardTablesWidget extends Widget
{
    protected static string $view   = 'filament.widgets.dashboard-tables';
    protected static ?int   $sort   = 4;
    protected static bool   $isLazy = false;
    protected static bool   $isDiscovered = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $recentBookings  = Booking::with('bookable')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $recentInquiries = PackageInquiry::with('package:id,name')
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $recentMessages  = ContactSubmission::orderByDesc('created_at')
            ->limit(6)
            ->get();

        return compact('recentBookings', 'recentInquiries', 'recentMessages');
    }
}
