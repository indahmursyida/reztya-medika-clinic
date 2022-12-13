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
            'password' => 'required|current_password'
        ]);

        if ($validated) {
            $name = $request->name;
            $email = $request->email;
            $birthdate = $request->birthdate;
            $phone = strval($request->phone);
            $address = $request->address;
            $username = $request->username;

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
                'username' => $username
            ]);
            return redirect()->intended('/view-profile/{username}');
        }
        return redirect()->back()->with('updateError', 'Ubah profil gagal!');
    }

    function viewEditProfile() {
        return view('profile.edit-profile');
    }
}
