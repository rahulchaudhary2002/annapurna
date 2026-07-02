<?php
namespace App\Filament\Resources\TrekRouteResource\Pages;
use App\Filament\Resources\TrekRouteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditTrekRoute extends EditRecord {
    protected static string $resource = TrekRouteResource::class;
    protected function getHeaderActions(): array {
        return [Actions\DeleteAction::make()];
    }
}
