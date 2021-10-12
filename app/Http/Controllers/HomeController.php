<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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

    /**
     * Show the profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function profile()
    {
        return view('profile');
    }

    /**
     * updating profile name
     * @param Request $request
     * @param mixed $id
     * @return Redirector|RedirectResponse
     * @throws ValidationException
     * @throws BadRequestException
     * @throws BindingResolutionException
     */

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        Validator::make($request->all(), [
            'name' => [
                'required'
            ]
        ])->validate(); // validator for required name
        if ($user !== null) {
            $user->name = $request->get('name');
            $user->save(); // updating name
        }
        return redirect('/profile')->with('status', 'Name updated successfully!!!');
    }

    public function password()
    {
        return view('password');
    }

    /**
     * method to update password
     * @param Request $request
     * @param mixed $id
     * @return Redirector|RedirectResponse
     * @throws BindingResolutionException
     * @throws ValidationException
     */

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        if ($user === null) {
            return redirect('/logout');
        }

        Validator::make($request->all(), [
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
        ])->validate(); // validating the passwords

        if (Hash::check($request->password, $user->password)) { // checking if the old password is authentic
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save(); // updating password
            return redirect('/profile/password')->with('status', 'Password updated successfully!!!');
        } else {
            return redirect('/profile/password')->with('passworderror', 'Old password is incorrect');
        }
    }
}
