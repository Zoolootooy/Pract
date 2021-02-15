<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchingResult extends Model
{
    protected $fillable = [
        'title', 'link', 'preview', 'favorite', 'channel_id'
    ];

    public function search()
    {
        return $this->belongsToMany('App\Models\Search', 'search_searching_result');
    }

    public function channel()
    {
        return $this->belongsTo('App\Models\Channel', 'channel_id', 'id');
    }
}
