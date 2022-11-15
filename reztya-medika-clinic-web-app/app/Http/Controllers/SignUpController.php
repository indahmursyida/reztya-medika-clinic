<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function userRegister(Request $request) {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'name' => 'required',
            'birthdate' => 'required|date|before:now',
            'email' => 'required|unique:users|email:rfc,dns',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $confirm_password = $request->validate([
            'confirm_password' => 'required'
        ]);

        if ($validated['password'] == $confirm_password['confirm_password']) {
            $validated['password'] = Hash::make($validated['password']);
            $validated['phone'] = strval($validated['phone']);
            // $validated['profile_picture'] = 'profile-images/profile_picture_default.jpg';

            $user = User::create($validated);

            if($user) {
                event(new Registered($user));
                Auth::login($user);
                return redirect(route('verification.notice'))->with('message', 'Pendaftaran berhasil! Silahkan verifikasi email');
            }
        }
        return redirect()->back()->with('signupError', 'Pendaftaran tidak berhasil!');
    }

    public function signUp() {
        return view('users.signup');
    }
}
