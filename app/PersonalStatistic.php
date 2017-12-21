<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalStatistic extends Model
{
    public function personalStatistic()
    {
        return $this->belongsTo('App\User');
    }
}
