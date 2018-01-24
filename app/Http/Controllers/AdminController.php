<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Trip;
use App\TripPart;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $nUsers = User::count();
        $nTrips = Trip::count();
        $nParts = TripPart::count();

        return view('admin.index', [
            'nUsers' => $nUsers,
            'nTrips' => $nTrips,
            'nParts' => $nParts
        ]);
    }
}
