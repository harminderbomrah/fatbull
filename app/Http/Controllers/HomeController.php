<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        Validator::make($request->all(), [
            'name' => [
                'required'
            ]
        ])->validate();
        if ($user !== null) {
            $user->name = $request->get('name');
            $user->save();
        }
        return redirect('/profile')->with('status', 'Name updated successfully!!!');
    }

    public function password()
    {
        return view('password');
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        if ($user === null) {
            return redirect('/logout');
        }
        
        $validator = Validator::make($request->all(), [
            'password' => [
                'required'
            ],
            'new_password' => [
                'required',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'new_confirm_password' => [
                'required',
                'same:new_password'
            ]
        ])->validate();

        if (Hash::check($request->password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
            return redirect('/profile/password')->with('status', 'Password updated successfully!!!');
        } else {
            return redirect('/profile/password')->with('passworderror', 'Old password is incorrect');
        }
    }
}
