<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Slider extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'description', 'image', 'mobile_image',
        'button1_text', 'button1_url', 'button1_style',
        'button2_text', 'button2_url', 'button2_style',
        'badge_text', 'video_url', 'is_active', 'order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
