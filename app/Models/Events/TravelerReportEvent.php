<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelerReportEvent extends Model
{
    public function event()
    {
        return $this->morphOne('App\Event', 'details');
    }

    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function toHTML()
    {
        return "<b>{{ " . $event->details->author->name . " }}</b>: {{ " . $event->details->message . " }}";
    }
}
