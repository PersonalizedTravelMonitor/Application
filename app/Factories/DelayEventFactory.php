<?php

namespace App\Factories;

use App\DelayEvent;
use App\Event;

class DelayEventFactory {
    public static function create($tripPart, $amount, $station) {
        $event = new DelayEvent;
        $event->amount = $amount;
        $event->station = $station;
        $event->save();

        $parentEvent = new Event;
        $parentEvent->trip_part_id = $tripPart->id;
        $parentEvent->details_id = $event->id;
        $parentEvent->details_type = get_class($event);
        $parentEvent->severity = "WARN";
        $parentEvent->save();

        return $event;
    }
}
