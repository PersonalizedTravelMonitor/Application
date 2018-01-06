<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use App\User;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->scopes(['profile','email'])->redirect();
    }

    public function handleGoogleCallback()
    {
        $socialUser = Socialite::driver('google')->user();

        $userCheck = User::where('email', '=', $socialUser->email)->first();
        $user = null;
        if (empty($userCheck)) {
            $user = new User;
            $user->name = $socialUser->name;
            $user->email = $socialUser->email;
            $user->social_provider = "google";
            $user->social_id = $socialUser->id;
            $user->password = "NOPASSWORD";
            $user->save();
        } else {
            $user = $userCheck;
            $user->social_provider = "google";
            $user->social_id = $socialUser->id;
            $user->save();
        }

        Auth::login($user, true);
        return redirect()->route('home');
    }
}
