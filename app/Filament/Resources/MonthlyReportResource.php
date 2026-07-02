<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthlyReportResource\Pages;
use App\Models\MonthlyReport;
use App\Notifications\MonthlyPerformanceNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class MonthlyReportResource extends Resource
{
    protected static ?string $model = MonthlyReport::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationGroup = 'Reports & Notifications';
    protected static ?string $navigationLabel = 'Monthly Reports';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = MonthlyReport::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Report Period')->schema([
                Forms\Components\Select::make('business_id')
                    ->label('Business')
                    ->relationship('business', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('period_month')
                    ->label('Month')
                    ->options(array_combine(range(1, 12), array_map(fn ($m) => Carbon::create(null, $m)->format('F'), range(1, 12))))
                    ->required(),
                Forms\Components\TextInput::make('period_year')
                    ->label('Year')
                    ->numeric()
                    ->required()
                    ->default(now()->year),
                Forms\Components\Select::make('status')
                    ->options(['pending' => 'Pending', 'sent' => 'Sent', 'failed' => 'Failed'])
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Ranking')->schema([
                Forms\Components\TextInput::make('ranking_position')->numeric()->nullable(),
                Forms\Components\TextInput::make('ranking_change')->numeric()->nullable(),
                Forms\Components\TextInput::make('ranking_tip')->nullable()->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('period_label')
                    ->label('Period')
                    ->getStateUsing(fn (MonthlyReport $r) =>
                        Carbon::create($r->period_year, $r->period_month)->format('F Y')
                    )
                    ->sortable(['period_year', 'period_month']),
                Tables\Columns\TextColumn::make('ranking_position')
                    ->label('Rank #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ranking_change')
                    ->label('Rank Change')
                    ->badge()
                    ->color(fn (?int $state): string => match(true) {
                        $state === null  => 'gray',
                        $state > 0       => 'success',
                        $state < 0       => 'danger',
                        default          => 'gray',
                    })
                    ->formatStateUsing(fn (?int $state): string =>
                        $state === null ? '—'
                        : ($state > 0 ? "▲ {$state}" : ($state < 0 ? "▼ " . abs($state) : '→ No change'))
                    ),
                Tables\Columns\TextColumn::make('profile_views')
                    ->label('Profile Views')
                    ->getStateUsing(fn (MonthlyReport $r) =>
                        number_format($r->report_data['profile_views'] ?? 0)
                    ),
                Tables\Columns\TextColumn::make('inquiries')
                    ->label('Inquiries')
                    ->getStateUsing(fn (MonthlyReport $r) =>
                        collect($r->report_data['packages'] ?? [])->sum('inquiries')
                    ),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent'    => 'success',
                        'pending' => 'warning',
                        'failed'  => 'danger',
                        default   => 'gray',
                    }),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label('Sent At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'sent' => 'Sent', 'failed' => 'Failed']),
                Tables\Filters\SelectFilter::make('period_year')
                    ->label('Year')
                    ->options(array_combine(
                        range(now()->year - 1, now()->year + 1),
                        range(now()->year - 1, now()->year + 1)
                    )),
                Tables\Filters\SelectFilter::make('business')
                    ->relationship('business', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (MonthlyReport $record) =>
                        route('admin.monthly-report.preview', $record->id)
                    )
                    ->openUrlInNewTab()
                    ->visible(fn () => false), // enabled later when preview route exists
                Tables\Actions\Action::make('send')
                    ->label('Send Now')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (MonthlyReport $record) =>
                        in_array($record->status, ['pending', 'failed']) && $record->business?->owner !== null
                    )
                    ->action(function (MonthlyReport $record) {
                        try {
                            $record->business->owner->notify(new MonthlyPerformanceNotification($record));
                            $record->update(['status' => 'sent', 'sent_at' => now()]);
                            Notification::make()->title('Report sent successfully')->success()->send();
                        } catch (\Throwable $e) {
                            $record->update(['status' => 'failed']);
                            Notification::make()->title('Send failed: ' . $e->getMessage())->danger()->send();
                        }
                    }),
                Tables\Actions\Action::make('resend')
                    ->label('Resend')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (MonthlyReport $record) =>
                        $record->status === 'sent' && $record->business?->owner !== null
                    )
                    ->action(function (MonthlyReport $record) {
                        try {
                            $record->business->owner->notify(new MonthlyPerformanceNotification($record));
                            $record->update(['sent_at' => now()]);
                            Notification::make()->title('Report resent')->success()->send();
                        } catch (\Throwable $e) {
                            Notification::make()->title('Resend failed: ' . $e->getMessage())->danger()->send();
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('send_bulk')
                        ->label('Send Selected')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $sent = 0;
                            foreach ($records as $record) {
                                if ($record->business?->owner) {
                                    try {
                                        $record->business->owner->notify(new MonthlyPerformanceNotification($record));
                                        $record->update(['status' => 'sent', 'sent_at' => now()]);
                                        $sent++;
                                    } catch (\Throwable) {
                                        $record->update(['status' => 'failed']);
                                    }
                                }
                            }
                            Notification::make()->title("{$sent} report(s) sent")->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('period_year', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'    => Pages\ListMonthlyReports::route('/'),
            'generate' => Pages\GenerateMonthlyReports::route('/generate'),
        ];
    }
}
