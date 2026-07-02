<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'label', 'value', 'type', 'description', 'order'];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting:{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:{$key}");
    }

    public static function getGroup(string $group): array
    {
        return Cache::remember("settings_group:{$group}", 3600, function () use ($group) {
            return static::where('group', $group)
                ->orderBy('order')
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    protected static function booted(): void
    {
        static::saved(function (Setting $setting) {
            Cache::forget("setting:{$setting->key}");
            Cache::forget("settings_group:{$setting->group}");
        });

        static::deleted(function (Setting $setting) {
            Cache::forget("setting:{$setting->key}");
            Cache::forget("settings_group:{$setting->group}");
        });
    }
}
