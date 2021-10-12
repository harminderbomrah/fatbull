<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialController extends Controller
{
    private $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    /**
     *
     * @return RedirectResponse
     */

    public function socialRedirect()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    /**
     *
     * @return Redirector|HttpRedirectResponse|void
     */

    public function login()
    {
        try {
            $socialUser = Socialite::driver($this->driver)->user();
            $user = User::where("email", $socialUser->email)->first(); // check if user present
            if (null !== $user) {
                Auth::login($user); // login if user already registered
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'social_account' => true,
                    'password' => encrypt(time())
                ]); // creating new user
                $newUser->markEmailAsVerified(); // mark user as verified
                Auth::login($newUser); // login new user
                return redirect('/home');
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
