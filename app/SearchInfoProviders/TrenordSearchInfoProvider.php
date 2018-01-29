<?php

namespace App\SearchInfoProviders;

use Storage;
use Carbon\Carbon;
use DateTimeZone;
use App\ExternalAPIs\TrenordAPI;

function renameKey($array, $oldkey, $newkey) {
    if (!isset($array[$oldkey])) return $array;

    $array[$newkey] = $array[$oldkey];
    unset($array[$oldkey]);

    return $array;
}

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

        $cleanedupResults = self::cleanupSearchResults($searchResults);

        return response()->json($cleanedupResults);
    }

    static function filterStations($stations, $partial) {
        $partial = strtoupper($partial);
        // extract only values from the composite array returned
        return array_values(array_filter($stations, function ($station) use($partial) {
            return preg_match("/(^|\b)" . $partial . "/i", $station['label']);
        }));
    }

    static function cleanupSearchResults($searchResults) {
        foreach ($searchResults as $key => $trip) {
            $searchResults[$key] = self::cleanupTripResult($trip);
        }
        return $searchResults;
    }
//TODO: Filtrare il numero di stazini intermedie es. lecco-lecco maggianico
    static function cleanupTripResult($trip) {
        $trip = renameKey($trip, "dep_time", "departure_time");
        $trip = renameKey($trip, "arr_time", "arrival_time");

        unset($trip["walk"]);
        unset($trip["bicycle"]);
        unset($trip["handicap"]);
        unset($trip["class_1"]);
        unset($trip["class_2"]);
        unset($trip["class_1_and_2"]);
        unset($trip["mxp"]);
        unset($trip["mxp_special"]);
        unset($trip["dep_day_offset"]);
        unset($trip["arr_day_offset"]);
        unset($trip["price"]);
        unset($trip["price"]);

        unset($trip["dep_station"]["station_externalId"]);
        unset($trip["dep_station"]["station_externalStationNr"]);
        unset($trip["dep_station"]["station_type"]);
        $trip["dep_station"] = renameKey($trip["dep_station"], "station_ori_name", "station_name");
        $trip = renameKey($trip, "dep_station", "departure_station");

        unset($trip["arr_station"]["station_externalId"]);
        unset($trip["arr_station"]["station_externalStationNr"]);
        unset($trip["arr_station"]["station_type"]);
        $trip["arr_station"] = renameKey($trip["arr_station"], "station_ori_name", "station_name");
        $trip = renameKey($trip, "arr_station", "arrival_station");

        foreach ($trip["journey_list"] as $key => $tripPart) {
            $tripPart = self::cleanupTripPartResult($tripPart);

            $trip["journey_list"][$key] = $tripPart;
        }
        return $trip;
    }

    static function cleanupTripPartResult($tripPart) {
        $train = [];
        $train["train_name"] = $tripPart["train"]["train_name"];
        $train["train_category"] = $tripPart["train"]["train_category"];
        $train["line"] = $tripPart["train"]["direttrice"] ?? "";
        $tripPart["train"] = $train;
        $tripPart = renameKey($tripPart, "pass_list", "stops");

        $stops = [];
        foreach ($tripPart["stops"] as $key => $stop) {
            if (in_array($stop['type'], ['start', 'pass', 'end'])) {
                $stop = self::cleanupStopResult($stop);
                array_push($stops, $stop);
            }
        }
        $tripPart["stops"] = $stops;
        return $tripPart;
    }

    static function cleanupStopResult($stop) {
        $stop = renameKey($stop, "arr_time", "arrival_time");
        $stop = renameKey($stop, "dep_time", "departure_time");
        unset($stop["is_journey"]);
        unset($stop["actual_data"]);
        unset($stop["arr_day_offset"]);
        unset($stop["dep_day_offset"]);

        unset($stop["station"]["station_externalId"]);
        unset($stop["station"]["station_externalStationNr"]);
        unset($stop["station"]["station_type"]);
        $stop["station"] = renameKey($stop["station"], "station_ori_name", "station_name");

        return $stop;
    }

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
