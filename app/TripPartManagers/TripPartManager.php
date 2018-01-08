<?php

namespace App\TripPartManagers;

use App\TripPart;

/*
    This interface defines methods to be implemented by the concrete managers
*/
interface TripPartManager
{
    /*
        This method should return any new event about for a certain TripPart
    */
    public function getEvents(TripPart $tripPart);
}
