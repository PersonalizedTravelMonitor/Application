<?php

namespace App\SearchInfoProviders;

use Storage;
use Carbon\Carbon;
use DateTimeZone;
use App\ExternalAPIs\TrenordAPI;
use App\ExternalAPIs\TrenordSearchResultsCleaner;

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

    public static function searchSolutions($from, $to, $hours, $minutes) {
        $searchResults = TrenordAPI::search($from,$to,Carbon::createFromTime($hours, $minutes, 0, 'Europe/Rome'));

        $cleanedupResults = TrenordSearchResultsCleaner::cleanupSearchResults($searchResults);

        return response()->json($cleanedupResults);
    }

    static function filterStations($stations, $partial) {
        $partial = strtoupper($partial);
        // extract only values from the composite array returned
        return array_values(array_filter($stations, function ($station) use($partial) {
            return preg_match("/(^|\b)" . $partial . "/i", $station['label']);
        }));
    }
}
