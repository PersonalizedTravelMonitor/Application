<?php

namespace App\Http\Controllers;

use App\Trip;
use App\TrenordTripPart;
use App\TripPart;
use Auth;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Trip::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("trips.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trip = new Trip;
        $trip->user_id = Auth::user()->id;
        $trip->repeatingOn = [3,4];
        $trip->save();

        $trenordTripPart = new TrenordTripPart;
        $trenordTripPart->line = $request->line;
        $trenordTripPart->departure = "07:37:00";
        $trenordTripPart->arrival = "08:23:00";
        $trenordTripPart->trainId = "10845";
        $trenordTripPart->departurePlatform = "Binario Est";
        $trenordTripPart->save();

        $tripPart = new TripPart;
        $tripPart->from = $request->from;
        $tripPart->to = $request->to;
        $tripPart->trip_id = $trip->id;
        $tripPart->details_id = $trenordTripPart->id;
        $tripPart->details_type = get_class($trenordTripPart);
        $tripPart->save();

        return redirect()->route("home");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function show(Trip $trip)
    {
        return view('trips.show', [ 'trip' => $trip ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trip $trip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        //
    }
}
