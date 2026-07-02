<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PackagePayment extends Model
{
    protected $fillable = [
        'package_id', 'business_id', 'amount', 'daily_rate', 'days',
        'paid_from', 'paid_until', 'payment_method', 'reference', 'status', 'notes',
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'daily_rate' => 'decimal:2',
        'paid_from'  => 'date',
        'paid_until' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'paid');
    }
}
