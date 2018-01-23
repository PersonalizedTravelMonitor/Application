<?php

namespace App\Http\Controllers;

use App\SearchInfoProviders\TrenitaliaSearchInfoProvider;
use Illuminate\Http\Request;

class SearchInfoController extends Controller
{
    protected $infoSources = [
        'trenitalia' => TrenitaliaSearchInfoProvider::class
    ];

    public function autocompleteFrom($infoSource, Request $request) {
        if (!isset($this->infoSources[$infoSource])) {
            return "INVALID INFO SOURCE";
        }

        $searchInfoProvider = $this->infoSources[$infoSource];
        return $searchInfoProvider::autocompleteFrom($request->term);
    }

    public function autocompleteTo($infoSource, Request $request) {
        if (!isset($this->infoSources[$infoSource])) {
            return "INVALID INFO SOURCE";
        }

        $searchInfoProvider = $this->infoSources[$infoSource];
        return $searchInfoProvider::autocompleteTo($request->term);
    }
}
