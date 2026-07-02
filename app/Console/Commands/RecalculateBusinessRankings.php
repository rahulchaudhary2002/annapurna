<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessRankHistory;
use App\Services\BusinessRankingService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class RecalculateBusinessRankings extends Command
{
    protected $signature   = 'ranking:recalculate
        {--business= : Recalculate a single business by ID}
        {--snapshot  : Save a rank history snapshot after recalculating (auto on 1st of month)}';

    protected $description = 'Recalculate dynamic ranking scores for all active businesses';

    public function handle(BusinessRankingService $service): int
    {
        $id = $this->option('business');

        // Auto-snapshot on the 1st of the month unless --business is set
        $shouldSnapshot = $this->option('snapshot')
            || (! $id && Carbon::today()->day === 1);

        if ($id) {
            $business = Business::findOrFail((int) $id);
            $service->recalculate($business);
            $this->info("Recalculated ranking for: {$business->name} → {$business->fresh()->ranking_score}");
            return self::SUCCESS;
        }

        $businesses = Business::where('is_active', true)->get();
        $total      = $businesses->count();
        $bar        = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($businesses as $business) {
            $service->recalculate($business);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        if ($shouldSnapshot && $total > 0) {
            $this->snapshotRankHistory($businesses->fresh());
            $this->info("Rank history snapshot saved for {$total} businesses.");
        }

        $this->info("Recalculated rankings for {$total} businesses.");

        return self::SUCCESS;
    }

    private function snapshotRankHistory($businesses): void
    {
        $now   = Carbon::now();
        $month = $now->month;
        $year  = $now->year;
        $total = $businesses->count();

        // Order by effective score to assign positions
        $ranked = $businesses->sortByDesc(fn ($b) =>
            $b->ranking_override ?? $b->ranking_score ?? 0
        )->values();

        foreach ($ranked as $position => $business) {
            $effective = $business->ranking_override ?? $business->ranking_score ?? 0;

            BusinessRankHistory::updateOrCreate(
                [
                    'business_id'    => $business->id,
                    'recorded_year'  => $year,
                    'recorded_month' => $month,
                ],
                [
                    'ranking_score'    => $business->ranking_score ?? 0,
                    'ranking_override' => $business->ranking_override,
                    'effective_score'  => $effective,
                    'position'         => $position + 1,
                    'total_businesses' => $total,
                    'created_at'       => $now,
                ]
            );
        }
    }
}
