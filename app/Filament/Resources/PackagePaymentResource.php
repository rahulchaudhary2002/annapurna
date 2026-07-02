<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackagePaymentResource\Pages;
use App\Models\PackagePayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackagePaymentResource extends Resource
{
    protected static ?string $model = PackagePayment::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Moderation';
    protected static ?string $navigationLabel = 'Listing Payments';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Package & Business')->schema([
                Forms\Components\Select::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('business_id')
                    ->label('Business')
                    ->relationship('business', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Payment Details')->schema([
                Forms\Components\TextInput::make('amount')
                    ->label('Total Amount (Rs.)')
                    ->numeric()
                    ->required()
                    ->prefix('Rs.'),
                Forms\Components\TextInput::make('daily_rate')
                    ->label('Daily Rate (Rs.)')
                    ->numeric()
                    ->required()
                    ->prefix('Rs.'),
                Forms\Components\TextInput::make('days')
                    ->label('Days Purchased')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\Select::make('status')
                    ->options([
                        'paid'     => 'Paid',
                        'pending'  => 'Pending',
                        'refunded' => 'Refunded',
                    ])
                    ->default('paid')
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Coverage Period')->schema([
                Forms\Components\DatePicker::make('paid_from')
                    ->label('Paid From')
                    ->required(),
                Forms\Components\DatePicker::make('paid_until')
                    ->label('Paid Until')
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Transaction')->schema([
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'cash'          => 'Cash',
                        'bank_transfer' => 'Bank Transfer',
                        'esewa'         => 'eSewa',
                        'khalti'        => 'Khalti',
                    ])
                    ->nullable(),
                Forms\Components\TextInput::make('reference')
                    ->label('Transaction ID / Receipt No')
                    ->nullable(),
                Forms\Components\Textarea::make('notes')
                    ->rows(2)
                    ->columnSpanFull()
                    ->nullable(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business.name')
                    ->label('Business')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->label('Package')
                    ->badge(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('NPR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('days')
                    ->label('Days')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_from')
                    ->label('From')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_until')
                    ->label('Until')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->label('Method'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid'     => 'success',
                        'pending'  => 'warning',
                        'refunded' => 'danger',
                        default    => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recorded')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'paid'     => 'Paid',
                        'pending'  => 'Pending',
                        'refunded' => 'Refunded',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'cash'          => 'Cash',
                        'bank_transfer' => 'Bank Transfer',
                        'esewa'         => 'eSewa',
                        'khalti'        => 'Khalti',
                    ]),
                Tables\Filters\SelectFilter::make('business')
                    ->relationship('business', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPackagePayments::route('/'),
            'create' => Pages\CreatePackagePayment::route('/create'),
            'edit'   => Pages\EditPackagePayment::route('/{record}/edit'),
        ];
    }
}
