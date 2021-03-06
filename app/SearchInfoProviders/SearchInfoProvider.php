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
    public static function searchSolutions($from, $to, $hours, $minutes);
    public static function autocompleteFrom($partial);
    public static function autocompleteTo($partial);
}
