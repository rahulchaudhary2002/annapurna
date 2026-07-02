<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageInquiryResource\Pages;
use App\Models\PackageInquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageInquiryResource extends Resource
{
    protected static ?string $model = PackageInquiry::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?string $navigationLabel = 'Package Inquiries';
    protected static ?int $navigationSort = 7;

    public static function getBadge(): ?string
    {
        $count = PackageInquiry::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Inquiry Details')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('travel_date')->disabled(),
                Forms\Components\TextInput::make('group_size')->disabled(),
            ])->columns(2),
            Forms\Components\Section::make('Status')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'new'       => 'New',
                        'read'      => 'Read',
                        'responded' => 'Responded',
                    ])
                    ->required(),
            ]),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Package')->schema([
                Infolists\Components\TextEntry::make('package.name')
                    ->label('Package')
                    ->url(fn ($record) => $record->package ? route('packages.show', $record->package->slug) : null)
                    ->openUrlInNewTab(),
                Infolists\Components\TextEntry::make('package.business.name')
                    ->label('Business'),
                Infolists\Components\TextEntry::make('created_at')
                    ->dateTime()
                    ->label('Submitted'),
            ])->columns(3),

            Infolists\Components\Section::make('Contact Details')->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('email')->copyable(),
                Infolists\Components\TextEntry::make('phone')->copyable(),
                Infolists\Components\TextEntry::make('travel_date')->date()->label('Travel Date'),
                Infolists\Components\TextEntry::make('group_size')->label('Group Size'),
            ])->columns(2),

            Infolists\Components\Section::make('Message')->schema([
                Infolists\Components\TextEntry::make('message')
                    ->columnSpanFull()
                    ->placeholder('No message provided.'),
            ]),

            Infolists\Components\Section::make('Status')->schema([
                Infolists\Components\TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'       => 'danger',
                        'read'      => 'warning',
                        'responded' => 'success',
                        default     => 'gray',
                    }),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('package.name')
                    ->label('Package')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('package.business.name')
                    ->label('Business')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Inquirer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('travel_date')
                    ->date()
                    ->label('Travel Date')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('group_size')
                    ->label('Pax')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'       => 'danger',
                        'read'      => 'warning',
                        'responded' => 'success',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Received'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'       => 'New',
                        'read'      => 'Read',
                        'responded' => 'Responded',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->after(fn (PackageInquiry $record) =>
                        $record->status === 'new' ? $record->update(['status' => 'read']) : null
                    ),
                Tables\Actions\EditAction::make()->label('Update Status'),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('mark_responded')
                    ->label('Mark as Responded')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn ($records) => $records->each->update(['status' => 'responded']))
                    ->color('success'),
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackageInquiries::route('/'),
            'view'  => Pages\ViewPackageInquiry::route('/{record}'),
            'edit'  => Pages\EditPackageInquiry::route('/{record}/edit'),
        ];
    }
}
