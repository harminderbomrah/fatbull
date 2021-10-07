<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    private $driver = 'facebook';
    public function fbRedirect()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    public function login()
    {
        try {
            $fbUser = Socialite::driver($this->driver)->user();
            $user = User::where("email", $fbUser->email)->first();
            if (null !== $user) {
                Auth::login($user);
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $fbUser->name,
                    'email' => $fbUser->email,
                    'password' => encrypt(time())
                ]);
                $newUser->markEmailAsVerified();
                Auth::login($newUser);
                return redirect('/home');
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
