<?php

namespace App\Factories;

use App\CancellationEvent;
use App\Event;

class CancellationEventFactory {
    public static function create($tripPart) {
        $event = new CancellationEvent;
        $event->save();

        $parentEvent = new Event;
        $parentEvent->trip_part_id = $tripPart->id;
        $parentEvent->details_id = $event->id;
        $parentEvent->details_type = get_class($event);
        $parentEvent->severity = "CRITICAL";
        $parentEvent->save();

        return $event;
    }
}
