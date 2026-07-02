<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class Cms
{
    public static function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }

    public static function menu(string $slug): ?Menu
    {
        return Cache::remember("menu:{$slug}", 3600, fn () =>
            Menu::where('slug', $slug)
                ->where('is_active', true)
                ->with(['allItems' => fn ($q) => $q->where('is_active', true)->orderBy('order')])
                ->first()
        );
    }

    public static function siteName(): string
    {
        return static::setting('site_name', config('app.name'));
    }

    public static function siteTagline(): string
    {
        return static::setting('site_tagline', '');
    }

    public static function siteLogo(): ?string
    {
        $logo = static::setting('site_logo');
        return $logo ? asset('storage/' . $logo) : null;
    }

    public static function siteFavicon(): ?string
    {
        $fav = static::setting('site_favicon');
        return $fav ? asset('storage/' . $fav) : asset('favicon.ico');
    }

    public static function defaultMetaTitle(): string
    {
        return static::setting('meta_title', static::siteName());
    }

    public static function defaultMetaDescription(): string
    {
        return static::setting('meta_description', '');
    }

    public static function socialLinks(): array
    {
        return [
            'facebook'  => static::setting('social_facebook'),
            'twitter'   => static::setting('social_twitter'),
            'instagram' => static::setting('social_instagram'),
            'linkedin'  => static::setting('social_linkedin'),
            'youtube'   => static::setting('social_youtube'),
            'github'    => static::setting('social_github'),
        ];
    }

    public static function contactInfo(): array
    {
        return [
            'address' => static::setting('contact_address'),
            'phone'   => static::setting('contact_phone'),
            'email'   => static::setting('contact_email'),
            'hours'   => static::setting('contact_hours'),
        ];
    }

    public static function imageUrl(?string $path, string $default = ''): string
    {
        if (!$path) return $default;
        if (str_starts_with($path, 'http')) return $path;
        return asset('storage/' . $path);
    }
}
