<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Attraction extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'short_description', 'description',
        'type', 'location', 'distance_from_pokhara',
        'entry_fee', 'opening_hours', 'best_time_to_visit',
        'photos', 'highlights',
        'is_active', 'is_featured', 'order',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'photos'      => 'array',
        'highlights'  => 'array',
        'is_active'   => 'boolean',
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
