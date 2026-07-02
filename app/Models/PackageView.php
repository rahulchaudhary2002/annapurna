<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageView extends Model
{
    public $timestamps = false;

    protected $table = 'package_view';

    protected $fillable = ['package_id', 'business_id', 'user_id', 'ip_address', 'source', 'viewed_on', 'created_at'];

    protected $casts = [
        'viewed_on'  => 'date',
        'created_at' => 'datetime',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
