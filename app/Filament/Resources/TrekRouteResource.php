<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\TrekRouteResource\Pages;
use App\Models\TrekRoute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrekRouteResource extends Resource
{
    protected static ?string $model = TrekRoute::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('TrekRoute')->tabs([
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
                    Forms\Components\Select::make('difficulty')
                        ->options([
                            'Easy' => 'Easy',
                            'Moderate' => 'Moderate',
                            'Strenuous' => 'Strenuous',
                        ])
                        ->default('Moderate'),
                    Forms\Components\TextInput::make('duration_days')
                        ->label('Duration (Days)')
                        ->numeric(),
                    Forms\Components\TextInput::make('max_altitude')
                        ->label('Max Altitude'),
                    Forms\Components\TextInput::make('total_distance')
                        ->label('Total Distance'),
                    Forms\Components\TextInput::make('start_point'),
                    Forms\Components\TextInput::make('end_point'),
                    Forms\Components\TextInput::make('best_season')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Itinerary')->schema([
                    Forms\Components\Repeater::make('itinerary')
                        ->schema([
                            Forms\Components\TextInput::make('day')
                                ->label('Day'),
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->label('Title'),
                            Forms\Components\RichEditor::make('description')
                                ->label('Description')
                                ->toolbarButtons([
                                    'bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link',
                                ])
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('altitude')
                                ->label('Altitude'),
                            Forms\Components\TextInput::make('distance')
                                ->label('Distance'),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Day')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Includes/Excludes')->schema([
                    Forms\Components\Repeater::make('included_services')
                        ->label('Included Services')
                        ->schema([
                            Forms\Components\TextInput::make('item')->required()->label('Item'),
                        ])
                        ->addActionLabel('Add Included Item')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                    Forms\Components\Repeater::make('excluded_services')
                        ->label('Excluded Services')
                        ->schema([
                            Forms\Components\TextInput::make('item')->required()->label('Item'),
                        ])
                        ->addActionLabel('Add Excluded Item')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                    Forms\Components\Repeater::make('highlights')
                        ->label('Highlights')
                        ->schema([
                            Forms\Components\TextInput::make('item')->required()->label('Highlight'),
                        ])
                        ->addActionLabel('Add Highlight')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Attractions')->schema([
                    Forms\Components\Repeater::make('attractions')
                        ->label('Place Attractions (shown as flip-cards on the detail page)')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label('Place Name'),
                            Forms\Components\TextInput::make('category')
                                ->label('Category / Country tag')
                                ->placeholder('e.g. Nepal'),
                            Forms\Components\Textarea::make('description')
                                ->rows(2)
                                ->label('Description')
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('location')
                                ->label('Location'),
                            Forms\Components\TextInput::make('rating')
                                ->label('Rating (e.g. 9.5 Superb)'),
                            MediaPicker::make('image')
                                ->label('Image')
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Attraction')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('FAQs')->schema([
                    Forms\Components\Repeater::make('faqs')
                        ->schema([
                            Forms\Components\TextInput::make('question')
                                ->required()
                                ->label('Question')
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('answer')
                                ->required()
                                ->rows(3)
                                ->label('Answer')
                                ->columnSpanFull(),
                        ])
                        ->columns(1)
                        ->addActionLabel('Add FAQ')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Images')->schema([
                    MediaPicker::make('banner_image')
                        ->label('Banner Image (Page Header)'),
                    MediaPicker::make('featured_image')
                        ->label('Featured Image (Card)'),
                    MediaPicker::make('og_image')
                        ->label('OG Image'),
                    Forms\Components\Repeater::make('gallery')
                        ->schema([
                            MediaPicker::make('image')->required(),
                        ])
                        ->addActionLabel('Add Gallery Image')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('map_embed')
                        ->label('Map Embed Code')
                        ->rows(3)
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
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('Days')
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
            'index' => Pages\ListTrekRoutes::route('/'),
            'create' => Pages\CreateTrekRoute::route('/create'),
            'edit' => Pages\EditTrekRoute::route('/{record}/edit'),
        ];
    }
}
