<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function resetPassword(Request $request) {
        $reset = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);

        $new_pass = Hash::make($reset['password']);
        $confirm_new_pass = Hash::make($reset['confirm_password']);

        if (Hash::check($reset['password'], $confirm_new_pass) && Hash::check($reset['confirm_password'], $new_pass)) {
            $email = $request['email'];

            $user = DB::table('users')->where('email', $email)->first();

            if($user) {
                if (!Hash::check($reset['confirm_password'], $user->password)) {
                    DB::table('users')->where('email', $email)->update([
                        'password' => $confirm_new_pass
                    ]);
                    $request->session()->regenerate();
                    return redirect()->intended('/signin')->with('success', 'Kata sandi berhasil diubah! Harap masuk!');
                }
                return back()->with('resetError', 'Kata sandi baru wajib berbeda dengan kata sandi lama!');
            }
            return redirect('/signup')->with('signupError', 'User tidak ditemukan! Harap daftar terlebih dahulu!');
        }
        return back()->with('resetError', 'Kata sandi dan konfirmasi kata sandi wajib sama!');
    }

    public function changePassword(Request $request) {
        $password = $request->validate([
            'oldpass' => 'required',
            'newpass' => 'required',
            'confnewpass' => 'required'
        ]);

        $old_pass = Hash::make($password['oldpass']);
        $new_pass = Hash::make($password['newpass']);
        $confirm_new_pass = Hash::make($password['confnewpass']);

        if (Hash::check($request['confnewpass'], $new_pass) && Hash::check($request['newpass'], $confirm_new_pass)) {
            if (Hash::check($password['oldpass'], \auth()->user()->password)) {
                if (!Hash::check($password['newpass'], $old_pass)) {
                    $newPassword = $password['confnewpass'];
                    $newPassword = Hash::make($newPassword);
                    $email = \auth()->user()->email;
                    DB::table('users')->where('email', $email)->update([
                        'password' => $newPassword
                    ]);
                    $request->session()->regenerate();
                    return redirect()->intended('/home');
                }
                return back()->with('passwordChangeError', 'Kata sandi baru wajib berbeda dengan kata sandi lama!');
            }
            return back()->with('passwordChangeError', 'Kata sandi lama tidak sesuai!');
        }
        return back()->with('passwordChangeError', 'Kata sandi baru dan konfirmasi kata sandi baru wajib sama!');
    }

    public function viewProfile() {
        return view('profile.view-profile');
    }

    public function editProfile(Request $request) {
        $validated = $request->validate([
            'photo' => 'required|image',
            'name' => 'required',
            'username' => 'required',
            'birthdate' => 'required|date|before:2010',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|current_password',
            'city_id' => 'required'
        ]);

        if ($validated) {
            $name = $request->name;
            $email = $request->email;
            $birthdate = $request->birthdate;
            $phone = strval($request->phone);
            $address = $request->address;
            $username = $request->username;
            $city = $request->city_id;

            $photo = $request->file('photo');
            $profilePicture = $photo->storeAs('profile-images', time().'.'.$photo->getClientOriginalExtension());

            $currentEmail = auth()->user()->email;

            DB::table('users')->where('email', $currentEmail)->update([
                'name' => $name,
                'email' => $email,
                'profile_picture' => $profilePicture,
                'birthdate' => $birthdate,
                'phone' => $phone,
                'address' => $address,
                'username' => $username,
                'city_id' => $city
            ]);
            return redirect()->intended('/view-profile/{username}');
        }
        return redirect()->back()->with('updateError', 'Ubah profil gagal!');
    }

    function viewEditProfile() {
        $curl = curl_init();

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

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return redirect()->back()->with('updateError', 'Terjadi masalah dengan perubahan. Harap coba ulang.');
        }

        $provinces = [];
        foreach (json_decode($response)->rajaongkir->results as $each) {
            if (!in_array($each->province_id, array_column($provinces, 'province_id'))) {
                array_push($provinces, array('province_id' => $each->province_id, 'province' => $each->province));
            }
        }
        sort($provinces);

        return view('profile.edit-profile')->with(compact('provinces'))->with(compact('response'));
    }
}
