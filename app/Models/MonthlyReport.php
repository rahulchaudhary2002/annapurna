<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class MonthlyReport extends Model
{
    protected $fillable = [
        'user_id', 'business_id', 'period_month', 'period_year',
        'report_data', 'ranking_position', 'ranking_change', 'ranking_tip',
        'status', 'sent_at',
    ];

    protected $casts = [
        'report_data'      => 'array',
        'sent_at'          => 'datetime',
        'ranking_position' => 'integer',
        'ranking_change'   => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function getPeriodLabelAttribute(): string
    {
        return Carbon::create($this->period_year, $this->period_month)->format('F Y');
    }

    public function getRankingDirectionAttribute(): string
    {
        if ($this->ranking_change === null) return 'unknown';
        if ($this->ranking_change > 0) return 'up';
        if ($this->ranking_change < 0) return 'down';
        return 'same';
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeForPeriod($query, int $year, int $month)
    {
        return $query->where('period_year', $year)->where('period_month', $month);
    }
}
