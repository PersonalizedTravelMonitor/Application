<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationEvent extends Model
{
    public function event()
    {
        return $this->morphOne('App\Event', 'details');
    }

    public function toHTML()
    {
        return "<span class=\"tag is-danger is-medium\">Service is CANCELLED!</span>";
    }
}
