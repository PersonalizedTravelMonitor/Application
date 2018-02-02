<?php

namespace App\SearchInfoProviders;

use Storage;
use Carbon\Carbon;
use DateTimeZone;
use App\ExternalAPIs\TrenordAPI;
use App\ExternalAPIs\TrenordSearchResultsCleaner;
use Exception;

class TrenordSearchInfoProvider implements SearchInfoProvider
{
    public static function autocompleteFrom($partialFrom) {
        $json = Storage::disk('local')->get('trenord_stations.json');
        $stations = json_decode($json, true);

        return self::filterStations($stations, $partialFrom);
    }

    public static function autocompleteTo($partialTo) {
        return self::autocompleteFrom($partialTo);
    }

    public static function searchSolutions($from, $to, $hours, $minutes) {
        $from = strtoupper(trim($from));
        $to = strtoupper(trim($to));

        if ($from==$to ||
            !self::checkIfValidStation($from, self::autocompleteFrom($from)) ||
            !self::checkIfValidStation($to, self::autocompleteTo($to)) ) {
            return [];
        }

        try {
            $searchResults = TrenordAPI::search($from,$to,Carbon::createFromTime($hours, $minutes, 0, 'Europe/Rome'));
        } catch (Exception $e) {
            return [];
        }

        return TrenordSearchResultsCleaner::cleanupSearchResults($searchResults);
    }

    static function checkIfValidStation($stationName, $stations) {
        $flag = false;
        foreach ($stations as $station) {
            if ($station['label'] == $stationName) {
                $flag = true;
            }
        }
        return $flag;
    }

    static function filterStations($stations, $partial) {
        $partial = strtoupper($partial);
        // extract only values from the composite array returned
        return array_values(array_filter($stations, function ($station) use($partial) {
            return preg_match("/(^|\b)" . preg_quote($partial) . "/i", $station['label']);
        }));
    }
}
