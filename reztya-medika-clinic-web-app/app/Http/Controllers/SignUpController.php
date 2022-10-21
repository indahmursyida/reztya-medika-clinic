<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            DB::table('users')->insert($validated);
            return redirect()->intended('/home')->with('addSuccess', 'Pendaftaran berhasil! Silahkan masuk');
        }

        return redirect()->back()->with('signupError', 'Pendaftaran tidak berhasil!');
    }

    public function signUp() {
        return view('users.signup');
    }
}
