<?php

namespace App\Filament\Resources\GGFDonationResource\Pages;

use App\Filament\Resources\GGFDonationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGGFDonation extends EditRecord
{
    protected static string $resource = GGFDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
