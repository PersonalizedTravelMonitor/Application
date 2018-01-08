<?php

namespace App\TripPartManagers;

use App\TripPart;
use App\TravelerReportEvent;

class TrenordTripPartManager implements TripPartManager
{
    public function getEvents(TripPart $tripPart)
    {
        $event = new TravelerReportEvent;
        $event->message = "ciao " . $tripPart->id;
        $event->author_id = "1";
        $event->save();
    }
}
