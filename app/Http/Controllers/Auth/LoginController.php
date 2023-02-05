<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\SocialAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Social Login action
     * @param mixed $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {

        if(!empty($provider)){

            return Socialite::driver($provider)->redirect();
        }

        return redirect()->route('login');
        
    }

    /**
     * Callback for provider of Social Login 
     * @param mixed $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handleProviderCallback($provider)
    {
        try {

            $oauthUser = Socialite::driver($provider)->user();

        } catch (\Exception $e) {

            return redirect()->route('login');
        }

        $oauthUser = $this->findOrCreateUser($oauthUser, $provider);

        Auth::login($oauthUser, true);

        return redirect($this->redirectTo);
    }


    /**
     * find an existing User/SocialAuth User, otherwise create one.
     * If user logs with same email from different providers, 
     * email should be modifed cause email in user table is unique.
     * @param mixed $oauthUser
     * @param mixed $provider
     * @return mixed
     */
    public function findOrCreateUser($oauthUser, $provider)
    {
        $existingOAuth = SocialAuth::where('provider_name', $provider)
            ->where('provider_id', $oauthUser->getId())
            ->first();

        if ($existingOAuth) {
            return $existingOAuth->user;
        } else {
            //check User for provider_id and provider_name if exist
            $user = User::where('provider_id', $oauthUser->getId())
                        ->where('provider_name', $provider)
                        ->first();

            if (!$user) {
                //check User only for email if exist
                $user = User::whereEmail($oauthUser->getEmail())->first();

                //modify email if exist cause it should be unique
                $email = (!$user) ? $oauthUser->getEmail() : $provider.'_'.$oauthUser->getEmail();

                $user = User::create([
                    'email' => $email,
                    'name' => $oauthUser->getName(),
                    'provider_name' => $provider,
                    'provider_id' => $oauthUser->getId(),
                ]);
            }

            $user->oauth()->create([
                'provider_id' => $oauthUser->getId(),
                'provider_name' => $provider,
                'avatar' => $oauthUser->getAvatar(),
            ]);

            return $user;
        }
    }

}