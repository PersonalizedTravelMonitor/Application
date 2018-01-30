<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenericInformationEvent extends Model
{
    public function event()
    {
        return $this->morphOne('App\Event', 'details');
    }

    public function toHTML()
    {

    }
}
