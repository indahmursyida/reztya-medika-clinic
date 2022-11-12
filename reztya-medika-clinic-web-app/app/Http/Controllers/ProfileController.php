<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePassword(Request $request) {
        $password = $request->validate([
            'oldpass' => 'required',
            'newpass' => 'required',
            'confnewpass' => 'required'
        ]);

        if (Hash::check($password['oldpass'], \auth()->user()->password)) {
            if ($password['newpass'] == $password['confnewpass']) {
                $newPassword = $password['confnewpass'];
                $newPassword = Hash::make($newPassword);
                $email = \auth()->user()->email;
                DB::table('users')->where('email', $email)->update([
                    'password' => $newPassword
                ]);
                $request->session()->regenerate();
                return redirect()->intended('/home');
            }
            return back()->with('passwordChangeError', 'Konfirmasi kata sandi baru wajib sesuai dengan kata sandi baru!');
        }
        return back()->with('passwordChangeError', 'Kata sandi lama tidak sesuai!');
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
