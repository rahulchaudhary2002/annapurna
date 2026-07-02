<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class BusinessRankHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'business_id', 'ranking_score', 'ranking_override', 'effective_score',
        'position', 'total_businesses', 'recorded_month', 'recorded_year', 'created_at',
    ];

    protected $casts = [
        'ranking_score'    => 'float',
        'ranking_override' => 'float',
        'effective_score'  => 'float',
        'created_at'       => 'datetime',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function getPeriodLabelAttribute(): string
    {
        return Carbon::create($this->recorded_year, $this->recorded_month)->format('M Y');
    }
}
