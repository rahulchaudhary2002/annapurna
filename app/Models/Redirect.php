<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Redirect extends Model
{
    protected $fillable = ['from_url', 'to_url', 'type', 'is_active', 'hit_count'];

    protected $casts = ['is_active' => 'boolean', 'type' => 'integer'];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
