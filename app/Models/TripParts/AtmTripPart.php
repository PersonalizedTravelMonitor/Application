<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AtmTripPart extends Model
{
    public function tripPart()
    {
        return $this->morphOne('TripPart', 'details');
    }
}
