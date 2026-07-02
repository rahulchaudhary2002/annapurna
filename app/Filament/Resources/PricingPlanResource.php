<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PricingPlanResource\Pages;
use App\Models\PricingPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PricingPlanResource extends Resource
{
    protected static ?string $model = PricingPlan::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Site Features';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Plan Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                        $set('slug', \Str::slug($state ?? ''))
                    ),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('badge')
                    ->placeholder('Most Popular, Best Value'),
                Forms\Components\ColorPicker::make('color')->label('Accent Color'),
                Forms\Components\Textarea::make('description')->rows(2)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Pricing')->schema([
                Forms\Components\TextInput::make('price_monthly')
                    ->label('Monthly Price')
                    ->numeric()->prefix('$'),
                Forms\Components\TextInput::make('price_yearly')
                    ->label('Yearly Price')
                    ->numeric()->prefix('$'),
                Forms\Components\TextInput::make('currency')->default('USD'),
                Forms\Components\TextInput::make('currency_symbol')->default('$'),
            ])->columns(2),

            Forms\Components\Section::make('Features')->schema([
                Forms\Components\Repeater::make('features')
                    ->schema([
                        Forms\Components\TextInput::make('text')->required()->label('Feature'),
                        Forms\Components\Toggle::make('included')->default(true)->label('Included'),
                    ])
                    ->columns(2)
                    ->addActionLabel('Add Feature')
                    ->defaultItems(0)
                    ->reorderable(),
            ]),

            Forms\Components\Section::make('CTA Button & Settings')->schema([
                Forms\Components\TextInput::make('button_text')->default('Get Started'),
                Forms\Components\TextInput::make('button_url')->url(),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_featured')->label('Highlight this plan'),
                Forms\Components\Toggle::make('is_active')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('badge')->badge(),
                Tables\Columns\TextColumn::make('price_monthly')
                    ->money('USD')
                    ->label('Monthly'),
                Tables\Columns\TextColumn::make('price_yearly')
                    ->money('USD')
                    ->label('Yearly'),
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
            'index' => Pages\ListPricingPlans::route('/'),
            'create' => Pages\CreatePricingPlan::route('/create'),
            'edit' => Pages\EditPricingPlan::route('/{record}/edit'),
        ];
    }
}
