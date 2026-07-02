<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\BusinessResource\Pages;
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Business')->tabs([
                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\Select::make('type')
                        ->required()
                        ->options([
                            'hotel' => 'Hotel',
                            'restaurant' => 'Restaurant',
                            'travel_agency' => 'Travel Agency',
                            'guide' => 'Guide',
                            'porter' => 'Porter',
                        ]),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('subtitle')
                        ->label('Subtitle / Tagline')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('short_description')
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('phone'),
                    Forms\Components\TextInput::make('whatsapp'),
                    Forms\Components\TextInput::make('email')->email(),
                    Forms\Components\TextInput::make('website')->url(),
                    Forms\Components\TextInput::make('address')->columnSpanFull(),
                    Forms\Components\TextInput::make('opening_hours')->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Images')->schema([
                    MediaPicker::make('cover_photo')
                        ->label('Cover Photo'),
                    MediaPicker::make('logo')
                        ->label('Logo'),
                    MediaPicker::make('og_image')
                        ->label('OG Image'),
                    Forms\Components\Repeater::make('gallery')
                        ->schema([
                            MediaPicker::make('image')->required(),
                        ])
                        ->addActionLabel('Add Gallery Image')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('video_url')
                        ->label('Video URL (YouTube embed or direct)')
                        ->url()
                        ->placeholder('https://www.youtube.com/embed/...')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Features')->schema([
                    Forms\Components\Repeater::make('features')
                        ->schema([
                            Forms\Components\TextInput::make('text')
                                ->required()
                                ->label('Feature'),
                        ])
                        ->addActionLabel('Add Feature')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('SEO & Settings')->schema([
                    Forms\Components\TextInput::make('order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\Toggle::make('is_featured'),
                    Forms\Components\Toggle::make('is_verified')
                        ->label('Verified')
                        ->helperText('Mark this business as officially verified'),
                    Forms\Components\TextInput::make('meta_title')->columnSpanFull(),
                    Forms\Components\Textarea::make('meta_description')->rows(2)->columnSpanFull(),
                    Forms\Components\Textarea::make('map_embed')
                        ->label('Map Embed Code')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Ranking')->schema([
                    Forms\Components\TextInput::make('profile_completeness_score')
                        ->label('Profile Completeness Score')
                        ->numeric()
                        ->disabled()
                        ->helperText('Calculated once at creation — not editable'),
                    Forms\Components\TextInput::make('ranking_score')
                        ->label('Calculated Ranking Score')
                        ->numeric()
                        ->disabled()
                        ->helperText('Auto-computed by the ranking formula'),
                    Forms\Components\TextInput::make('ranking_override')
                        ->label('Ranking Override')
                        ->numeric()
                        ->step(0.01)
                        ->minValue(0)
                        ->maxValue(9999.99)
                        ->nullable()
                        ->helperText('Set a manual score to override the formula. Leave blank to use the formula.')
                        ->columnSpanFull(),
                ])->columns(2),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Verified')
                    ->trueColor('success')
                    ->falseColor('gray'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('ranking_score')
                    ->label('Score')
                    ->sortable()
                    ->numeric(decimalPlaces: 2)
                    ->description(fn (Business $record): ?string =>
                        $record->ranking_override !== null
                            ? 'Override: ' . number_format($record->ranking_override, 2)
                            : null
                    ),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'hotel' => 'Hotel',
                        'restaurant' => 'Restaurant',
                        'travel_agency' => 'Travel Agency',
                        'guide' => 'Guide',
                        'porter' => 'Porter',
                    ]),
                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Verified'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (Business $record) => ! $record->is_verified)
                    ->action(function (Business $record) {
                        $record->update([
                            'is_verified' => true,
                            'verified_at' => Carbon::now(),
                        ]);
                        Notification::make()->title('Business verified')->success()->send();
                    }),
                Tables\Actions\Action::make('unverify')
                    ->label('Remove Verification')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Business $record) => $record->is_verified)
                    ->requiresConfirmation()
                    ->action(function (Business $record) {
                        $record->update(['is_verified' => false, 'verified_at' => null]);
                        Notification::make()->title('Verification removed')->warning()->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('feature')
                        ->label('Mark as Featured')
                        ->icon('heroicon-o-star')
                        ->action(fn ($records) => $records->each->update(['is_featured' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('unfeature')
                        ->label('Remove Featured')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->action(fn ($records) => $records->each->update(['is_featured' => false]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('verify_bulk')
                        ->label('Verify Selected')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update([
                            'is_verified' => true,
                            'verified_at' => Carbon::now(),
                        ]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
