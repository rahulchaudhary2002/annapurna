<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessReviewResource\Pages;
use App\Models\BusinessReview;
use App\Services\BusinessRankingService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BusinessReviewResource extends Resource
{
    protected static ?string $model = BusinessReview::class;
    protected static ?string $navigationIcon  = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?string $navigationLabel = 'Reviews';
    protected static ?int    $navigationSort  = 5;

    public static function getBadge(): ?string
    {
        $count = BusinessReview::where('is_approved', false)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('business_id')
                ->relationship('business', 'name')
                ->disabled(),
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->disabled(),
            Forms\Components\TextInput::make('rating')->disabled(),
            Forms\Components\TextInput::make('title')->disabled(),
            Forms\Components\Textarea::make('body')->disabled()->rows(3),
            Forms\Components\Toggle::make('is_approved')
                ->label('Approved')
                ->required(),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Review')->schema([
                Infolists\Components\TextEntry::make('business.name')->label('Business'),
                Infolists\Components\TextEntry::make('user.name')->label('Reviewer'),
                Infolists\Components\TextEntry::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state) . str_repeat('☆', 5 - $state)),
                Infolists\Components\TextEntry::make('created_at')->dateTime()->label('Submitted'),
                Infolists\Components\TextEntry::make('title')->label('Title')->placeholder('—'),
                Infolists\Components\TextEntry::make('body')->label('Review')->columnSpanFull()->placeholder('—'),
                Infolists\Components\IconEntry::make('is_approved')->boolean()->label('Approved'),
            ])->columns(2),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Reviewer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state) . str_repeat('☆', 5 - $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->limit(40)
                    ->placeholder('—'),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Approved'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Submitted'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')->label('Approval Status')
                    ->trueLabel('Approved')
                    ->falseLabel('Pending'),
                Tables\Filters\SelectFilter::make('rating')
                    ->options([1=>'1★',2=>'2★',3=>'3★',4=>'4★',5=>'5★']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (BusinessReview $r) => ! $r->is_approved)
                    ->action(function (BusinessReview $record) {
                        $record->update(['is_approved' => true]);
                        app(BusinessRankingService::class)->recalculate($record->business);
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (BusinessReview $r) => $r->is_approved)
                    ->action(function (BusinessReview $record) {
                        $record->update(['is_approved' => false]);
                        app(BusinessRankingService::class)->recalculate($record->business);
                    }),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('bulk_approve')
                    ->label('Approve Selected')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($records) {
                        $service    = app(BusinessRankingService::class);
                        $businessIds = [];
                        $records->each(function ($r) use (&$businessIds) {
                            $r->update(['is_approved' => true]);
                            $businessIds[] = $r->business_id;
                        });
                        \App\Models\Business::whereIn('id', array_unique($businessIds))
                            ->get()->each(fn ($b) => $service->recalculate($b));
                    }),
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBusinessReviews::route('/'),
            'view'  => Pages\ViewBusinessReview::route('/{record}'),
            'edit'  => Pages\EditBusinessReview::route('/{record}/edit'),
        ];
    }
}
