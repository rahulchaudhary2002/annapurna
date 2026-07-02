<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page as CmsPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    protected static ?string $navigationGroup = 'Navigation';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Menu Details')->schema([
                Forms\Components\TextInput::make('name')->required()->columnSpan(1),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->alphaDash()
                    ->helperText('e.g. main-nav, footer-nav, footer-links')
                    ->columnSpan(1),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')->default(true),
            ])->columns(2),

            Forms\Components\Section::make('Menu Items')
                ->description('Add and arrange menu items. Drag to reorder.')
                ->schema([
                    Forms\Components\Repeater::make('allItems')
                        ->relationship('allItems')
                        ->schema([
                            Forms\Components\TextInput::make('title')->required()->columnSpan(2),
                            Forms\Components\Select::make('page_slug')
                                ->label('Link to Page')
                                ->options(fn () => CmsPage::pluck('title', 'slug')->prepend('Custom URL', ''))
                                ->live()
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('url')
                                ->label('Custom URL')
                                ->visible(fn (Forms\Get $get) => !$get('page_slug'))
                                ->url()
                                ->columnSpan(2),
                            Forms\Components\Select::make('parent_id')
                                ->label('Parent Item')
                                ->options(fn (Forms\Get $get, $record) =>
                                    MenuItem::where('menu_id', $record?->menu_id ?? 0)
                                        ->whereNull('parent_id')
                                        ->pluck('title', 'id')
                                )
                                ->columnSpan(2),
                            Forms\Components\Select::make('target')
                                ->options(['_self' => 'Same Tab', '_blank' => 'New Tab'])
                                ->default('_self')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('icon')
                                ->placeholder('heroicon-o-home or fa-home')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('css_class')->columnSpan(1),
                            Forms\Components\TextInput::make('order')->numeric()->default(0)->columnSpan(1),
                            Forms\Components\Toggle::make('is_active')->default(true)->columnSpan(2),
                        ])
                        ->columns(4)
                        ->defaultItems(0)
                        ->addActionLabel('Add Menu Item')
                        ->reorderable('order')
                        ->collapsible(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->badge()->copyable(),
                Tables\Columns\TextColumn::make('allItems_count')
                    ->counts('allItems')
                    ->label('Items')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
