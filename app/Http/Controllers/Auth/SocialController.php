<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    private $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    public function socialRedirect()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    public function login()
    {
        try {
            $socialUser = Socialite::driver($this->driver)->user();
            $user = User::where("email", $socialUser->email)->first();
            if (null !== $user) {
                Auth::login($user);
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'social_account' => true,
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
