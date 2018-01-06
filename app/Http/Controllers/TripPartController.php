<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TripPart;
use App\Event;
use App\TravelerReportEvent;


class TripPartController extends Controller
{
    public function addTravelerReportEvent(TripPart $tripPart, Request $request) {

        $travelerReportEvent = new TravelerReportEvent;
        $travelerReportEvent->message = $request->message;
        $travelerReportEvent->save();

        $event = new Event;
        $event->severity = "INFO";
        $event->trip_part_id = $tripPart->id;
        $event->details_id = $travelerReportEvent->id;
        $event->details_type = get_class($travelerReportEvent);
        $event->save();

        return redirect()->route('trips.show', $tripPart->trip);
    }
}
