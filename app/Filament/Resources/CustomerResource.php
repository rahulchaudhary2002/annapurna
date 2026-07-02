<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Booking;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon  = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Directory';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?string $slug            = 'customers';
    protected static ?int    $navigationSort  = 3;

    // Only show non-admin users (no role assigned or role !== super_admin/admin)
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereDoesntHave('roles', fn ($q) => $q->whereIn('name', ['super_admin', 'admin']))
            ->withCount([
                'bookings as bookings_count',
                'ownedBusinesses as businesses_count',
            ]);
    }

    // ── Form (edit basic profile) ─────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Account Details')->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('phone')->nullable()->maxLength(30),
                Forms\Components\TextInput::make('country')->nullable()->maxLength(100),
            ])->columns(2),

            Forms\Components\Section::make('Email Verification')->schema([
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('Verified At')
                    ->nullable()
                    ->helperText('Set to verify manually, clear to unverify.'),
            ]),
        ]);
    }

    // ── Infolist (customer profile + booking history) ─────────────────────

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            Infolists\Components\Section::make('Customer Profile')->schema([
                Infolists\Components\TextEntry::make('name')->weight('bold'),
                Infolists\Components\TextEntry::make('email')->copyable(),
                Infolists\Components\TextEntry::make('phone')->copyable()->placeholder('—'),
                Infolists\Components\TextEntry::make('country')->placeholder('—'),
                Infolists\Components\TextEntry::make('email_verified_at')
                    ->label('Email Verified')
                    ->dateTime()
                    ->placeholder('Not verified'),
                Infolists\Components\TextEntry::make('created_at')
                    ->label('Registered')
                    ->dateTime(),
            ])->columns(3),

            Infolists\Components\Section::make('Booking History')->schema([
                Infolists\Components\RepeatableEntry::make('bookings')
                    ->schema([
                        Infolists\Components\TextEntry::make('booking_number')
                            ->label('Ref #')
                            ->weight('bold')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('bookable.name')
                            ->label('Hotel / Package'),
                        Infolists\Components\TextEntry::make('bookable_type')
                            ->label('Type')
                            ->formatStateUsing(fn ($record) => $record->getTypeLabel()),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => Booking::statusColor($state)),
                        Infolists\Components\TextEntry::make('check_in')
                            ->label('Check-in / Travel')
                            ->formatStateUsing(fn ($record) =>
                                $record->check_in
                                    ? $record->check_in->format('d M Y')
                                    : ($record->travel_date?->format('d M Y') ?? '—')
                            ),
                        Infolists\Components\TextEntry::make('total_price')
                            ->label('Price')
                            ->money('NPR')
                            ->placeholder('—'),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->emptyLabel('No bookings yet.'),
            ]),

            Infolists\Components\Section::make('Owned Businesses')->schema([
                Infolists\Components\RepeatableEntry::make('ownedBusinesses')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('type')->badge(),
                        Infolists\Components\IconColumn::make('is_active')->boolean()->label('Active'),
                        Infolists\Components\IconColumn::make('is_verified')->boolean()->label('Verified'),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->emptyLabel('No businesses registered.'),
            ]),
        ]);
    }

    // ── Table ─────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone')
                    ->copyable()
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('country')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->alignCenter()
                    ->getStateUsing(fn (User $record): bool => $record->email_verified_at !== null),

                Tables\Columns\TextColumn::make('bookings_count')
                    ->label('Bookings')
                    ->alignCenter()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('businesses_count')
                    ->label('Businesses')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->nullable()
                    ->trueLabel('Verified only')
                    ->falseLabel('Unverified only'),

                Tables\Filters\Filter::make('has_bookings')
                    ->label('Has Bookings')
                    ->query(fn (Builder $q) => $q->has('bookings')),

                Tables\Filters\Filter::make('has_businesses')
                    ->label('Has Businesses')
                    ->query(fn (Builder $q) => $q->has('ownedBusinesses')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verify_email')
                        ->label('Mark Email Verified')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['email_verified_at' => now()])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'view'  => Pages\ViewCustomer::route('/{record}'),
            'edit'  => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
