<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('order');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    public static function getBySlug(string $slug): ?static
    {
        return Cache::remember("menu:{$slug}", 3600, function () use ($slug) {
            return static::where('slug', $slug)
                ->where('is_active', true)
                ->with(['items' => function ($q) {
                    $q->where('is_active', true)->with(['children' => function ($q2) {
                        $q2->where('is_active', true)->orderBy('order');
                    }]);
                }])
                ->first();
        });
    }

    protected static function booted(): void
    {
        static::saved(function (Menu $menu) { Cache::forget("menu:{$menu->slug}"); });
        static::deleted(function (Menu $menu) { Cache::forget("menu:{$menu->slug}"); });
    }
}
