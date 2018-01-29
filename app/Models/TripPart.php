<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function todayEvents()
    {
        return $this->events()->where('created_at', '>=', Carbon::today());
    }

    public function users()
    {
        $users = [];
        foreach ($this->trips as $trip) {
            array_push($users, $trip->user);
        }
        return $users;
    }

     // returns an existing trip part for recycling it
    public static function findIfExisting($details)
    {
        $compatibleTripParts = TripPart::where([
            ['from', '=', $details['from'] ],
            ['to', '=', $details['to'] ],
            ['details_type', '=', $details['type'] ]
        ])->get();

        foreach($compatibleTripParts as $ctp) {
            if($ctp->details->trainId == $details['trainId'])
                return $ctp;
        }

        return null;
    }
}
