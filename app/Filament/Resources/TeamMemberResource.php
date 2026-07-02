<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Basic Info')->schema([
                MediaPicker::make('image')
                    ->columnSpan(1),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        ),
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('position')->required(),
                    Forms\Components\TextInput::make('department'),
                    Forms\Components\TextInput::make('email')->email(),
                    Forms\Components\TextInput::make('phone'),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\Toggle::make('is_featured'),
                    Forms\Components\TextInput::make('order')->numeric()->default(0),
                ])->columnSpan(1),
            ])->columns(2),

            Forms\Components\Section::make('Bio')->schema([
                Forms\Components\Textarea::make('bio')->rows(3)->label('Short Bio (for cards)'),
                Forms\Components\RichEditor::make('full_bio')->label('Full Bio (for detail page)'),
            ]),

            Forms\Components\Section::make('Social Links')->schema([
                Forms\Components\TextInput::make('facebook')->url()->prefix('https://'),
                Forms\Components\TextInput::make('twitter')->url()->prefix('https://'),
                Forms\Components\TextInput::make('linkedin')->url()->prefix('https://'),
                Forms\Components\TextInput::make('instagram')->url()->prefix('https://'),
                Forms\Components\TextInput::make('github')->url()->prefix('https://'),
            ])->columns(2),

            Forms\Components\Section::make('Skills')->schema([
                Forms\Components\TagsInput::make('skills')
                    ->label('Skills (press Enter to add)')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Experience')->schema([
                Forms\Components\Repeater::make('experience')
                    ->schema([
                        Forms\Components\TextInput::make('company')->required(),
                        Forms\Components\TextInput::make('position')->required(),
                        Forms\Components\TextInput::make('period')->placeholder('2020 - 2023'),
                        Forms\Components\Textarea::make('description')->rows(2),
                    ])
                    ->columns(2)
                    ->addActionLabel('Add Experience')
                    ->defaultItems(0)
                    ->collapsible(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('department')->badge(),
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
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
