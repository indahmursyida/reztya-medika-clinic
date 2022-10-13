<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        $newPassword = $request->password;
        $newPassword = Hash::make($newPassword);
        $email = $request->email;
        DB::table('users')->where('email', $email)->update([
            'password' => $newPassword
        ]);
        $request->session()->regenerate();
        return redirect()->intended('/home')->with('addSuccess', 'Password Change Success');
    }

    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);

        return redirect()->intended('reset-password');
    }

    public function passwordUpdate(Request $request) {
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
        }
        return back()->with('passwordChangeError', 'Password Change Failed');
    }

    public function userUpdate(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email:rfc,dns',
            'photo' => 'required|image'
        ]);

        if ($validated) {
            $name = $request->name;
            $email = $request->email;

            /*$photo = $request->file('photo');
            $profilePictureName = time().'.'.$photo->getClientOriginalExtension();
            Storage::putFileAs('public/storage/profile-images', $photo, $profilePictureName);
            $profilePicture = 'storage/profile-images/'.$profilePictureName;*/

            $photo = $request->file('photo');
            $profilePicture = $photo->storeAs('profile-images', time().'.'.$photo->getClientOriginalExtension());

            $currentEmail = \auth()->user()->email;

            DB::table('users')->where('email', $currentEmail)->update([
                'name' => $name,
                'email' => $email,
                'profile_picture' => $profilePicture
            ]);
            return redirect()->intended('/home');
        }
        return redirect()->back()->with('updateError', 'Update Profile Failed');
    }

    public function userLogout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }

    public function userRegister(Request $request) {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'name' => 'required',
            'birthdate' => 'required|date',
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
            return redirect()->intended('/home')->with('addSuccess', 'Sign up success! Please sign in');
        }

        return redirect()->back()->with('signupError', 'Sign up error!');
    }

    public function userLogin(Request $request) {
        if($request->all()) {
            $credentials = $request->validate([
                'email' => 'required|email:rfc,dns',
                'password' => 'required'
            ]);

            if(Auth::attempt($credentials)) {
                $remember_me = $request->remember_me;
                if($remember_me) {
                    Cookie::queue('email', $request->email, 10080);
                    Cookie::queue('password', $request->password, 10080);
                }

                $request->session()->regenerate();

                return redirect()->intended('/home');
            }
        }
        return redirect()->back()->with('loginError', 'Sign in failed!');
    }
}
