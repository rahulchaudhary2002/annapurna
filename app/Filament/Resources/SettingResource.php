<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('group')
                    ->options([
                        'general' => 'General',
                        'contact' => 'Contact & Social',
                        'seo' => 'SEO & Analytics',
                        'appearance' => 'Appearance',
                        'email' => 'Email',
                        'advanced' => 'Advanced',
                    ])
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Select::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'richtext' => 'Rich Text',
                        'image' => 'Image',
                        'boolean' => 'Boolean (on/off)',
                        'color' => 'Color',
                        'url' => 'URL',
                        'email' => 'Email',
                        'json' => 'JSON',
                        'number' => 'Number',
                    ])
                    ->required()
                    ->live()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->alphaDash()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull(),
                // Dynamic value field based on type
                Forms\Components\TextInput::make('value')
                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['text', 'url', 'email', 'number']))
                    ->dehydrated(fn (Forms\Get $get) => in_array($get('type'), ['text', 'url', 'email', 'number']))
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('value')
                    ->rows(4)
                    ->visible(fn (Forms\Get $get) => $get('type') === 'textarea')
                    ->dehydrated(fn (Forms\Get $get) => $get('type') === 'textarea')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('value')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'richtext')
                    ->dehydrated(fn (Forms\Get $get) => $get('type') === 'richtext')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('value')
                    ->image()
                    ->directory('settings')
                    ->disk('public')
                    ->formatStateUsing(fn ($state) => is_bool($state) || blank($state) ? null : $state)
                    ->visible(fn (Forms\Get $get) => $get('type') === 'image')
                    ->dehydrated(fn (Forms\Get $get) => $get('type') === 'image')
                    ->columnSpanFull(),
                Forms\Components\Select::make('value')
                    ->options([
                        '1' => 'Enabled',
                        '0' => 'Disabled',
                    ])
                    ->visible(fn (Forms\Get $get) => $get('type') === 'boolean')
                    ->dehydrated(fn (Forms\Get $get) => $get('type') === 'boolean')
                    ->columnSpanFull(),
                Forms\Components\ColorPicker::make('value')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'color')
                    ->dehydrated(fn (Forms\Get $get) => $get('type') === 'color')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')->badge()->sortable(),
                Tables\Columns\TextColumn::make('key')->searchable()->sortable()->copyable(),
                Tables\Columns\TextColumn::make('label')->searchable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('value')->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('order')->sortable(),
            ])
            ->defaultSort('group')
            ->groups(['group'])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'contact' => 'Contact & Social',
                        'seo' => 'SEO',
                        'appearance' => 'Appearance',
                    ]),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
