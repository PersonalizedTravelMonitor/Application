<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TripPart extends Model
{
    public function trips()
    {
        return $this->belongsToMany('App\Trip', 'trips_to_trip_parts');
    }

    public function details()
    {
        return $this->morphTo();
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

     // returns an existing trip part for recycling it
    public static function alreadyExists(Request $request)
    {
        $compatibleTripPart = TripPart::where([
            ['from', '=', $request->from],
            ['to', '=', $request->to]
            // TODO: ALSO ADD TYPE FILTER
        ])->first();

        return $compatibleTripPart;
    }
}
