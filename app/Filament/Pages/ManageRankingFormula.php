<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\BusinessRankingService;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageRankingFormula extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = 'Annapurna';
    protected static ?string $navigationLabel = 'Ranking Formula';
    protected static ?int    $navigationSort  = 6;
    protected static string  $view            = 'filament.pages.manage-ranking-formula';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'weight_completeness' => (float) Setting::get('ranking_weight_completeness', 0.10),
            'weight_posts'        => (float) Setting::get('ranking_weight_posts',        0.20),
            'weight_clicks'       => (float) Setting::get('ranking_weight_clicks',       0.30),
            'weight_rating'       => (float) Setting::get('ranking_weight_rating',       0.25),
            'weight_engagement'   => (float) Setting::get('ranking_weight_engagement',   0.15),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Formula')
                    ->description('Score = (ProfileCompleteness × W₁) + (RecentPosts × W₂) + (ProfileClicks × W₃) + (AvgRating × Reviews × W₄) + (Engagement × W₅)')
                    ->schema([
                        Forms\Components\TextInput::make('weight_completeness')
                            ->label('W₁ — Profile Completeness')
                            ->helperText('0–100 score. Calculated once at creation. Updating the profile never changes this.')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(10)
                            ->required(),

                        Forms\Components\TextInput::make('weight_posts')
                            ->label('W₂ — Recent Posts (last 30 days)')
                            ->helperText('Raw count of published posts in the past 30 days.')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(10)
                            ->required(),

                        Forms\Components\TextInput::make('weight_clicks')
                            ->label('W₃ — Profile Clicks (last 30 days)')
                            ->helperText('Unique daily profile visits in the past 30 days.')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(10)
                            ->required(),

                        Forms\Components\TextInput::make('weight_rating')
                            ->label('W₄ — Rating Score')
                            ->helperText('Avg rating × number of approved reviews. E.g. 4.5 stars × 20 reviews = 90.')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(10)
                            ->required(),

                        Forms\Components\TextInput::make('weight_engagement')
                            ->label('W₅ — Engagement (last 30 days)')
                            ->helperText('Post likes + approved comments in the past 30 days.')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(10)
                            ->required(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Weights')
                ->color('primary')
                ->action('saveWeights'),

            Action::make('save_recalculate')
                ->label('Save & Recalculate All')
                ->color('warning')
                ->requiresConfirmation()
                ->modalDescription('This will recalculate ranking scores for all active businesses using the new weights. This may take a moment.')
                ->action('saveAndRecalculate'),
        ];
    }

    public function saveWeights(): void
    {
        $data = $this->form->getState();
        $this->persistWeights($data);

        Notification::make()
            ->title('Ranking weights saved.')
            ->success()
            ->send();
    }

    public function saveAndRecalculate(): void
    {
        $data = $this->form->getState();
        $this->persistWeights($data);

        app(BusinessRankingService::class)->recalculateAll();

        Notification::make()
            ->title('Weights saved and all rankings recalculated.')
            ->success()
            ->send();
    }

    private function persistWeights(array $data): void
    {
        Setting::set('ranking_weight_completeness', (string) $data['weight_completeness']);
        Setting::set('ranking_weight_posts',        (string) $data['weight_posts']);
        Setting::set('ranking_weight_clicks',       (string) $data['weight_clicks']);
        Setting::set('ranking_weight_rating',       (string) $data['weight_rating']);
        Setting::set('ranking_weight_engagement',   (string) $data['weight_engagement']);
    }
}
