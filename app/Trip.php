<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $casts = [
        'repeatingOn' => 'array'
    ];

    // this function defines the relation between trpis and user (One to many)
    public function trip()
    {
        return $this->belongsTo('App\User');
    }

    public function tripParts() {
        return $this->hasMany('App\TripPart');
    }
}
