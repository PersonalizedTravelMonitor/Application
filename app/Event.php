<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function tripPart()
    {
        return $this->belongsTo('App\TripPart');
    }

    public function details()
    {
        return $this->morphTo();
    }
}
