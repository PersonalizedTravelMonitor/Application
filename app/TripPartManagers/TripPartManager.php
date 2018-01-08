<?php

namespace App\TripPartManagers;

use App\TripPart;

interface TripPartManager
{
    public function getEvents(TripPart $tripPart);
}
