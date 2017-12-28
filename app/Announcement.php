<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    //

	// TODO
	// only Admins can publish announcements
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
