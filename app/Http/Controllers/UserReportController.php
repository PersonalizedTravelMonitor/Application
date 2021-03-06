<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TripPart;
use App\Event;
use App\Trip;
use App\TravelerReportEvent;
use Auth;


class UserReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addTravelerReportEvent(Trip $trip, TripPart $tripPart, Request $request) {
        $travelerReportEvent = new TravelerReportEvent;
        $travelerReportEvent->message = strip_tags($request->message);
        $travelerReportEvent->author_id = Auth::user()->id;

        $travelerReportEvent->save();

        $event = new Event;
        $event->severity = "INFO";
        $event->trip_part_id = $tripPart->id;
        $event->details_id = $travelerReportEvent->id;
        $event->details_type = get_class($travelerReportEvent);
        $event->save();

        return redirect()->route('trips.show', $trip);
    }


    public function removeTravelerReportEvent(Trip $trip, TripPart $tripPart, Event $event) {
        $travelReport = $event->details;
        $travelReport->delete();
        $event->delete();
        return redirect()->route('trips.show', $trip);

    }
}
