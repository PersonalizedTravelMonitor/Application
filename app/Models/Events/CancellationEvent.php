<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationEvent extends Model
{
    public function event()
    {
        return $this->morphOne('Event', 'details');
    }
}
