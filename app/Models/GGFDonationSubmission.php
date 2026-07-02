<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GGFDonationSubmission extends Model
{
    protected $table = 'ggf_donation_submissions';

    protected $fillable = [
        'name', 'phone', 'amount', 'screenshot',
        'status', 'admin_notes', 'ip_address', 'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }

    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['status' => 'reviewed', 'read_at' => now()]);
        }
    }
}
