<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'service_id',
        'message', 'status', 'admin_notes',
        'ip_address', 'user_agent', 'read_at', 'replied_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereIn('status', ['new']);
    }

    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['status' => 'read', 'read_at' => now()]);
        }
    }
}
