<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'query'
    ];

    public function searchingResult()
    {
        return $this->belongsToMany('App\Models\SearchingResult', 'search_searching_result');
    }
}
