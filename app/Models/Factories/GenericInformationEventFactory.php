<?php

namespace App\Factories;

use App\GenericInformationEvent;
use App\Event;

class GenericInformationEventFactory {
    public static function create($tripPart, $message) {
        $event = new GenericInformationEvent;
        $event->message = $message;
        $event->save();

        $parentEvent = new Event;
        $parentEvent->trip_part_id = $tripPart->id;
        $parentEvent->details_id = $event->id;
        $parentEvent->details_type = get_class($event);
        $parentEvent->severity = "INFO";
        $parentEvent->save();

        return $event;
    }
}
