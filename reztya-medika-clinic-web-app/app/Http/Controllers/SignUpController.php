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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 460abd066bcb244bf02b1c284f49e55a"
            ),
        ));

        $result1 = curl_exec($curl);
        $all1 = json_decode($result1, true);
        $provinces = $all1['rajaongkir']['results'];

        $err1 = curl_error($curl);
        curl_close($curl);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 460abd066bcb244bf02b1c284f49e55a"
            ),
        ));

        $cities = curl_exec($curl);
        $err2 = curl_error($curl);

        curl_close($curl);

        if ($err1 || $err2) {
            return redirect('/home')->with('signupError', 'Terjadi masalah dengan pendaftaran. Harap kontak klinik.');
        } else {
            return view('users.signup')
                ->with(compact('provinces'))
                ->with(compact('cities'));
        }
        //return view('users.signup');
    }
}
