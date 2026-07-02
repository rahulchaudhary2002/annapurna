<?php

namespace App\Filament\Resources\BusinessReviewResource\Pages;

use App\Filament\Resources\BusinessReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessReview extends EditRecord
{
    protected static string $resource = BusinessReviewResource::class;

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
