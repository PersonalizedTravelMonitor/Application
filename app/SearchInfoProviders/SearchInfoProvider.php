<?php

namespace App\SearchInfoProviders;

/*
    This interface defines methods to be implemented by the concrete service providers
*/
interface SearchInfoProvider
{
    /*
        This method should return any new event about for a certain TripPart
    */
    public static function searchSolutions($from, $to, $date);
    public static function autocompleteFrom($partialFrom);
    public static function autocompleteTo($partialTo);
}
