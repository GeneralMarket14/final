<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
      protected $guarded = [];
    
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'ad_user_likes')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
    
      public function viewers()
    {
        return $this->belongsToMany(User::class, 'ad_user_views')->withTimestamps();
    }
}
