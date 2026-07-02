<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?string $navigationLabel = 'Contact Messages';

    public static function getBadge(): ?string
    {
        $count = ContactSubmission::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Submission Details')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('subject')->disabled(),
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'title')->disabled(),
                Forms\Components\Textarea::make('message')->rows(5)->disabled()->columnSpanFull(),
            ])->columns(2),
            Forms\Components\Section::make('Status & Notes')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'read' => 'Read',
                        'replied' => 'Replied',
                        'archived' => 'Archived',
                        'spam' => 'Spam',
                    ]),
                Forms\Components\Textarea::make('admin_notes')
                    ->label('Internal Notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Contact Details')->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('email')->copyable(),
                Infolists\Components\TextEntry::make('phone'),
                Infolists\Components\TextEntry::make('subject'),
                Infolists\Components\TextEntry::make('service.title')->label('Interested Service'),
                Infolists\Components\TextEntry::make('created_at')->dateTime()->label('Received'),
            ])->columns(2),
            Infolists\Components\Section::make('Message')->schema([
                Infolists\Components\TextEntry::make('message')->columnSpanFull(),
            ]),
            Infolists\Components\Section::make('Technical Info')->schema([
                Infolists\Components\TextEntry::make('ip_address'),
                Infolists\Components\TextEntry::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'danger',
                        'read' => 'warning',
                        'replied' => 'success',
                        'archived' => 'gray',
                        default => 'gray',
                    }),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('subject')->limit(40),
                Tables\Columns\TextColumn::make('service.title')->label('Service')->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                        'gray' => 'archived',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Received'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['new' => 'New', 'read' => 'Read', 'replied' => 'Replied', 'archived' => 'Archived']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->after(fn(ContactSubmission $record) => $record->markAsRead()),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('reply')
                    ->icon('heroicon-o-envelope')
                    ->url(fn(ContactSubmission $record) => "mailto:{$record->email}?subject=Re: {$record->subject}")
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('mark_read')
                    ->label('Mark as Read')
                    ->action(fn($records) => $records->each->markAsRead())
                    ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'edit' => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
