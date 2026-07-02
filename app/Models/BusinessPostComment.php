<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BusinessPostComment extends Model
{
    protected $fillable = [
        'business_post_id', 'user_id', 'guest_name', 'guest_email', 'body', 'is_approved',
    ];

    protected $casts = ['is_approved' => 'boolean'];

    public function post()
    {
        return $this->belongsTo(BusinessPost::class, 'business_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? 'Guest';
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }
}
