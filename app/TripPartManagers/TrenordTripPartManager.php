<?php

namespace App\TripPartManagers;

use App\TripPart;
use App\Event;
use App\TravelerReportEvent;
use App\DelayEvent;
use App\GenericInformationEvent;
use App\ExternalAPIs\TrenordAPI;
use App\Factories\CancellationEventFactory;
use App\Factories\GenericInformationEventFactory;
use App\Factories\DelayEventFactory;
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
            CancellationEventFactory::create($tripPart);
            $tripPart->is_checked = true;
            $tripPart->save();
            return;
        }

        $train = $info["journey_list"][0]["train"];
        $status = $train["status"];
        switch ($status) {
            case 'N':
                // still to depart
                break;
            case 'V':
                // train is travelling
                self::handleTravelling($tripPart, $info);
                break;
            case 'A':
                self::handleArrived($tripPart, $info);
                // train has arrived at destination
                break;
            default:
                break;
        }
    }

    static function handleTravelling($tripPart, $info) {
        $trainId = $tripPart->details->internalTrainId;
        $delay = $info["delay"];
        $train = $info["journey_list"][0]["train"];
        $passList = $info["journey_list"][0]["pass_list"];
        $actualStation = $train["actual_station"];

        foreach($passList as $pl)
        {
            if((isset($pl["actual_data"]["actual_station_name"])) && ($pl["actual_data"]["actual_station_name"] == $tripPart->to))
            {
                $tripPart->is_checked = true;
                $tripPart->save();

                $message = "Train has arrived at " . $pl["actual_data"]["actual_station_name"] ." " . $delay . " minutes late";
                GenericInformationEventFactory::create($tripPart, $message);

                Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train has arrived at ". $pl["actual_data"]["actual_station_name"]));
                return;
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

        DelayEventFactory::create($tripPart, $delay, $actualStation);

        if ($delay > 5) {
            Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train is " . $delay . " minutes late"));
        }
    }

    static function handleArrived($tripPart, $info) {
        $trainId = $tripPart->details->internalTrainId;
        $tripPart->is_checked = true;
        $tripPart->save();

        $delay = $info["delay"];
        $message = "Train has arrived at destination " . $delay . " minutes late";
        GenericInformationEventFactory::create($tripPart, $message);

        Notification::send($tripPart->users(), new GenericNotification("New update for train " . $trainId, "Train has arrived at destination"));
    }
}
