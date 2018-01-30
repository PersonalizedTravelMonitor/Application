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
        if($this->amount > 0)
            return "- Delay of " . $this->amount . " minutes at " . $this->station;
        else
        {
            if($this->amount < 0)
                return "- Advance of " . abs($this->amount) . " minutes at " . $this->station;
            else
                return "- Train on time at " . $this->station;
        }
    }
}
