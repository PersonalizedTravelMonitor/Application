<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Trip;
use App\TripPart;
use App\Announcement;
use App\Notifications\GlobalAnnouncement;
use App\Notifications\GenericNotification;
use Notification;

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

    public function trips()
    {
        return view('admin.trips');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function sendAnnouncement(Request $request)
    {
        $announcement = new Announcement;
        $announcement->title = $request->title;
        $announcement->text = $request->text;
        $announcement->save();
        $announcement->notify(new GlobalAnnouncement($announcement));

        Notification::send(User::all(), new GenericNotification($announcement->title, $announcement->text));

        $request->session()->flash('status', 'Announcement was sent!');
        return redirect()->route('admin.index');
    }

    public function delete(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('home');
    }
}
