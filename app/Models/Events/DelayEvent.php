<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DelayEvent extends Model
{
    public function event()
    {
        return $this->morphOne('App\Event', 'details');
    }

    public function toHTML()
    {
        $time = $this->event->created_at->format('H:i');

        if ($this->amount > 0) {
            return "<span class=\"tag is-warning\">" . $time . "</span> - Delay of " . $this->amount . " minutes at " . $this->station;
        }

        if ($this->amount < 0) {
            return "<span class=\"tag is-success\">" . $time . "</span> - " . abs($this->amount) . " minutes early at " . $this->station;
        }

        return "<span class=\"tag is-light\">" . $time . "</span> - Train on time at " . $this->station;

    }
}
