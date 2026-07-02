<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TrekRoute extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'excerpt', 'description',
        'duration_days', 'difficulty', 'max_altitude', 'total_distance',
        'price_range', 'group_size_min',
        'start_point', 'end_point', 'best_season',
        'itinerary', 'highlights', 'included_services', 'excluded_services', 'faqs', 'attractions',
        'banner_image', 'featured_image', 'gallery', 'map_embed',
        'is_active', 'is_featured', 'order',
        'meta_title', 'meta_description', 'og_image',
    ];

    protected $casts = [
        'itinerary' => 'array',
        'highlights' => 'array',
        'included_services' => 'array',
        'excluded_services' => 'array',
        'faqs' => 'array',
        'attractions' => 'array',
        'gallery' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
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

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->name;
    }
}
