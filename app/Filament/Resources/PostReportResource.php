<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostReportResource\Pages;
use App\Models\PostReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostReportResource extends Resource
{
    protected static ?string $model = PostReport::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Moderation';
    protected static ?string $navigationLabel = 'Reported Posts';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = PostReport::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Report Details')->schema([
                Forms\Components\TextInput::make('post_id')
                    ->label('Post ID')
                    ->disabled(),
                Forms\Components\TextInput::make('user_id')
                    ->label('Reporter ID')
                    ->disabled(),
                Forms\Components\TextInput::make('reason')
                    ->disabled(),
                Forms\Components\Textarea::make('details')
                    ->rows(3)
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('ip_address')
                    ->label('Reporter IP')
                    ->disabled(),
            ])->columns(2),

            Forms\Components\Section::make('Admin Response')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'reviewed'  => 'Reviewed',
                        'dismissed' => 'Dismissed',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('admin_notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Post')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'spam'          => 'danger',
                        'inappropriate' => 'danger',
                        'misleading'    => 'warning',
                        'copyright'     => 'warning',
                        default         => 'gray',
                    }),
                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Reporter')
                    ->default('Anonymous'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'reviewed'  => 'success',
                        'dismissed' => 'gray',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reported At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'reviewed'  => 'Reviewed',
                        'dismissed' => 'Dismissed',
                    ]),
                Tables\Filters\SelectFilter::make('reason')
                    ->options([
                        'spam'          => 'Spam',
                        'inappropriate' => 'Inappropriate',
                        'misleading'    => 'Misleading',
                        'copyright'     => 'Copyright',
                        'other'         => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view_post')
                    ->label('View Post')
                    ->icon('heroicon-o-eye')
                    ->url(fn (PostReport $record) => $record->post
                        ? url('/blog/' . $record->post->slug)
                        : null
                    )
                    ->openUrlInNewTab()
                    ->visible(fn (PostReport $record) => $record->post !== null),
                Tables\Actions\Action::make('dismiss')
                    ->label('Dismiss')
                    ->icon('heroicon-o-x-mark')
                    ->color('gray')
                    ->visible(fn (PostReport $record) => $record->status === 'pending')
                    ->action(function (PostReport $record) {
                        $record->update(['status' => 'dismissed']);
                        Notification::make()->title('Report dismissed')->success()->send();
                    }),
                Tables\Actions\Action::make('unpublish_post')
                    ->label('Unpublish Post')
                    ->icon('heroicon-o-eye-slash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PostReport $record) =>
                        $record->status === 'pending' && $record->post?->status === 'published'
                    )
                    ->action(function (PostReport $record) {
                        $record->post?->update(['status' => 'draft']);
                        $record->update(['status' => 'reviewed']);
                        Notification::make()->title('Post unpublished and report marked reviewed')->warning()->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('dismiss_bulk')
                        ->label('Dismiss Selected')
                        ->icon('heroicon-o-x-mark')
                        ->color('gray')
                        ->action(fn ($records) => $records->each->update(['status' => 'dismissed']))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostReports::route('/'),
            'edit'  => Pages\EditPostReport::route('/{record}/edit'),
        ];
    }
}
