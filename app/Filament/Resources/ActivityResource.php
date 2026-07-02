<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Activity')->tabs([

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

                    Forms\Components\Select::make('category')
                        ->options([
                            'water'    => 'Water',
                            'air'      => 'Air',
                            'land'     => 'Land',
                            'cultural' => 'Cultural',
                        ])
                        ->placeholder('Select a category'),

                    Forms\Components\Select::make('difficulty')
                        ->options([
                            'easy'     => 'Easy',
                            'moderate' => 'Moderate',
                            'hard'     => 'Hard',
                            'extreme'  => 'Extreme',
                        ])
                        ->placeholder('Select difficulty'),

                    Forms\Components\TextInput::make('duration')
                        ->placeholder('e.g. 2-3 hours, Full Day'),

                    Forms\Components\TextInput::make('price_from')
                        ->numeric()
                        ->prefix('$')
                        ->placeholder('0.00'),

                    Forms\Components\TextInput::make('best_season')
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

                    Forms\Components\TagsInput::make('inclusions')
                        ->placeholder('Add inclusion and press Enter')
                        ->columnSpanFull(),

                    Forms\Components\TagsInput::make('exclusions')
                        ->placeholder('Add exclusion and press Enter')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('photos')
                        ->label('Photos')
                        ->disk('public')
                        ->directory('activities')
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

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'water'    => 'info',
                        'air'      => 'warning',
                        'land'     => 'success',
                        'cultural' => 'primary',
                        default    => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'easy'     => 'success',
                        'moderate' => 'warning',
                        'hard'     => 'danger',
                        'extreme'  => 'danger',
                        default    => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_from')
                    ->money('USD')
                    ->label('Price From')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'water'    => 'Water',
                        'air'      => 'Air',
                        'land'     => 'Land',
                        'cultural' => 'Cultural',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
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
            'index'  => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit'   => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
