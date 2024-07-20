<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $guarded = [];
    
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'ad_user_likes')->withTimestamps();
    }
}