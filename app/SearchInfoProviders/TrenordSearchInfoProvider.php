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

        if ($from==$to) {
            return [];
        }

        try {
            $resultsFrom = self::autocompleteFrom($from);
            $resultsTo = self::autocompleteTo($to);
            $flag = false;
            foreach ($resultsFrom as $fromSuggestion) {
                if ($fromSuggestion['label'] == $from) {
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                return [];
            }
            $flag = false;
            foreach ($resultsTo as $toSuggestion) {
                if ($toSuggestion['label'] == $to) {
                    $flag = true;
                }
            }
            if (!$flag) {
                return [];
            }

            $searchResults = TrenordAPI::search($from,$to,Carbon::createFromTime($hours, $minutes, 0, 'Europe/Rome'));
        } catch (Exception $e) {
            return [];
        }

        return TrenordSearchResultsCleaner::cleanupSearchResults($searchResults);
    }

    static function filterStations($stations, $partial) {
        $partial = strtoupper($partial);
        // extract only values from the composite array returned
        return array_values(array_filter($stations, function ($station) use($partial) {
            return preg_match("/(^|\b)" . $partial . "/i", $station['label']);
        }));
    }
}
