<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Service')->tabs([
                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->columnSpanFull(),
                    Forms\Components\Textarea::make('excerpt')->rows(2)->maxLength(300)->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')->columnSpanFull(),
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name', fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('type', 'service'))
                        ->searchable()->preload(),
                    Forms\Components\TextInput::make('icon')
                        ->label('Icon (FontAwesome class)')
                        ->placeholder('e.g. fas fa-code or heroicon-o-code'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Images')->schema([
                    MediaPicker::make('image')
                        ->label('Card / Thumbnail Image'),
                    MediaPicker::make('featured_image')
                        ->label('Detail Page Banner'),
                    Forms\Components\Repeater::make('gallery')
                        ->schema([
                            MediaPicker::make('image')
                                ->required(),
                            Forms\Components\TextInput::make('caption'),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Gallery Image')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Features')->schema([
                    Forms\Components\Repeater::make('features')
                        ->schema([
                            Forms\Components\TextInput::make('text')->required()->label('Feature Point'),
                            Forms\Components\TextInput::make('icon')->placeholder('fas fa-check'),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Feature')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Settings & SEO')->schema([
                    Forms\Components\TextInput::make('order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\Toggle::make('is_featured'),
                    Forms\Components\TextInput::make('meta_title'),
                    Forms\Components\Textarea::make('meta_description')->rows(2),
                    MediaPicker::make('og_image'),
                ])->columns(2),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->badge(),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('order')->sortable(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
