<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\DestinationResource\Pages;
use App\Models\Destination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Destination')->tabs([
                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('excerpt')
                        ->rows(2)
                        ->maxLength(300)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('region'),
                    Forms\Components\TextInput::make('altitude'),
                    Forms\Components\TextInput::make('best_season')
                        ->columnSpanFull(),
                    Forms\Components\Repeater::make('activities')
                        ->schema([
                            Forms\Components\TextInput::make('item')->label('Activity'),
                        ])
                        ->addActionLabel('Add Activity')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Images')->schema([
                    MediaPicker::make('featured_image')
                        ->label('Featured Image'),
                    MediaPicker::make('og_image')
                        ->label('OG Image'),
                    Forms\Components\Repeater::make('gallery')
                        ->schema([
                            MediaPicker::make('image')->required(),
                        ])
                        ->addActionLabel('Add Gallery Image')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('SEO & Settings')->schema([
                    Forms\Components\TextInput::make('order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\Toggle::make('is_featured'),
                    Forms\Components\TextInput::make('meta_title')->columnSpanFull(),
                    Forms\Components\Textarea::make('meta_description')->rows(2)->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('region')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
