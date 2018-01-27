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

        $repetitionDays = $request->input('repetition');
        if($repetitionDays){
            $repetitionDays = array_map(function($element){
                return intval($element);
            },$repetitionDays);
        }
        else
        {
            $repetitionDays = [];
        }
        
        $trip->repeatingOn = $repetitionDays;
        
        $trip->save();

        $selectedTrip = $request->input('trip');

        foreach ($selectedTrip['journey_list'] as  $selectedTripPart) {
            $trenordTripPart = new TrenordTripPart;
            $trenordTripPart->departure = $selectedTripPart['stops'][0]['departure_time'];
            $trenordTripPart->arrival = $selectedTripPart['stops'][sizeof($selectedTripPart['stops']) - 1]['arrival_time'];
            $trenordTripPart->line = $selectedTripPart['train']['line'];
            $trenordTripPart->trainId = $selectedTripPart['train']['train_name'];
            $trenordTripPart->departurePlatform = "Binario Est";
            $trenordTripPart->save();

            $tripPart = new TripPart;
            $tripPart->from = $selectedTripPart['stops'][0]['station']['station_name'];
            $tripPart->to = $selectedTripPart['stops'][sizeof($selectedTripPart['stops']) - 1]['station']['station_name'];

            $tripPart->details_id = $trenordTripPart->id;
            $tripPart->details_type = get_class($trenordTripPart);
            $tripPart->save();
            $tripPart->trips()->attach($trip->id);
        }
        return "OK";
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
        $owner = Auth::user();
        if($owner->id != $trip->user_id){
            throw new Exception("Unauthorized deletion");
        }
        $trip->delete();
        return redirect()->route('home');
    }
}
