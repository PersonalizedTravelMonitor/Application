<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()) {
            $user = Auth::user();
            $trips = $user->trips;
            $eventsCount = 0;
            foreach ($trips as $trip) {
                foreach ($trip->parts as $part) {
                    $eventsCount += $part->events->count();
               }
            }
            return view('home', [ 'eventsCount' => $eventsCount]);
        } else {
            return view('welcome');
        }
    }
}
