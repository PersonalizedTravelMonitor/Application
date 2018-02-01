<?php

namespace App\TripPartManagers;

use App\TripPart;
use App\Event;
use App\TravelerReportEvent;
use App\DelayEvent;
use App\CancellationEvent;
use App\GenericInformationEvent;
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

        if(!isset($info[0])) {
            return;
        }
        $info = $info[0];

        $date = Carbon::createFromFormat('Ymd', $info["date"]);
        if ($date->lt(Carbon::today())) {
            return;
        }

        if($info["cancelled"]) {
            $event = new CancellationEvent;
            $event->save();

            $parentEvent = new Event;
            $parentEvent->trip_part_id = $tripPart->id;
            $parentEvent->details_id = $event->id;
            $parentEvent->details_type = get_class($event);
            $parentEvent->severity = "CRITICAL";
            $parentEvent->save();

            $tripPart->is_checked = true;
            $tripPart->save();
            return;
        }

        $delay = $info["delay"];
        $train = $info["journey_list"][0]["train"];
        $passList = $info["journey_list"][0]["pass_list"];
        $status = $train["status"];
        if($status == "N") {
            // deve ancora partire
        } else if ($status == "V") {
            // in viaggio ?
            $actualStation = $train["actual_station"];

            foreach($passList as $pl)
            {
                if((isset($pl["actual_data"]["actual_station_name"])) && ($pl["actual_data"]["actual_station_name"] == $tripPart->to))
                {
                    $tripPart->is_checked = true;
                    $tripPart->save();

                    $event = new GenericInformationEvent;
                    $event->message = "Train has arrived at " . $pl["actual_data"]["actual_station_name"] ." " . $delay . " minutes late";
                    $event->save();

                    $parentEvent = new Event;
                    $parentEvent->trip_part_id = $tripPart->id;
                    $parentEvent->details_id = $event->id;
                    $parentEvent->details_type = get_class($event);
                    $parentEvent->severity = "INFO";
                    $parentEvent->save();

                    Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train has arrived at ". $pl["actual_data"]["actual_station_name"]));
                    return ;
                }
            }

            $existingEvent = DelayEvent::where([
                ['station', '=', $actualStation],
                ['amount', '=', $delay],
                ['created_at', '>=', Carbon::today()] // make sure only today events are checked
            ])->first();

            if ($existingEvent) {
                return;
            }

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

            Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train is " . $delay . " minutes late"));
        } else if ($status == "A") {
            $tripPart->is_checked = true;
            $tripPart->save();

            $event = new GenericInformationEvent;
            $event->message = "Train has arrived at destination " . $delay . " minutes late";
            $event->save();

            $parentEvent = new Event;
            $parentEvent->trip_part_id = $tripPart->id;
            $parentEvent->details_id = $event->id;
            $parentEvent->details_type = get_class($event);
            $parentEvent->severity = "INFO";
            $parentEvent->save();

            Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train has arrived at destination"));
        }
    }
}
