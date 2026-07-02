<?php

namespace App\Filament\Resources\MonthlyReportResource\Pages;

use App\Filament\Resources\MonthlyReportResource;
use App\Models\Business;
use App\Models\MonthlyReport;
use App\Notifications\MonthlyPerformanceNotification;
use App\Services\MonthlyReportService;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Carbon;

class GenerateMonthlyReports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = MonthlyReportResource::class;
    protected static string $view = 'filament.pages.generate-monthly-reports';
    protected static ?string $title = 'Generate Monthly Reports';

    public array $data = [];

    public function mount(): void
    {
        $prev = Carbon::now()->subMonth();

        $this->form->fill([
            'month'       => $prev->month,
            'year'        => $prev->year,
            'send'        => false,
            'business_id' => null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Select::make('month')
                    ->label('Month')
                    ->options(array_combine(
                        range(1, 12),
                        array_map(fn ($m) => Carbon::create(null, $m)->format('F'), range(1, 12))
                    ))
                    ->required(),
                TextInput::make('year')
                    ->label('Year')
                    ->numeric()
                    ->required()
                    ->default(now()->year),
                Select::make('business_id')
                    ->label('Specific Business (leave blank for all)')
                    ->options(fn () => Business::where('is_active', true)
                        ->whereNotNull('user_id')
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->toArray()
                    )
                    ->searchable()
                    ->nullable()
                    ->placeholder('— All active businesses —')
                    ->helperText('Leave blank to generate for all active businesses'),
                Checkbox::make('send')
                    ->label('Send email + dashboard notifications after generating')
                    ->default(false),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Reports')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
        ];
    }

    public function generate(MonthlyReportService $service): void
    {
        $this->form->validate();
        $formData = $this->form->getState();

        $month      = (int) $formData['month'];
        $year       = (int) $formData['year'];
        $send       = (bool) $formData['send'];
        $businessId = $formData['business_id'] ?? null;

        $query = Business::where('is_active', true)->whereNotNull('user_id');
        if ($businessId) {
            $query->where('id', $businessId);
        }
        $businesses = $query->with('owner', 'packages', 'followers')->get();

        if ($businesses->isEmpty()) {
            Notification::make()->title('No eligible businesses found')->warning()->send();
            return;
        }

        $generated = 0;
        $sent      = 0;

        foreach ($businesses as $business) {
            $report = $service->generateForBusiness($business, $year, $month);
            $generated++;

            if ($send && $business->owner) {
                try {
                    $business->owner->notify(new MonthlyPerformanceNotification($report));
                    $report->update(['status' => 'sent', 'sent_at' => now()]);
                    $sent++;
                } catch (\Throwable $e) {
                    $report->update(['status' => 'failed']);
                }
            }
        }

        $periodLabel = Carbon::create($year, $month)->format('F Y');
        $message = "{$generated} report(s) generated for {$periodLabel}";
        if ($send) {
            $message .= ", {$sent} notification(s) sent.";
        }

        Notification::make()->title($message)->success()->send();
    }
}
