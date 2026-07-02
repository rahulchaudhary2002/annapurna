<?php

namespace App\Filament\Resources\GGFDonationResource\Pages;

use App\Filament\Resources\GGFDonationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGGFDonation extends ViewRecord
{
    protected static string $resource = GGFDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
