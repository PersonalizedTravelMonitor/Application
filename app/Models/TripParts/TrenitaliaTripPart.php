<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrenitaliaTripPart extends Model
{
    public function tripPart()
    {
        return $this->morphOne('App\TripPart', 'details');
    }
}
