<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Filament\Widgets\BookingAnalyticsWidget;
use App\Filament\Widgets\BookingStatsWidget;
use App\Models\Booking;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    public function getHeading(): string
    {
        return 'Bookings';
    }

    public function getSubheading(): ?string
    {
        return 'Track reservations, revenue, and guest activity in one place.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->url(route('admin.bookings.export'))
                ->openUrlInNewTab(),

            Actions\CreateAction::make()
                ->label('New booking')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BookingStatsWidget::class,
            BookingAnalyticsWidget::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all'       => Tab::make('All')->badge(Booking::count()),
            'pending'   => Tab::make('Pending')->badge(Booking::pending()->count())->badgeColor('warning'),
            'confirmed' => Tab::make('Confirmed')->badge(Booking::confirmed()->count())->badgeColor('success'),
            'cancelled' => Tab::make('Cancelled')->badge(Booking::cancelled()->count())->badgeColor('danger'),
            'completed' => Tab::make('Completed')->badge(Booking::completed()->count())->badgeColor('info'),
        ];
    }
}
