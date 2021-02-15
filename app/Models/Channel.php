<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name', 'link', 'searching_result_id'
    ];

    public function searchingResults()
    {
        return $this->hasMany('App\Models\SearchingResult');
    }
}
