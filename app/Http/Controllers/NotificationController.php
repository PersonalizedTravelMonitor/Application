<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\GenericNotification;
use Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function saveSubscription(Request $request)
    {
        $user = Auth::user();

        $user->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
        $user->notify(new GenericNotification("PTM Push Notifications are enabled", "You will get updated on all your trips!"));
        return response()->json([
            'success' => true
        ]);
    }
}
