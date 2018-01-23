<?php

namespace App\SearchInfoProviders;

class TrenitaliaSearchInfoProvider implements SearchInfoProvider
{
    public static function autocompleteFrom($partialFrom) {
        return json_encode([$partialFrom, $partialFrom, $partialFrom]);
    }

    public static function autocompleteTo($partialTo) {
        return json_encode([$partialTo, $partialTo, $partialTo]);
    }

    public static function searchSolutions($from, $to, $date) {
        json_encode([$from, $to, $date]);
    }
}
