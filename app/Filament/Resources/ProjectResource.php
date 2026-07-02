<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Project')->tabs([
                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->columnSpanFull(),
                    Forms\Components\Textarea::make('excerpt')->rows(2)->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')->columnSpanFull(),
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name', fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('type', 'project'))
                        ->searchable()->preload()->createOptionForm([
                            Forms\Components\TextInput::make('name')->required(),
                            Forms\Components\Hidden::make('type')->default('project'),
                        ]),
                    Forms\Components\Select::make('tags')
                        ->relationship('tags', 'name', fn (\Illuminate\Database\Eloquent\Builder $query) => $query->where('type', 'project'))
                        ->multiple()->searchable()->preload(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Project Info')->schema([
                    Forms\Components\TextInput::make('client'),
                    Forms\Components\TextInput::make('location'),
                    Forms\Components\TextInput::make('year'),
                    Forms\Components\TextInput::make('duration'),
                    Forms\Components\TextInput::make('website')->url(),
                    Forms\Components\Repeater::make('highlights')
                        ->schema([Forms\Components\TextInput::make('text')->required()])
                        ->addActionLabel('Add Highlight')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Images')->schema([
                    MediaPicker::make('image')
                        ->label('Thumbnail'),
                    MediaPicker::make('featured_image')
                        ->label('Detail Banner'),
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
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('category.name')->badge(),
                Tables\Columns\TextColumn::make('client')->limit(25),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('order')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
