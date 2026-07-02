<?php

namespace App\Filament\Resources\PackageInquiryResource\Pages;

use App\Filament\Resources\PackageInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPackageInquiry extends ViewRecord
{
    protected static string $resource = PackageInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Update Status'),
        ];
    }
}
