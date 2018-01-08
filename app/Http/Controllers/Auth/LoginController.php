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

    /*
        This method redirects any request incoming to `/auth/{provider}` (for example `/auth/google`) to the provider URL responsible for handling logins
    */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /*
        This method handles request coming from a $provider containing user infos
    */
    public function handleProviderCallback($provider)
    {
        // get the authenticated user on the $provider website
        $socialUser = Socialite::driver($provider)->user();

        $user = $this->findOrCreateUser($socialUser, $provider);

        // login the user
        Auth::login($user, true);
        return redirect()->route('home');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        // discriminate against the email, same email implies same user
        $existingUser = User::where('email', '=', $socialUser->email)->first();

        if ($existingUser) {
            // just update the social provider and id, not really useful but at least we keep track about which oauth provider are being used
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
