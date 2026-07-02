<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuideResource\Pages;
use App\Models\Guide;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuideResource extends Resource
{
    protected static ?string $model = Guide::class;

    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Directory';
    protected static ?string $navigationLabel = 'Guides';
    protected static ?int    $navigationSort  = 2;

    // ── Form ──────────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Tabs::make()->tabs([

                Forms\Components\Tabs\Tab::make('Profile')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->columnSpan(2),

                    Forms\Components\Select::make('user_id')
                        ->label('Linked Account (optional)')
                        ->options(User::pluck('name', 'id'))
                        ->searchable()
                        ->nullable()
                        ->placeholder('No linked account')
                        ->columnSpan(2),

                    Forms\Components\FileUpload::make('photo')
                        ->image()
                        ->directory('guides/photos')
                        ->imageEditor()
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('short_bio')
                        ->label('Short Bio (shown on listing cards)')
                        ->rows(2)
                        ->maxLength(300)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('bio')
                        ->label('Full Bio')
                        ->toolbarButtons(['bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link'])
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Expertise')->schema([
                    Forms\Components\TagsInput::make('specializations')
                        ->label('Specializations')
                        ->placeholder('Add trek / tour name and press Enter')
                        ->columnSpanFull(),

                    Forms\Components\TagsInput::make('languages')
                        ->label('Languages Spoken')
                        ->placeholder('Add language and press Enter')
                        ->columnSpanFull(),

                    Forms\Components\TagsInput::make('certifications')
                        ->label('Certifications & Training')
                        ->placeholder('e.g. TAAN Certified, First Aid')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('experience_years')
                        ->label('Years of Experience')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(60)
                        ->default(0),

                    Forms\Components\TextInput::make('total_treks')
                        ->label('Total Treks Completed')
                        ->numeric()
                        ->minValue(0)
                        ->default(0),

                    Forms\Components\TextInput::make('rating')
                        ->label('Rating (0–5)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(5)
                        ->step(0.1)
                        ->default(0),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Contact & Settings')->schema([
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(30),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('order')
                        ->label('Display Order')
                        ->numeric()
                        ->default(0),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured (shown on home page)'),
                ])->columns(2),

            ])->columnSpanFull(),
        ]);
    }

    // ── Infolist ──────────────────────────────────────────────────────────

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            Infolists\Components\Section::make('Guide Profile')->schema([
                Infolists\Components\ImageEntry::make('photo')
                    ->circular()
                    ->height(100),
                Infolists\Components\TextEntry::make('name')->weight('bold')->size('lg'),
                Infolists\Components\TextEntry::make('short_bio')->columnSpanFull(),
            ])->columns(3),

            Infolists\Components\Section::make('Expertise')->schema([
                Infolists\Components\TextEntry::make('specializations')
                    ->badge()
                    ->color('info')
                    ->separator(','),
                Infolists\Components\TextEntry::make('languages')
                    ->badge()
                    ->color('success')
                    ->separator(','),
                Infolists\Components\TextEntry::make('certifications')
                    ->badge()
                    ->color('warning')
                    ->separator(','),
                Infolists\Components\TextEntry::make('experience_years')->label('Years Experience')->suffix(' yrs'),
                Infolists\Components\TextEntry::make('total_treks')->label('Total Treks'),
                Infolists\Components\TextEntry::make('rating')->suffix(' / 5'),
            ])->columns(3),

            Infolists\Components\Section::make('Contact')->schema([
                Infolists\Components\TextEntry::make('phone')->copyable()->placeholder('—'),
                Infolists\Components\TextEntry::make('email')->copyable()->placeholder('—'),
                Infolists\Components\TextEntry::make('user.name')->label('Linked Account')->placeholder('No account'),
            ])->columns(3),

            Infolists\Components\Section::make('Full Bio')->schema([
                Infolists\Components\TextEntry::make('bio')
                    ->html()
                    ->columnSpanFull()
                    ->placeholder('No bio written yet.'),
            ]),
        ]);
    }

    // ── Table ─────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl(asset('annapurna/img/team/default-guide.jpg')),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('specializations')
                    ->badge()
                    ->color('info')
                    ->separator(',')
                    ->limit(2)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('languages')
                    ->badge()
                    ->color('success')
                    ->separator(',')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('experience_years')
                    ->label('Exp.')
                    ->suffix(' yrs')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_treks')
                    ->label('Treks')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('rating')
                    ->suffix(' ★')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->alignCenter(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Mark Active')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('feature')
                        ->label('Mark Featured')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['is_featured' => true])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGuides::route('/'),
            'create' => Pages\CreateGuide::route('/create'),
            'view'   => Pages\ViewGuide::route('/{record}'),
            'edit'   => Pages\EditGuide::route('/{record}/edit'),
        ];
    }
}
