<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageInquiry extends Model
{
    protected $fillable = [
        'package_id', 'name', 'email', 'phone',
        'travel_date', 'group_size', 'message', 'status', 'ip_address',
    ];

    protected $casts = [
        'travel_date' => 'date',
    ];

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
