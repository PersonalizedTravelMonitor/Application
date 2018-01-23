<?php

namespace App\Http\Controllers;

use App\SearchInfoProviders\TrenitaliaSearchInfoProvider;
use Illuminate\Http\Request;

class SearchInfoController extends Controller
{
    protected $infoSources = [
        'trenitalia' => TrenitaliaSearchInfoProvider::class
    ];

    public function autocompleteFrom($infoSource, $from) {
        if (!isset($this->infoSources[$infoSource])) {
            return "INVALID INFO SOURCE";
        }

        $searchInfoProvider = $this->infoSources[$infoSource];
        return $searchInfoProvider::autocompleteFrom($from);
    }

    public function autocompleteTo($infoSource, $to) {
        if (!isset($this->infoSources[$infoSource])) {
            return "INVALID INFO SOURCE";
        }

        $searchInfoProvider = $this->infoSources[$infoSource];
        return $searchInfoProvider::autocompleteTo($to);
    }
}
