<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class GalleryAlbum extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'description', 'cover_image', 'type',
        'is_active', 'is_featured', 'order',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
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

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'album_id')->orderBy('order');
    }

    public function activeImages(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'album_id')
            ->where('is_active', true)
            ->orderBy('order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function getImagesCountAttribute(): int
    {
        return $this->images()->count();
    }

    public function getCoverAttribute(): ?string
    {
        if ($this->cover_image) return $this->cover_image;
        return $this->images()->first()?->image;
    }
}
