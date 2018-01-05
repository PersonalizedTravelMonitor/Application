<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripPart extends Model
{
    public function trip()
    {
        return $this->belongsTo('App\Trip');
    }

    public function details()
    {
        return $this->morphTo();
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
