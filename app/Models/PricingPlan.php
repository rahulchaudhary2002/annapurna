<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PricingPlan extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'description', 'badge',
        'price_monthly', 'price_yearly', 'currency', 'currency_symbol',
        'features', 'button_text', 'button_url', 'color',
        'is_featured', 'is_active', 'order',
    ];

    protected $casts = [
        'features' => 'array',
        'price_monthly' => 'float',
        'price_yearly' => 'float',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
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

    public function getIncludedFeaturesAttribute(): array
    {
        return collect($this->features ?? [])
            ->where('included', true)
            ->pluck('text')
            ->toArray();
    }
}
