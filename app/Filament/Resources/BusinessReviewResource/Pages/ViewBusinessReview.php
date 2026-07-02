<?php

namespace App\Filament\Resources\BusinessReviewResource\Pages;

use App\Filament\Resources\BusinessReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBusinessReview extends ViewRecord
{
    protected static string $resource = BusinessReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
