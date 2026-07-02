<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GGFDonationResource\Pages;
use App\Models\GGFDonationSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GGFDonationResource extends Resource
{
    protected static ?string $model = GGFDonationSubmission::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Communication';
    protected static ?string $navigationLabel = 'Donation Submissions';
    protected static ?int $navigationSort = 6;

    public static function getBadge(): ?string
    {
        $count = GGFDonationSubmission::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Donation Details')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('amount')->disabled(),
            ])->columns(3),
            Forms\Components\Section::make('Status & Notes')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'new'       => 'New',
                        'reviewed'  => 'Reviewed',
                        'confirmed' => 'Confirmed',
                        'rejected'  => 'Rejected',
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
            Infolists\Components\Section::make('Donor Details')->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('phone')->copyable(),
                Infolists\Components\TextEntry::make('amount')
                    ->label('Amount Donated'),
                Infolists\Components\TextEntry::make('created_at')
                    ->dateTime()->label('Submitted'),
            ])->columns(2),
            Infolists\Components\Section::make('Donation Slip')->schema([
                Infolists\Components\ImageEntry::make('screenshot')
                    ->label('Uploaded Screenshot')
                    ->disk('public')
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record?->screenshot && !str_ends_with($record->screenshot, '.pdf')),
                Infolists\Components\TextEntry::make('screenshot')
                    ->label('Download Slip (PDF)')
                    ->formatStateUsing(fn ($state) => $state ? basename($state) : '—')
                    ->url(fn ($record) => $record?->screenshot ? asset('storage/' . $record->screenshot) : null)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record?->screenshot && str_ends_with($record->screenshot, '.pdf')),
            ]),
            Infolists\Components\Section::make('Review')->schema([
                Infolists\Components\TextEntry::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'       => 'danger',
                        'reviewed'  => 'warning',
                        'confirmed' => 'success',
                        'rejected'  => 'gray',
                        default     => 'gray',
                    }),
                Infolists\Components\TextEntry::make('admin_notes')->label('Notes'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('amount')->label('Amount')->badge()->color('success'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'       => 'danger',
                        'reviewed'  => 'warning',
                        'confirmed' => 'success',
                        'rejected'  => 'gray',
                        default     => 'gray',
                    }),
                Tables\Columns\IconColumn::make('screenshot')
                    ->label('Slip')
                    ->boolean()
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('heroicon-o-x-mark')
                    ->getStateUsing(fn ($record) => (bool) $record->screenshot),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable()->label('Submitted'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'       => 'New',
                        'reviewed'  => 'Reviewed',
                        'confirmed' => 'Confirmed',
                        'rejected'  => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->after(fn (GGFDonationSubmission $record) => $record->markAsRead()),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Donation Submission')
                    ->modalDescription('Are you sure you want to delete this donation submission? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete it'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('confirm')
                    ->label('Mark Confirmed')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn ($records) => $records->each->update(['status' => 'confirmed']))
                    ->color('success'),
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGGFDonations::route('/'),
            'view'   => Pages\ViewGGFDonation::route('/{record}'),
            'edit'   => Pages\EditGGFDonation::route('/{record}/edit'),
        ];
    }
}
