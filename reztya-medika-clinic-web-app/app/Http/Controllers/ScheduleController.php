<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::paginate(2);
        return view('manage-schedule')->with('schedules', $schedules);
    }

    public function get_schedule(){
        $schedules = Schedule::all();
        return view('manage-schedule', ['schedules'=>$schedules]);
    }

    
    
}
