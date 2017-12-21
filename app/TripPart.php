<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripPart extends Model
{
    public function trip()
    {
        return $this->belongsTo('App\Trip');
    }

    // TODO: add methods to get childs   
}
