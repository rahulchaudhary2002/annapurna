<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Business;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon  = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?string $navigationLabel = 'Bookings';
    protected static ?int    $navigationSort  = 6;

    public static function getBadge(): ?string
    {
        $count = Booking::pending()->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getBadgeColor(): ?string
    {
        return 'warning';
    }

    // ── Form ─────────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ── Create-only: What to book ──────────────────────────────────
            Forms\Components\Section::make('What to Book')
                ->icon('heroicon-o-building-storefront')
                ->visibleOn('create')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('bookable_type')
                        ->label('Booking Type')
                        ->options([
                            Business::class => '🏨 Hotel',
                            Package::class  => '🎒 Package',
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (Forms\Set $set) => $set('bookable_id', null))
                        ->native(false),

                    Forms\Components\Select::make('bookable_id')
                        ->label('Select Hotel / Package')
                        ->options(fn (Forms\Get $get) => match ($get('bookable_type')) {
                            Business::class => Business::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
                            Package::class  => Package::where('is_active', true)->orderBy('name')->pluck('name', 'id'),
                            default         => [],
                        })
                        ->required()
                        ->searchable()
                        ->preload()
                        ->disabled(fn (Forms\Get $get) => blank($get('bookable_type'))),
                ]),

            // ── Guest Information ──────────────────────────────────────────
            Forms\Components\Section::make('Guest Information')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('guest_name')
                        ->label('Full Name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('guest_email')
                        ->label('Email Address')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('guest_phone')
                        ->label('Phone Number')
                        ->tel()
                        ->maxLength(50),

                    Forms\Components\TextInput::make('guests')
                        ->label('Number of Guests')
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->minValue(1),
                ]),

            // ── Date & Stay Details ────────────────────────────────────────
            Forms\Components\Section::make('Date & Stay Details')
                ->icon('heroicon-o-calendar-days')
                ->columns(4)
                ->schema([
                    Forms\Components\DatePicker::make('check_in')
                        ->label('Check-in Date')
                        ->native(false)
                        ->displayFormat('D, d M Y'),

                    Forms\Components\DatePicker::make('check_out')
                        ->label('Check-out Date')
                        ->native(false)
                        ->displayFormat('D, d M Y')
                        ->after('check_in'),

                    Forms\Components\TextInput::make('rooms')
                        ->label('Rooms')
                        ->numeric()
                        ->default(1)
                        ->minValue(1),

                    Forms\Components\DatePicker::make('travel_date')
                        ->label('Travel Date')
                        ->native(false)
                        ->displayFormat('D, d M Y'),
                ]),

            // ── Status & Price ─────────────────────────────────────────────
            Forms\Components\Section::make('Booking Status & Price')
                ->icon('heroicon-o-check-circle')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending'   => 'Pending',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled',
                            'completed' => 'Completed',
                        ])
                        ->default('pending')
                        ->required()
                        ->native(false),

                    Forms\Components\TextInput::make('total_price')
                        ->label('Total Price')
                        ->numeric()
                        ->prefix('Rs.')
                        ->nullable(),
                ]),

            // ── Notes ──────────────────────────────────────────────────────
            Forms\Components\Section::make('Notes')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('special_requests')
                        ->label('Special Requests')
                        ->rows(3)
                        ->placeholder('Any special requests from the guest...'),

                    Forms\Components\Textarea::make('admin_notes')
                        ->label('Admin Notes')
                        ->rows(3)
                        ->placeholder('Internal notes — not visible to guest...'),
                ]),
        ]);
    }

    // ── Infolist (read-only detail view) ──────────────────────────────────

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            // ── Top banner: ref + status side-by-side ──────────────────────
            Infolists\Components\Split::make([
                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\TextEntry::make('booking_number')
                            ->label('Booking Reference')
                            ->weight('bold')
                            ->size('lg')
                            ->copyable()
                            ->icon('heroicon-o-clipboard-document'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Received On')
                            ->dateTime('D, d M Y — H:i')
                            ->icon('heroicon-o-clock'),
                    ])
                    ->grow(false),

                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('Current Status')
                            ->badge()
                            ->size('lg')
                            ->color(fn (string $state): string => Booking::statusColor($state)),

                        Infolists\Components\TextEntry::make('total_price')
                            ->label('Total Amount')
                            ->money('NPR')
                            ->weight('bold')
                            ->size('lg')
                            ->placeholder('Not set')
                            ->color('success'),
                    ])
                    ->grow(true),
            ])->from('md'),

            // ── What was booked ────────────────────────────────────────────
            Infolists\Components\Section::make('What Was Booked')
                ->icon('heroicon-o-building-storefront')
                ->columns(4)
                ->schema([
                    Infolists\Components\TextEntry::make('bookable_type')
                        ->label('Booking Type')
                        ->formatStateUsing(fn ($record) => $record->getTypeLabel())
                        ->badge()
                        ->color(fn ($record) => $record->isHotelBooking() ? 'info' : 'success'),

                    Infolists\Components\TextEntry::make('bookable.name')
                        ->label('Property / Package')
                        ->weight('bold')
                        ->columnSpan(2),

                    Infolists\Components\TextEntry::make('guests')
                        ->label('Total Guests')
                        ->suffix(' person(s)'),
                ]),

            // ── Guest Details ──────────────────────────────────────────────
            Infolists\Components\Section::make('Guest Information')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('guest_name')
                        ->label('Full Name')
                        ->weight('bold')
                        ->icon('heroicon-o-identification'),

                    Infolists\Components\TextEntry::make('guest_email')
                        ->label('Email Address')
                        ->copyable()
                        ->icon('heroicon-o-envelope'),

                    Infolists\Components\TextEntry::make('guest_phone')
                        ->label('Phone Number')
                        ->copyable()
                        ->icon('heroicon-o-phone')
                        ->placeholder('Not provided'),

                    Infolists\Components\TextEntry::make('registered_account')
                        ->label('Account Type')
                        ->state(fn ($record) => $record->user
                            ? 'Registered User — ' . $record->user->name
                            : 'Guest (no account)')
                        ->icon(fn ($record) => $record->user_id
                            ? 'heroicon-o-user-circle'
                            : 'heroicon-o-user-minus')
                        ->color(fn ($record) => $record->user_id ? 'success' : 'gray'),
                ]),

            // ── Dates & Stay ───────────────────────────────────────────────
            Infolists\Components\Section::make('Stay & Date Details')
                ->icon('heroicon-o-calendar-days')
                ->columns(4)
                ->schema([
                    Infolists\Components\TextEntry::make('check_in')
                        ->label('Check-in')
                        ->date('D, d M Y')
                        ->placeholder('—')
                        ->icon('heroicon-o-arrow-right-circle'),

                    Infolists\Components\TextEntry::make('check_out')
                        ->label('Check-out')
                        ->date('D, d M Y')
                        ->placeholder('—')
                        ->icon('heroicon-o-arrow-left-circle'),

                    Infolists\Components\TextEntry::make('duration')
                        ->label('Duration')
                        ->state(fn ($record) => $record->getNights()
                            ? $record->getNights() . ' night' . ($record->getNights() > 1 ? 's' : '')
                            : '—')
                        ->icon('heroicon-o-moon'),

                    Infolists\Components\TextEntry::make('rooms')
                        ->label('Rooms Booked')
                        ->suffix(' room(s)')
                        ->placeholder('—')
                        ->hidden(fn ($record) => $record->isPackageBooking()),

                    Infolists\Components\TextEntry::make('travel_date')
                        ->label('Travel Date')
                        ->date('D, d M Y')
                        ->placeholder('—')
                        ->icon('heroicon-o-map-pin')
                        ->hidden(fn ($record) => $record->isHotelBooking()),
                ]),

            // ── Financial Summary ──────────────────────────────────────────
            Infolists\Components\Section::make('Financial Summary')
                ->icon('heroicon-o-banknotes')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('total_price')
                        ->label('Total Amount Charged')
                        ->money('NPR')
                        ->weight('bold')
                        ->size('lg')
                        ->color('success')
                        ->placeholder('Not set'),

                    Infolists\Components\TextEntry::make('price_per_night')
                        ->label('Per Night (approx.)')
                        ->state(fn ($record) => $record->total_price && $record->getNights()
                            ? 'Rs. ' . number_format($record->total_price / $record->getNights(), 0)
                            : '—')
                        ->hidden(fn ($record) => ! $record->isHotelBooking()),

                    Infolists\Components\TextEntry::make('price_per_guest')
                        ->label('Per Guest (approx.)')
                        ->state(fn ($record) => $record->total_price && $record->guests
                            ? 'Rs. ' . number_format($record->total_price / $record->guests, 0)
                            : '—'),
                ]),

            // ── Special Requests ───────────────────────────────────────────
            Infolists\Components\Section::make('Special Requests')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    Infolists\Components\TextEntry::make('special_requests')
                        ->label('')
                        ->columnSpanFull()
                        ->prose()
                        ->placeholder('No special requests were made.'),
                ]),

            // ── Admin Notes & Metadata ─────────────────────────────────────
            Infolists\Components\Section::make('Admin Notes & Metadata')
                ->icon('heroicon-o-shield-check')
                ->columns(3)
                ->collapsible()
                ->schema([
                    Infolists\Components\TextEntry::make('admin_notes')
                        ->label('Internal Notes')
                        ->columnSpanFull()
                        ->prose()
                        ->placeholder('No admin notes yet. Use Edit to add notes.')
                        ->helperText('Not visible to the guest.'),

                    Infolists\Components\TextEntry::make('ip_address')
                        ->label('Client IP Address')
                        ->copyable()
                        ->placeholder('—')
                        ->icon('heroicon-o-globe-alt'),

                    Infolists\Components\TextEntry::make('created_at')
                        ->label('Booking Received')
                        ->dateTime('d M Y, H:i:s'),

                    Infolists\Components\TextEntry::make('updated_at')
                        ->label('Last Updated')
                        ->dateTime('d M Y, H:i:s')
                        ->since(),
                ]),
        ]);
    }

    // ── Table ─────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->label('Booking #')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('bookable_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($record) => $record->getTypeLabel())
                    ->badge()
                    ->color(fn ($record) => $record->isHotelBooking() ? 'info' : 'success'),

                Tables\Columns\TextColumn::make('bookable.name')
                    ->label('Hotel / Package')
                    ->searchable()
                    ->limit(28),

                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Guest')
                    ->searchable(),

                Tables\Columns\TextColumn::make('guest_email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('guest_phone')
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('guests')
                    ->label('Guests')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('check_in')
                    ->label('Check-in / Travel')
                    ->formatStateUsing(fn ($record) =>
                        $record->check_in
                            ? $record->check_in->format('d M Y')
                            : ($record->travel_date?->format('d M Y') ?? '—')
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => Booking::statusColor($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Price')
                    ->money('NPR')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-calendar-days')
            ->emptyStateHeading('No bookings yet')
            ->emptyStateDescription('When guests reserve a hotel or package, their bookings will appear here.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create your first booking')
                    ->icon('heroicon-o-plus'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Booking Type')
                    ->options([
                        Business::class => 'Hotel',
                        Package::class  => 'Package',
                    ])
                    ->attribute('bookable_type'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->after(fn (Booking $record) =>
                        $record->status === 'pending' ? $record->update(['status' => 'confirmed']) : null
                    ),
                Tables\Actions\EditAction::make()->label('Update'),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('confirm')
                        ->label('Confirm Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'confirmed'])),

                    Tables\Actions\BulkAction::make('cancel')
                        ->label('Cancel Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'cancelled'])),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view'   => Pages\ViewBooking::route('/{record}'),
            'edit'   => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
