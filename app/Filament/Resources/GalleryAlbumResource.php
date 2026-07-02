<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\GalleryAlbumResource\Pages;
use App\Models\GalleryAlbum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryAlbumResource extends Resource
{
    protected static ?string $model = GalleryAlbum::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Gallery';
    protected static ?string $navigationLabel = 'Albums';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Album Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                        $set('slug', \Str::slug($state ?? ''))
                    )
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->columnSpanFull(),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
                MediaPicker::make('cover_image'),
                Forms\Components\Select::make('type')
                    ->options(['image' => 'Images', 'video' => 'Videos', 'mixed' => 'Mixed'])
                    ->default('image'),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->default(true),
                Forms\Components\Toggle::make('is_featured'),
            ])->columns(2),

            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('meta_title'),
                Forms\Components\Textarea::make('meta_description')->rows(2),
            ])->columns(2)->collapsible(),

            Forms\Components\Section::make('Images in this Album')
                ->description('Add images to this album')
                ->schema([
                    Forms\Components\Repeater::make('images')
                        ->relationship('images')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->image()->directory('gallery/images')
                                ->required()->columnSpan(2),
                            Forms\Components\TextInput::make('title')->columnSpan(2),
                            Forms\Components\Textarea::make('caption')->rows(2)->columnSpan(2),
                            Forms\Components\TextInput::make('alt_text')->columnSpan(2),
                            Forms\Components\TextInput::make('video_url')->url()->label('Video URL (optional)')->columnSpan(2),
                            Forms\Components\Select::make('type')
                                ->options(['image' => 'Image', 'video' => 'Video'])
                                ->default('image')->columnSpan(1),
                            Forms\Components\TextInput::make('order')->numeric()->default(0)->columnSpan(1),
                            Forms\Components\Toggle::make('is_active')->default(true)->columnSpan(1),
                            Forms\Components\Toggle::make('is_featured')->columnSpan(1),
                        ])
                        ->columns(4)
                        ->defaultItems(0)
                        ->addActionLabel('Add Image')
                        ->reorderable('order')
                        ->collapsible(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->square(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('images_count')->counts('images')->label('Images')->badge(),
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
            'index' => Pages\ListGalleryAlbums::route('/'),
            'create' => Pages\CreateGalleryAlbum::route('/create'),
            'edit' => Pages\EditGalleryAlbum::route('/{record}/edit'),
        ];
    }
}
