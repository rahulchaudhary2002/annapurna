<?php

namespace App\Notifications;

use App\Models\MonthlyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class MonthlyPerformanceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly MonthlyReport $report) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $periodLabel = Carbon::create($this->report->period_year, $this->report->period_month)->format('F Y');

        return (new MailMessage)
            ->subject("Your {$periodLabel} Performance Report — Annapurna Region")
            ->view('emails.monthly-report', ['report' => $this->report]);
    }

    public function toDatabase(object $notifiable): array
    {
        $periodLabel = Carbon::create($this->report->period_year, $this->report->period_month)->format('F Y');
        $data        = $this->report->report_data;

        return [
            'type'         => 'monthly_report',
            'title'        => "Your {$periodLabel} Performance Report is Ready",
            'message'      => sprintf(
                '%s — %d profile views, %d inquiries this month.',
                $this->report->business?->name ?? 'Your account',
                $data['profile_views'] ?? 0,
                collect($data['packages'] ?? [])->sum('inquiries')
            ),
            'report_id'    => $this->report->id,
            'business_id'  => $this->report->business_id,
            'period_label' => $periodLabel,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
