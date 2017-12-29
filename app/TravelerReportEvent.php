<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelerReportEvent extends Model
{
    // TODO
    /* public function trip() {

    } */

    public function event()
    {
        return $this->morphOne('Event', 'details');
    }
}
