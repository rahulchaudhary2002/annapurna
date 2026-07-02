<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Guide extends Model
{
    use HasSlug;

    protected $fillable = [
        'user_id', 'name', 'slug', 'photo', 'bio', 'short_bio',
        'specializations', 'languages', 'certifications',
        'experience_years', 'total_treks', 'rating',
        'phone', 'email',
        'is_active', 'is_featured', 'order',
    ];

    protected $casts = [
        'specializations'  => 'array',
        'languages'        => 'array',
        'certifications'   => 'array',
        'is_active'        => 'boolean',
        'is_featured'      => 'boolean',
        'rating'           => 'decimal:1',
        'experience_years' => 'integer',
        'total_treks'      => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // ── Relationships ──────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // ── Helpers ───────────────────────────────────────────

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('annapurna/img/team/default-guide.jpg');
    }

    public function getStarRatingHtmlAttribute(): string
    {
        $full  = (int) floor($this->rating);
        $half  = ($this->rating - $full) >= 0.5 ? 1 : 0;
        $empty = 5 - $full - $half;
        return str_repeat('<i class="ti-star" style="color:#f5a623;"></i>', $full)
             . str_repeat('<i class="ti-star-half" style="color:#f5a623;"></i>', $half)
             . str_repeat('<i class="ti-star" style="color:#ddd;"></i>', $empty);
    }
}
