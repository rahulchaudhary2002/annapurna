<?php

namespace App\Models;

use App\Services\BusinessRankingService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Business extends Model
{
    use HasSlug;

    protected $fillable = [
        'user_id', 'type', 'name', 'slug', 'subtitle', 'short_description', 'description',
        'phone', 'whatsapp', 'email', 'website', 'address', 'map_embed',
        'cover_photo', 'logo', 'gallery', 'features', 'opening_hours', 'video_url',
        'is_active', 'is_featured', 'is_verified', 'verified_at', 'order',
        'ranking_score', 'ranking_override', 'profile_completeness_score',
        'meta_title', 'meta_description', 'og_image',
    ];

    protected $casts = [
        'gallery'                    => 'array',
        'features'                   => 'array',
        'is_active'                  => 'boolean',
        'is_featured'                => 'boolean',
        'is_verified'                => 'boolean',
        'verified_at'                => 'datetime',
        'ranking_score'              => 'float',
        'ranking_override'           => 'float',
        'profile_completeness_score' => 'integer',
    ];

    protected static function booted(): void
    {
        // Calculate profile completeness once when a business is first created.
        // It is intentionally NOT recomputed on updates — profile edits do not
        // improve ranking. Only initial listing quality affects this score.
        static::created(function (self $business) {
            $score = app(BusinessRankingService::class)->computeProfileCompleteness($business);
            $business->updateQuietly(['profile_completeness_score' => $score]);
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderByRaw('COALESCE(ranking_override, ranking_score, 0) DESC, `order` ASC');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('is_verified', true);
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->name;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->hasMany(BusinessMember::class);
    }

    public function businessPosts()
    {
        return $this->hasMany(BusinessPost::class);
    }

    public function feedPosts(): HasMany
    {
        return $this->hasMany(FeedPost::class);
    }

    public function followers(): HasMany
    {
        return $this->hasMany(BusinessFollow::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function profileViews()
    {
        return $this->hasMany(BusinessProfileView::class);
    }

    public function reviews()
    {
        return $this->hasMany(BusinessReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(BusinessReview::class)->where('is_approved', true);
    }

    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('user_id', $user->id)->exists();
    }

    public function getAverageRatingAttribute(): float
    {
        return round((float) $this->approvedReviews()->avg('rating'), 1);
    }

    public function getReviewCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'bookable_id')
                    ->where('bookable_type', self::class);
    }
}
