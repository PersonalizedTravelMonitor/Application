<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelerReportEvent extends Model
{
    public function event()
    {
        return $this->morphOne('Event', 'details');
    }
}
