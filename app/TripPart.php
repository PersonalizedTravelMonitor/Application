<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripPart extends Model
{
    public function trip()
    {
        return $this->belongsTo('App\Trip');
    }

    public function trenordTrip() {
        return $this->belongsTo('App\TrenordTripPart', 'child_id');
    }   

    public function details() {
        switch ($this->child_type) {
            case 'TrenordTripPart':
                return $this->trenordTrip();
                break;
            default:
                throw new Exception('Invalid type ' . $this->child_type . ' for TripPart');
                break;
        }
    } 
}
