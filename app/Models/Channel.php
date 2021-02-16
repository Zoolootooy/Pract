<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name', 'link', 'video_id'
    ];

    public function videos()
    {
        return $this->hasMany('App\Models\Video');
    }
}
