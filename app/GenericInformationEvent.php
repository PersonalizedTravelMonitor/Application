<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenericInformationEvent extends Model
{
    public function event()
    {
        return $this->morphOne('Event', 'details');
    }
}
