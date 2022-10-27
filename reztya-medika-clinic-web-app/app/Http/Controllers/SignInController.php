<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller
{

    public function userLogout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }

    public function userLogin(Request $request) {
        if($request->all()) {
            $credentials = $request->validate([
                'email' => 'required|email:rfc,dns',
                'password' => 'required'
            ]);

            if(Auth::attempt($credentials)) {
                if(auth()->user()->is_banned == false) {
                    $remember_me = $request->remember_me;
                    if($remember_me) {
                        Cookie::queue('email', $request->email);
                        Cookie::queue('password', $request->password);
                    }

                    $request->session()->regenerate();

                    return redirect()->intended('/home');
                } else {
                    return redirect()->back()->with('loginError', 'Anda telah di ban! Silahkan kontak klinik!');
                }
            }
        }
        return redirect()->back()->with('loginError', 'Masuk tidak berhasil!');
    }
}
