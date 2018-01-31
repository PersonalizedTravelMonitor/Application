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
        return "<span class=\"tag is-info\">" . $this->event->created_at->format('H:i') . "</span> - <b> Info: </b>" . $this->message;
    }
}
