<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Slide Content')->schema([
                Forms\Components\TextInput::make('badge_text')
                    ->label('Badge / Label')
                    ->placeholder('e.g. #1 Digital Agency')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title')->required()->columnSpanFull(),
                Forms\Components\TextInput::make('subtitle')->columnSpanFull(),
                Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Images')->schema([
                MediaPicker::make('image')
                    ->label('Desktop Image')
                    ->required()
                    ->columnSpan(1),
                MediaPicker::make('mobile_image')
                    ->label('Mobile Image (optional)')
                    ->columnSpan(1),
            ])->columns(2),
            Forms\Components\Section::make('Buttons')->schema([
                Forms\Components\TextInput::make('button1_text')->label('Button 1 Text')->columnSpan(1),
                Forms\Components\TextInput::make('button1_url')->label('Button 1 URL')->url()->columnSpan(1),
                Forms\Components\Select::make('button1_style')
                    ->options(['primary' => 'Primary (filled)', 'outline' => 'Outline'])
                    ->default('primary')
                    ->columnSpan(2),
                Forms\Components\TextInput::make('button2_text')->label('Button 2 Text')->columnSpan(1),
                Forms\Components\TextInput::make('button2_url')->label('Button 2 URL')->url()->columnSpan(1),
                Forms\Components\Select::make('button2_style')
                    ->options(['primary' => 'Primary (filled)', 'outline' => 'Outline'])
                    ->default('outline')
                    ->columnSpan(2),
            ])->columns(2),
            Forms\Components\Section::make('Settings')->schema([
                Forms\Components\TextInput::make('video_url')->label('Background Video URL')->url(),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->default(true),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('subtitle')->limit(40),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
