<?php

namespace App\TripPartManagers;

use App\TripPart;
use App\Event;
use App\TravelerReportEvent;
use App\DelayEvent;
use App\ExternalAPIs\TrenordAPI;
use Log;

class TrenordTripPartManager implements TripPartManager
{
    public static function getEvents(TripPart $tripPart)
    {
        // chiedi le info a trenord
        $info = TrenordAPI::getTrainInfo($tripPart->details->trainId);
        // capisci cosa vogliono dire
        var_dump($info);
        $info = $info[0];

        $delay = $info["delay"];
        $train = $info["journey_list"][0]["train"];

        $status = $train["status"];

        if($status == "N") {
            // deve ancora partire
        } else if ($status == "V") {
            // in viaggio ?
            $actualStation = $train["actual_station"];
            $actualTime = $train["actual_time"];

            $existingEvent = DelayEvent::where([
                ['station', '=', $actualStation],
                ['amount', '=', $delay],
            ])->first();

            if ($existingEvent) return;

            $event = new DelayEvent;
            $event->amount = $delay;
            $event->station = $actualStation;
            $event->save();

            $parentEvent = new Event;
            $parentEvent->trip_part_id = $tripPart->id;
            $parentEvent->details_id = $event->id;
            $parentEvent->details_type = get_class($event);
            $parentEvent->severity = "INFO";
            $parentEvent->save();
        } else if ($status == "A") {
            $tripPart->is_checked = true;
            $tripPart->save();

            $event = new TravelerReportEvent;
            $event->author_id = 1;
            $event->message = "Train is arrived at destination " . $delay . " minutes late";
            $event->save();

            $parentEvent = new Event;
            $parentEvent->trip_part_id = $tripPart->id;
            $parentEvent->details_id = $event->id;
            $parentEvent->details_type = get_class($event);
            $parentEvent->severity = "INFO";
            $parentEvent->save();
        }
    }
}
