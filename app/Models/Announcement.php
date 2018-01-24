<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use Notifiable;

    public function author()
    {
        return $this->belongsTo('App\User');
    }
}
