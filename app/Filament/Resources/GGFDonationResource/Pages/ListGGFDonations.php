<?php

namespace App\Filament\Resources\GGFDonationResource\Pages;

use App\Filament\Resources\GGFDonationResource;
use Filament\Resources\Pages\ListRecords;

class ListGGFDonations extends ListRecords
{
    protected static string $resource = GGFDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
