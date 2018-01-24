<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Trip;
use App\TripPart;
use App\Announcement;
use App\Notifications\GlobalAnnouncement;

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

    public function sendAnnouncement(Request $request)
    {
        $announcement = new Announcement;
        $announcement->title = "Global Announcement";
        $announcement->text = $request->announcement;
        $announcement->save();
        $announcement->notify(new GlobalAnnouncement($announcement));

        $request->session()->flash('status', 'Announcement was sent!');
        return redirect()->route('admin.index');
    }
}
