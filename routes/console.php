<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ranking:recalculate')->dailyAt('02:00');

// Generate and send monthly reports on the 1st of each month at 08:00
Schedule::command('reports:monthly --send')->monthlyOn(1, '08:00');
