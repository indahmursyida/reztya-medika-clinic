<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BanController extends Controller
{
    public function viewUsers() {
        $members = DB::table('users')->where('user_role_id', 2)->get();
        return view('users.ban_unban_user')->with('members', $members);
    }
}
