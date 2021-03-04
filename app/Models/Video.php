<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title', 'link', 'preview', 'favorite', 'channel_id', 'published_at'
    ];

    public function searches()
    {
        return $this->belongsToMany('App\Models\Search', 'search_videos');
    }

    public function channel()
    {
        return $this->belongsTo('App\Models\Channel', 'channel_id', 'id');
    }
}
