<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileClick extends Model
{
    public $timestamps = false;
    public $updatable = false;

    protected $fillable = ['business_id', 'user_id', 'ip_address', 'source', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
