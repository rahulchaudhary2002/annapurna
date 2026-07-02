<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessProfileView extends Model
{
    public $timestamps = false;

    protected $fillable = ['business_id', 'user_id', 'ip_address', 'viewed_on'];

    protected $casts = ['viewed_on' => 'date'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
