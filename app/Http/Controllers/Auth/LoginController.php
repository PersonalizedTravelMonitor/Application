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

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = $this->findOrCreateUser($socialUser, $provider);

        Auth::login($user, true);
        return redirect()->route('home');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        $existingUser = User::where('email', '=', $socialUser->email)->first();

        if ($existingUser) {
            $existingUser->social_provider = $provider;
            $existingUser->social_id = $socialUser->id;
            $existingUser->save();
            return $existingUser;
        }

        return User::create([
            'name'     => $socialUser->name,
            'email'    => $socialUser->email,
            'social_provider' => $provider,
            // Placeholder password for OAuth services
            'password' => "OAUTH",  // Still safe because not encrypted
            'social_id' => $socialUser->id
        ]);
    }
}
