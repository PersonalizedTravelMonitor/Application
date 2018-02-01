<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use Notifiable, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // this function defines the relation between trpis and user (One to many)
    public function trips()
    {
        return $this->hasMany('App\Trip');
    }

    public function personalStatistic()
    {
        return $this->hasMany('App\PersonalStatistic');
    }

    public function announcements() {
        return $this->hasMany('App\Announcement');
    }

}
