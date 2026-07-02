<?php

namespace App\Filament\Pages;

use App\Filament\Resources\BookingResource;
use App\Filament\Widgets\DashboardOverviewWidget;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int    $navigationSort = -2;

    public function getHeading(): string
    {
        return 'Dashboard';
    }

    public function getSubheading(): ?string
    {
        return 'Overview of bookings, revenue & partner activity';
    }

    protected function getActions(): array
    {
        return [
            Action::make('new_booking')
                ->label('New Booking')
                ->icon('heroicon-o-plus')
                ->url(BookingResource::getUrl('create'))
                ->color('primary'),
        ];
    }

    public function getWidgets(): array
    {
        return [
            DashboardOverviewWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }
}
