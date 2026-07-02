<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttractionResource\Pages;
use App\Models\Attraction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttractionResource extends Resource
{
    protected static ?string $model = Attraction::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Attraction')->tabs([

                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                            $set('slug', \Illuminate\Support\Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),

                    Forms\Components\Select::make('type')
                        ->options([
                            'natural'    => 'Natural',
                            'cultural'   => 'Cultural',
                            'religious'  => 'Religious',
                            'historical' => 'Historical',
                            'adventure'  => 'Adventure',
                        ])
                        ->placeholder('Select a type'),

                    Forms\Components\TextInput::make('location')
                        ->placeholder('e.g. Pokhara, Kaski'),

                    Forms\Components\TextInput::make('distance_from_pokhara')
                        ->label('Distance from Pokhara')
                        ->placeholder('e.g. 2 km from lakeside'),

                    Forms\Components\TextInput::make('entry_fee')
                        ->placeholder('e.g. NPR 100, Free'),

                    Forms\Components\TextInput::make('opening_hours')
                        ->placeholder('e.g. 6:00 AM – 6:00 PM'),

                    Forms\Components\TextInput::make('best_time_to_visit')
                        ->placeholder('e.g. Oct–Nov, Mar–Apr')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('short_description')
                        ->rows(2)
                        ->maxLength(300)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('description')
                        ->rows(8)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Content')->schema([
                    Forms\Components\TagsInput::make('highlights')
                        ->placeholder('Add highlight and press Enter')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('photos')
                        ->label('Photos')
                        ->disk('public')
                        ->directory('attractions')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->columnSpanFull(),
                ])->columns(1),

                Forms\Components\Tabs\Tab::make('SEO & Settings')->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->default(true),

                    Forms\Components\Toggle::make('is_featured'),

                    Forms\Components\TextInput::make('order')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('meta_title')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('meta_description')
                        ->rows(2)
                        ->columnSpanFull(),
                ])->columns(2),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'natural'    => 'success',
                        'cultural'   => 'warning',
                        'religious'  => 'primary',
                        'historical' => 'info',
                        'adventure'  => 'danger',
                        default      => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'natural'    => 'Natural',
                        'cultural'   => 'Cultural',
                        'religious'  => 'Religious',
                        'historical' => 'Historical',
                        'adventure'  => 'Adventure',
                    ]),

                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation(),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAttractions::route('/'),
            'create' => Pages\CreateAttraction::route('/create'),
            'edit'   => Pages\EditAttraction::route('/{record}/edit'),
        ];
    }
}
