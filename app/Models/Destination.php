<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Destination extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'excerpt', 'description',
        'region', 'altitude', 'best_season', 'activities',
        'featured_image', 'gallery',
        'is_active', 'is_featured', 'order',
        'meta_title', 'meta_description', 'og_image',
    ];

    protected $casts = [
        'activities' => 'array',
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
