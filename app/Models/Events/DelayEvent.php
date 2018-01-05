<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DelayEvent extends Model
{
    public function event()
    {
        return $this->morphOne('Event', 'details');
    }
}
