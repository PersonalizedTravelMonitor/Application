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
        return "<span class=\"tag is-info\">" . $this->event->created_at->format('H:i') . "</span> - <b>" . $this->author->name . "</b>: " . $this->message;
    }
}
