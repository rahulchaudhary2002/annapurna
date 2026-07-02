<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TeamMember extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'position', 'department', 'bio', 'full_bio', 'image',
        'email', 'phone', 'facebook', 'twitter', 'linkedin', 'instagram', 'github',
        'skills', 'experience', 'is_active', 'is_featured', 'order',
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
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
}
