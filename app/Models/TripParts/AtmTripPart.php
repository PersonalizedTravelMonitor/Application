<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AtmTripPart extends Model
{
    // TODO
    /* public function trip() {

    } */

    public function tripPart()
    {
        return $this->morphOne('TripPart', 'details');
    }
}
