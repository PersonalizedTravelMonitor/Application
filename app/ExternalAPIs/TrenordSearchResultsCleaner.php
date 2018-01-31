<?php

namespace App\ExternalAPIs;
use App\Utils;

class TrenordSearchResultsCleaner {

    static function cleanupSearchResults($searchResults) {
        foreach ($searchResults as $key => $trip) {
            $searchResults[$key] = self::cleanupTripResult($trip);
        }
        return $searchResults;
    }

    static function cleanupTripResult($trip) {
        $trip = Utils::renameKey($trip, "dep_time", "departure_time");
        $trip = Utils::renameKey($trip, "arr_time", "arrival_time");

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
        $trip["dep_station"] = Utils::renameKey($trip["dep_station"], "station_ori_name", "station_name");
        $trip = Utils::renameKey($trip, "dep_station", "departure_station");

        unset($trip["arr_station"]["station_externalId"]);
        unset($trip["arr_station"]["station_externalStationNr"]);
        unset($trip["arr_station"]["station_type"]);
        $trip["arr_station"] = Utils::renameKey($trip["arr_station"], "station_ori_name", "station_name");
        $trip = Utils::renameKey($trip, "arr_station", "arrival_station");

        $parts = [];
        foreach ($trip["journey_list"] as $key => $tripPart) {
            if($tripPart["journey_type"] != 'train') {
                $trip["skipped_some"] = true;
                continue;
            }
            $tripPart = self::cleanupTripPartResult($tripPart);
            array_push($parts, $tripPart);
        }
        $trip["journey_list"] = $parts;
        return $trip;
    }

    static function cleanupTripPartResult($tripPart) {
        $train = [];
        $train["train_name"] = $tripPart["train"]["train_name"];
        $train["train_category"] = $tripPart["train"]["train_category"];
        $train["line"] = $tripPart["train"]["direttrice"] ?? "";
        $train["direction"] = $tripPart["train"]["direction"];
        $train["internal_id"] = $tripPart["train"]["CodiceTrasporto1"] ?? $tripPart["train"]["train_name"];
        $tripPart["train"] = $train;
        $tripPart = Utils::renameKey($tripPart, "pass_list", "stops");

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
        $stop = Utils::renameKey($stop, "arr_time", "arrival_time");
        $stop = Utils::renameKey($stop, "dep_time", "departure_time");
        unset($stop["is_journey"]);
        unset($stop["actual_data"]);
        unset($stop["arr_day_offset"]);
        unset($stop["dep_day_offset"]);

        unset($stop["station"]["station_externalId"]);
        unset($stop["station"]["station_externalStationNr"]);
        unset($stop["station"]["station_type"]);
        $stop["station"] = Utils::renameKey($stop["station"], "station_ori_name", "station_name");

        return $stop;
    }
}
