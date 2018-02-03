<?php

namespace App;

use App\Exceptions\CantFindTripFieldException;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $casts = [
        'repeatingOn' => 'array',
        'tripPartsInOrder' => 'array'
    ];

    public function from()
    {
        if (count($this->orderedParts) > 0) {
            // get the starting point of the first part
            return $this->orderedParts[0]->from;
        } else {
            throw new CantFindTripFieldException('Can\'t get "from" if a trip has no parts');
        }
    }

    public function to()
    {
        if (count($this->orderedParts) > 0) {
            // get the destination of the last part
            return $this->orderedParts[count($this->parts) - 1]->to;
        } else {
            throw new CantFindTripFieldException('Can\'t get "to" if a trip has no parts');
        }
    }

    // this function defines the relation between trpis and user (One to many)
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function parts() {
        return $this->belongsToMany('App\TripPart', 'trips_to_trip_parts');
    }

    public function orderedParts() {
        $items = implode(",", $this->tripPartsInOrder);
        return $this->parts()->orderByRaw("FIELD(`trip_parts`.`id`," . $items . ")");
    }

    public function partsToCheck() {
        return $this->parts()->where("is_checked", '=', false);
    }

    public function addPartInOrderList($value) {
        $this->tripPartsInOrder = array_merge($this->tripPartsInOrder, [$value]);
    }

    public function isActiveToday() {
        if (sizeof($this->repeatingOn) == 0) {
            return true;
        }

        foreach($this->repeatingOn as $day)
        {
            if(\Carbon\Carbon::now()->dayOfWeek == $day)
            {
                return true;
            }
        }

        return false;
    }
}
