<?php

namespace App\SearchInfoProviders;

use Storage;
use Carbon\Carbon;
use DateTimeZone;
use App\ExternalAPIs\TrenordAPI;

class TrenordSearchInfoProvider implements SearchInfoProvider
{
    public static function autocompleteFrom($partialFrom) {
        $json = Storage::disk('local')->get('trenord_stations.json');
        $stations = json_decode($json, true);

        $filteredStations = self::filterStations($stations, $partialFrom);
        return response()->json($filteredStations);
    }

    public static function autocompleteTo($partialTo) {
        return self::autocompleteFrom($partialTo);
    }

    public static function searchSolutions($from, $to, $hour) {
        //dd(Carbon::now());
        return TrenordAPI::search($from,$to,Carbon::createFromTime($hour, 0, 0, 'Europe/Rome'));
        
    }

    static function filterStations($stations, $partial) {
        $partial = strtoupper($partial);
        // extract only values from the composite array returned
        return array_values(array_filter($stations, function ($station) use($partial) {
            return substr($station['label'], 0, strlen($partial)) === $partial;
        }));
    }

    static function 

    static function parseStationResponse($body) {
        $body = trim($body);
        $stations = [];

        if ($body !== "") {
            $lines = explode("\n", $body);
            foreach ($lines as $line) {
                $lineParts = explode("|", $line);
                array_push($stations, [
                    'label' => $lineParts[0],
                    'value' => $lineParts[1]
                ]);
            }
        }

        return $stations;
    }
}
