<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogView extends Model
{
    public $timestamps = false;

    protected $table = 'blog_view';

    protected $fillable = ['post_id', 'user_id', 'ip_address', 'viewed_on', 'created_at'];

    protected $casts = [
        'viewed_on'  => 'date',
        'created_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
