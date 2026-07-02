<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Activity extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'short_description', 'description',
        'category', 'difficulty', 'duration', 'price_from',
        'best_season', 'photos', 'highlights', 'inclusions', 'exclusions',
        'is_active', 'is_featured', 'order',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'photos'      => 'array',
        'highlights'  => 'array',
        'inclusions'  => 'array',
        'exclusions'  => 'array',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'price_from'  => 'decimal:2',
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
