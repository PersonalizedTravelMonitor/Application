<?php

namespace App\SearchInfoProviders;

class TrenitaliaSearchInfoProvider implements SearchInfoProvider
{
    public static function autocompleteFrom($partialFrom) {
        $guzzle = new \GuzzleHttp\Client();

        $url = 'http://www.viaggiatreno.it/viaggiatrenonew/resteasy/viaggiatreno/autocompletaStazione/' . $partialFrom;
        $res = $guzzle->request('GET', $url);

        $stations = self::parseStationResponse($res->getBody());
        return response()->json($stations);
    }

    public static function autocompleteTo($partialTo) {
        return json_encode([$partialTo, $partialTo, $partialTo]);
    }

    public static function searchSolutions($from, $to, $date) {
        json_encode([$from, $to, $date]);
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
