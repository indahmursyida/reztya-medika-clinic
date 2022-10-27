<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function viewProfile() {
        return view('profile.view-profile');
    }

    public function editProfile(Request $request) {
        $validated = $request->validate([
            'photo' => 'required|image',
            'name' => 'required',
            'birthdate' => 'required|date|before:now',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'email' => 'required|unique:profile|email:rfc,dns',
            'password' => 'required|current_password'
        ]);

        if ($validated) {
            $name = $request->name;
            $email = $request->email;
            $birthdate = $request->birthdate;
            $phone = str($request->phone);
            $address = $request->address;
            $username = $request->username;

            $photo = $request->file('photo');
            $profilePicture = $photo->storeAs('profile-images', time().'.'.$photo->getClientOriginalExtension());

            $currentEmail = auth()->user()->email;

            DB::table('profile')->where('email', $currentEmail)->update([
                'full_name' => $name,
                'email' => $email,
                'profile_picture' => $profilePicture,
                'birth_date' => $birthdate,
                'phone_number' => $phone,
                'address' => $address,
                'username' => $username
            ]);
            return redirect()->intended('/view-profile');
        }
        return redirect()->back()->with('updateError', 'Ubah profil gagal!');
    }

    function viewEditProfile() {
        return view('profile.edit-profile');
    }
}
