<?php

namespace App\TripPartManagers;

use App\TripPart;
use App\Event;
use App\TravelerReportEvent;
use App\DelayEvent;
use App\CancellationEvent;
use App\ExternalAPIs\TrenordAPI;
use Notification;
use App\Notifications\GenericNotification;
use Log;
use Carbon\Carbon;

class TrenordTripPartManager implements TripPartManager
{
    public static function getEvents(TripPart $tripPart)
    {
        $trainId = $tripPart->details->internalTrainId;
        $info = TrenordAPI::getTrainInfo($trainId);
        if(!isset($info[0]))
            return;

        $info = $info[0];

        $date = Carbon::createFromFormat('Ymd', $info["date"]);
        if ($date->lt(Carbon::today()))
            return;

        if($info["cancelled"]) {
            $event = new CancellationEvent;
            $event->save();

            $parentEvent = new Event;
            $parentEvent->trip_part_id = $tripPart->id;
            $parentEvent->details_id = $event->id;
            $parentEvent->details_type = get_class($event);
            $parentEvent->severity = "CRITICAL";
            $parentEvent->save();

            echo "Adding cancellation event for tripPart " . $tripPart->id;

            $tripPart->is_checked = true;
            $tripPart->save();
            return;
        }

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
                ['created_at', '>=', Carbon::today()] // make sure only today events are checked
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
            $parentEvent->severity = "WARN";
            $parentEvent->save();

            echo "Adding delay event for tripPart " . $tripPart->id;
            Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train is " . $delay . " minutes late"));
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

            echo "Adding arrival event for tripPart " . $tripPart->id;
            Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train has arrived at destination"));
        }
    }
}
