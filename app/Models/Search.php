<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'query'
    ];

    public function videos()
    {
        return $this->belongsToMany('App\Models\Video', 'search_video');
    }
}
