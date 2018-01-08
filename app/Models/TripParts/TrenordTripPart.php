<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrenordTripPart extends Model
{
    public function tripPart()
    {
        return $this->morphOne('App\TripPart', 'details');
    }
}
