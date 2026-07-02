<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Business;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?int $navigationSort = 4;

    public static function getBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Package')->tabs([

                Forms\Components\Tabs\Tab::make('Basic Info')->schema([
                    Forms\Components\Select::make('business_id')
                        ->label('Business')
                        ->options(Business::active()->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('price')
                        ->label('Price (Rs.)')
                        ->required()
                        ->numeric()
                        ->minValue(0),
                    Forms\Components\TextInput::make('duration')
                        ->label('Duration Label')
                        ->required()
                        ->placeholder('e.g. 7 Days / 6 Nights'),
                    Forms\Components\TextInput::make('duration_days')
                        ->label('Duration (days)')
                        ->required()
                        ->numeric()
                        ->minValue(1),
                    Forms\Components\TextInput::make('video_url')
                        ->label('Video URL')
                        ->url()
                        ->placeholder('https://www.youtube.com/embed/...')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Highlights')->schema([
                    Forms\Components\TagsInput::make('highlights')
                        ->label('Highlights')
                        ->hint('Press Enter after each highlight')
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Itinerary')->schema([
                    Forms\Components\Repeater::make('itinerary')
                        ->schema([
                            Forms\Components\TextInput::make('day')
                                ->label('Day #')
                                ->numeric()
                                ->required(),
                            Forms\Components\TextInput::make('title')
                                ->label('Day Title')
                                ->required(),
                            Forms\Components\RichEditor::make('description')
                                ->label('Description')
                                ->toolbarButtons([
                                    'bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link',
                                ])
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Day')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('FAQs')->schema([
                    Forms\Components\Repeater::make('faqs')
                        ->schema([
                            Forms\Components\TextInput::make('question')
                                ->required()
                                ->label('Question')
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('answer')
                                ->rows(2)
                                ->label('Answer')
                                ->columnSpanFull(),
                        ])
                        ->columns(1)
                        ->addActionLabel('Add FAQ')
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Photos & Map')->schema([
                    Forms\Components\FileUpload::make('photos')
                        ->label('Package Photos')
                        ->multiple()
                        ->disk('public')
                        ->directory('packages')
                        ->image()
                        ->maxSize(5120)
                        ->reorderable()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('map_embed')
                        ->label('Google Maps Embed Code')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(1),

                Forms\Components\Tabs\Tab::make('Listing Type')->schema([
                    Forms\Components\Select::make('listing_type')
                        ->label('Listing Type')
                        ->options([
                            'free' => 'Free — visible on business profile only',
                            'paid' => 'Paid — featured on discovery page & home feed',
                        ])
                        ->default('free')
                        ->required()
                        ->live(),
                    Forms\Components\TextInput::make('daily_rate')
                        ->label('Daily Rate (Rs.)')
                        ->numeric()
                        ->minValue(0)
                        ->default(50)
                        ->visible(fn (Forms\Get $get) => $get('listing_type') === 'paid'),
                    Forms\Components\DateTimePicker::make('paid_from')
                        ->label('Promote From')
                        ->visible(fn (Forms\Get $get) => $get('listing_type') === 'paid'),
                    Forms\Components\DateTimePicker::make('paid_until')
                        ->label('Promote Until')
                        ->visible(fn (Forms\Get $get) => $get('listing_type') === 'paid')
                        ->after('paid_from'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('SEO & Settings')->schema([
                    Forms\Components\TextInput::make('order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\TextInput::make('meta_title')->columnSpanFull(),
                    Forms\Components\Textarea::make('meta_description')->rows(2)->columnSpanFull(),
                ])->columns(2),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business.name')
                    ->label('Business')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price (Rs.)')
                    ->money('NPR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration'),
                Tables\Columns\TextColumn::make('listing_type')
                    ->label('Listing')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid'  => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('paid_until')
                    ->label('Paid Until')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inquiries_count')
                    ->label('Inquiries')
                    ->counts('inquiries')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('listing_type')
                    ->options([
                        'free' => 'Free',
                        'paid' => 'Paid',
                    ]),
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->attribute('is_active'),
                Tables\Filters\SelectFilter::make('business_id')
                    ->label('Business')
                    ->options(Business::active()->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Package $record) => route('packages.show', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn ($records) => $records->each->update(['is_active' => true]))
                    ->color('success'),
                Tables\Actions\BulkAction::make('deactivate')
                    ->label('Deactivate')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn ($records) => $records->each->update(['is_active' => false]))
                    ->color('danger'),
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit'   => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
