<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedPost extends Model
{
    protected $fillable = [
        'user_id', 'business_id', 'type', 'title', 'content',
        'media', 'video_url', 'link_url', 'link_title', 'link_description', 'link_image',
        'is_sponsored', 'sponsored_until', 'is_published', 'published_at',
        'views_count', 'likes_count', 'comments_count', 'shares_count', 'saves_count',
    ];

    protected $casts = [
        'media'          => 'array',
        'is_sponsored'   => 'boolean',
        'is_published'   => 'boolean',
        'published_at'   => 'datetime',
        'sponsored_until'=> 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(FeedPostLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(FeedPostComment::class)->where('is_published', true);
    }

    public function saves(): HasMany
    {
        return $this->hasMany(FeedPostSave::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(FeedPostShare::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(FeedPostView::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $this->scopePublished($query)
                    ->orderByRaw('(likes_count * 3 + comments_count * 2 + views_count * 0.1) DESC');
    }

    public function scopeSponsored(Builder $query): Builder
    {
        return $this->scopePublished($query)
                    ->where('is_sponsored', true)
                    ->where(function ($q) {
                        $q->whereNull('sponsored_until')
                          ->orWhere('sponsored_until', '>=', now());
                    });
    }

    // ─── Helper Methods ──────────────────────────────────────────────────────

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function isSavedBy(User $user): bool
    {
        return $this->saves()->where('user_id', $user->id)->exists();
    }

    public function getAuthorNameAttribute(): string
    {
        if ($this->business_id && $this->business) {
            return $this->business->name;
        }
        return $this->author ? $this->author->name : 'Unknown';
    }

    public function getAuthorAvatarAttribute(): ?string
    {
        if ($this->business_id && $this->business) {
            return $this->business->cover_photo
                ? asset('storage/' . $this->business->cover_photo)
                : null;
        }
        if ($this->author && $this->author->avatar) {
            return asset('storage/' . $this->author->avatar);
        }
        return null;
    }

    public function getAuthorUrlAttribute(): string
    {
        if ($this->business_id && $this->business) {
            return route('businesses.show', $this->business->slug);
        }
        return '#';
    }
}
