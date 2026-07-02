<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\User;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    public function getTabs(): array
    {
        $base = CustomerResource::getEloquentQuery();

        return [
            'all'      => Tab::make('All Customers')
                ->badge($base->count()),
            'verified' => Tab::make('Verified')
                ->badge($base->clone()->whereNotNull('email_verified_at')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn ($q) => $q->whereNotNull('email_verified_at')),
            'bookings' => Tab::make('Have Bookings')
                ->badge($base->clone()->has('bookings')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn ($q) => $q->has('bookings')),
            'business' => Tab::make('Business Owners')
                ->badge($base->clone()->has('ownedBusinesses')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn ($q) => $q->has('ownedBusinesses')),
        ];
    }
}
