<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MediaPicker;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Blog Posts';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = Post::where('status', 'pending_review')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Post')->tabs([
                Forms\Components\Tabs\Tab::make('Content')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn(Forms\Set $set, ?string $state) =>
                            $set('slug', \Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('excerpt')
                        ->rows(3)
                        ->maxLength(300)
                        ->helperText('Short description for listing pages')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'h2',
                            'h3',
                            'h4',
                            'bulletList',
                            'orderedList',
                            'blockquote',
                            'link',
                            'attachFiles',
                            'table',
                            'codeBlock',
                            'undo',
                            'redo',
                        ]),
                    MediaPicker::make('featured_image')
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Categorization')->schema([
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name', fn($query) => $query->where('type', 'post'))
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')->required(),
                            Forms\Components\Hidden::make('type')->default('post'),
                        ]),
                    Forms\Components\Select::make('tags')
                        ->relationship('tags', 'name', fn($query) => $query->where('type', 'post'))
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')->required(),
                            Forms\Components\Hidden::make('type')->default('post'),
                        ]),
                    Forms\Components\Select::make('user_id')
                        ->label('Author')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->preload(),
                    Forms\Components\Select::make('blog_type')
                        ->label('Blog Type')
                        ->options([
                            'official' => 'Official — written by site team',
                            'guest'    => 'Guest — external contributor',
                            'business' => 'Business — written by a business owner',
                        ])
                        ->default('official')
                        ->required(),
                    Forms\Components\TextInput::make('read_time')
                        ->placeholder('e.g. 5 min read'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Publishing')->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'draft'          => 'Draft',
                            'pending_review' => 'Pending Review',
                            'published'      => 'Published',
                            'scheduled'      => 'Scheduled',
                            'rejected'       => 'Rejected',
                        ])
                        ->default('draft')
                        ->live()
                        ->required(),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->visible(fn(Forms\Get $get) => $get('status') === 'scheduled'),
                    Forms\Components\Toggle::make('is_featured')->label('Featured Post'),
                    Forms\Components\Toggle::make('allow_comments')->default(true),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->helperText('Leave blank to use post title'),
                    Forms\Components\Textarea::make('meta_description')
                        ->rows(3)
                        ->maxLength(160),
                    Forms\Components\TextInput::make('meta_keywords'),
                    MediaPicker::make('og_image'),
                ])->columns(2),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')->square(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(50)->wrap(),
                Tables\Columns\TextColumn::make('category.name')->badge()->label('Category'),
                Tables\Columns\TextColumn::make('blog_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'guest'    => 'warning',
                        'business' => 'info',
                        default    => 'success',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published'      => 'success',
                        'draft'          => 'gray',
                        'scheduled'      => 'info',
                        'pending_review' => 'warning',
                        'rejected'       => 'danger',
                        default          => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),
                Tables\Columns\TextColumn::make('views')->sortable(),
                Tables\Columns\TextColumn::make('published_at')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft'          => 'Draft',
                        'pending_review' => 'Pending Review',
                        'published'      => 'Published',
                        'scheduled'      => 'Scheduled',
                        'rejected'       => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('blog_type')
                    ->label('Blog Type')
                    ->options(['official' => 'Official', 'guest' => 'Guest', 'business' => 'Business']),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Post $record) => $record->status === 'pending_review')
                    ->action(function (Post $record) {
                        $record->update(['status' => 'published', 'published_at' => now()]);
                        Notification::make()->title('Post approved and published')->success()->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Post $record) => $record->status === 'pending_review')
                    ->requiresConfirmation()
                    ->action(function (Post $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()->title('Post rejected')->warning()->send();
                    }),
                Tables\Actions\Action::make('feature')
                    ->label(fn (Post $record) => $record->is_featured ? 'Unfeature' : 'Feature')
                    ->icon(fn (Post $record) => $record->is_featured ? 'heroicon-o-star' : 'heroicon-o-star')
                    ->color(fn (Post $record) => $record->is_featured ? 'gray' : 'warning')
                    ->action(fn (Post $record) => $record->update(['is_featured' => ! $record->is_featured])),
                Tables\Actions\Action::make('view')
                    ->url(fn(Post $record) => url('/blog/' . $record->slug))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye')
                    ->visible(fn(Post $record) => $record->status === 'published'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_bulk')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update([
                            'status'       => 'published',
                            'published_at' => now(),
                        ]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('feature_bulk')
                        ->label('Mark as Featured')
                        ->icon('heroicon-o-star')
                        ->action(fn ($records) => $records->each->update(['is_featured' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
