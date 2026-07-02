<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Package extends Model
{
    use HasSlug;

    protected $fillable = [
        'business_id', 'name', 'slug', 'price', 'duration', 'duration_days',
        'highlights', 'itinerary', 'photos', 'video_url', 'faqs', 'map_embed',
        'is_active', 'listing_type', 'paid_from', 'paid_until', 'daily_rate',
        'order', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'daily_rate'   => 'decimal:2',
        'highlights'   => 'array',
        'itinerary'    => 'array',
        'photos'       => 'array',
        'faqs'         => 'array',
        'is_active'    => 'boolean',
        'paid_from'    => 'datetime',
        'paid_until'   => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopeSponsored(Builder $query): Builder
    {
        return $query->where('listing_type', 'paid')
            ->where('paid_from', '<=', now())
            ->where('paid_until', '>=', now());
    }

    public function isSponsored(): bool
    {
        return $this->listing_type === 'paid'
            && $this->paid_from?->lte(now())
            && $this->paid_until?->gte(now());
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->name;
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(PackageInquiry::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(PackagePayment::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'bookable_id')
                    ->where('bookable_type', self::class);
    }
}
