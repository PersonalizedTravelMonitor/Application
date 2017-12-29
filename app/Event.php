<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function event()
    {
        return $this->belongsTo('App\User');
    }

    public function type()
    {
        return $this->morphTo();
    }
}
