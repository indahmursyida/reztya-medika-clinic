<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::paginate(10);
        return view('manage-schedule')->with('schedules', $schedules);
    }

    public function update($id)
    {
        $schedule = Schedule::find($id);
        return view('edit-schedule')->with('schedule', $schedule);
    }

    public function save_update(Request $req)
    {
        $requirements = [
            "start_time" => "required|date",
            "end_time" => "required|date"
        ];

        $validator = Validator::make($req->all(), $requirements);

        $schedule = Schedule::find($req['id']);
        $schedule->start_time = $req->input('start_time');
    }
    
}
