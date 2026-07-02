<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\MonthlyReport;
use App\Notifications\MonthlyPerformanceNotification;
use App\Services\MonthlyReportService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateMonthlyReports extends Command
{
    protected $signature = 'reports:monthly
        {--month= : Month number (1–12), defaults to last month}
        {--year=  : Year, defaults to last month\'s year}
        {--send   : Also dispatch email + dashboard notifications after generating}
        {--business= : Only process this business ID}';

    protected $description = 'Generate monthly performance reports for all active businesses';

    public function handle(MonthlyReportService $service): int
    {
        $refDate = Carbon::now()->subMonth();
        $month   = (int) ($this->option('month') ?: $refDate->month);
        $year    = (int) ($this->option('year')  ?: $refDate->year);
        $send    = (bool) $this->option('send');

        $this->info(sprintf('Generating reports for %s %d%s', Carbon::create($year, $month)->format('F'), $year, $send ? ' (+ sending notifications)' : ''));

        $query = Business::where('is_active', true)->whereNotNull('user_id');

        if ($businessId = $this->option('business')) {
            $query->where('id', $businessId);
        }

        $businesses = $query->with('owner', 'packages', 'followers')->get();
        $bar = $this->output->createProgressBar($businesses->count());
        $bar->start();

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
                    $this->newLine();
                    $this->warn("Failed to notify {$business->name}: {$e->getMessage()}");
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Done. {$generated} report(s) generated" . ($send ? ", {$sent} notification(s) sent." : '.'));

        return self::SUCCESS;
    }
}
