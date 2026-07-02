<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPostLike extends Model
{
    public $timestamps = false;

    protected $fillable = ['business_post_id', 'user_id'];

    public function post()
    {
        return $this->belongsTo(BusinessPost::class, 'business_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
