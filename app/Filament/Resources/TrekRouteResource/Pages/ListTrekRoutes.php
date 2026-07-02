<?php
namespace App\Filament\Resources\TrekRouteResource\Pages;
use App\Filament\Resources\TrekRouteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListTrekRoutes extends ListRecords {
    protected static string $resource = TrekRouteResource::class;
    protected function getHeaderActions(): array {
        return [Actions\CreateAction::make()];
    }
}
