<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SiteAnalyticsWidget;
use Filament\Pages\Page;

class Analytics extends Page
{
    protected static string  $view             = 'filament.pages.analytics';
    protected static ?string $navigationIcon   = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel  = 'Analytics';
    protected static ?string $title            = 'Analytics';
    protected static ?int    $navigationSort   = -1;

    public function getHeading(): string
    {
        return 'Analytics';
    }

    public function getSubheading(): ?string
    {
        return 'Site traffic, engagement metrics & Google Analytics — all in one place.';
    }

    protected function getHeaderWidgets(): array
    {
        return [SiteAnalyticsWidget::class];
    }

    public function getHeaderWidgetsColumns(): int|string|array
    {
        return 1;
    }
}
