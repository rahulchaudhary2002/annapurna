<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPost extends Model
{
    protected $fillable = [
        'business_id', 'user_id', 'type', 'title', 'content',
        'media', 'link', 'views', 'is_published', 'published_at',
    ];

    protected $casts = [
        'media' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(BusinessPostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(BusinessPostComment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(BusinessPostComment::class)->where('is_approved', true);
    }

    public function isLikedBy(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
