<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchingResult extends Model
{
    protected $fillable = [
        'search_id', 'title', 'link', 'preview', 'channel', 'channelLink'
    ];

    public function search()
    {
        return $this->belongsTo('App\Models\Search');
    }
}
