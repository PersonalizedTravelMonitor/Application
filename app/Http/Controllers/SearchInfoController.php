<?php

namespace App\Http\Controllers;

use App\SearchInfoProviders\TrenordSearchInfoProvider;
use Illuminate\Http\Request;

class SearchInfoController extends Controller
{
    protected $infoSources = [
        'trenord' => TrenordSearchInfoProvider::class
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

    public function searchSolutions($infoSource, Request $request) {
        if (!isset($this->infoSources[$infoSource])) {
            return "INVALID INFO SOURCE";
        }

        $searchInfoProvider = $this->infoSources[$infoSource];
        return $searchInfoProvider::searchSolutions($request->from, $request->to, $request->hour);
    }
}
