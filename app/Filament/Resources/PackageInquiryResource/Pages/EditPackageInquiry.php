<?php

namespace App\Filament\Resources\PackageInquiryResource\Pages;

use App\Filament\Resources\PackageInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageInquiry extends EditRecord
{
    protected static string $resource = PackageInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
