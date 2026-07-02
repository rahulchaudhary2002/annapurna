<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostEngagement extends Model
{
    public $timestamps = false;

    protected $table = 'post_engagement';

    protected $fillable = ['post_id', 'post_type', 'action', 'user_id', 'ip_address', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForBusinessPost(Builder $query, int $postId): Builder
    {
        return $query->where('post_type', 'business_post')->where('post_id', $postId);
    }

    public function scopeForFeedPost(Builder $query, int $postId): Builder
    {
        return $query->where('post_type', 'feed_post')->where('post_id', $postId);
    }

    public function scopeAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }
}
