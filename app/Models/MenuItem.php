<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id', 'parent_id', 'title', 'url', 'page_slug',
        'target', 'icon', 'css_class', 'is_active', 'order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function getResolvedUrlAttribute(): string
    {
        if ($this->page_slug) {
            return url($this->page_slug === 'home' ? '/' : "/{$this->page_slug}");
        }
        return $this->url ?? '#';
    }
}
