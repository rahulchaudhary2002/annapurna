<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BusinessReview extends Model
{
    protected $fillable = ['business_id', 'user_id', 'rating', 'title', 'body', 'is_approved'];

    protected $casts = ['is_approved' => 'boolean', 'rating' => 'integer'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }
}
