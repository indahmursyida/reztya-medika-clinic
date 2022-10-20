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

    public function edit($id)
    {
        $schedule = Schedule::find($id);
        return view('edit-schedule')->with('schedule', $schedule);
    }

    public function update_schedule(Request $req)
    {
        $rules = [
            "schedule_id" => "required",
            "start_time" => "required",
            "end_time" => "required"
        ];

        $validator = Validator::make($req->all(), $rules);

        if(!$validator->fails())
        {
            $schedule = Schedule::find($req['schedule_id']);

            $schedule->update([
                "start_time" => $req['start_time'],
                "end_time" => $req['end_time']
            ]);
            
            return redirect()->route('manage-schedule');
        }
        else
        {
            return back()->withErrors($validator);
        }
    }
    
    public function delete_schedule($id)
    {
        $data = Schedule::find($id);
        $data->delete();
        return redirect()->route('manage-schedule');
    }
}
