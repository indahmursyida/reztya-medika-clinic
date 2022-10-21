<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Console\Scheduling\ScheduleWorkCommand;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::paginate(10);
        return view('manage-schedule')->with('schedules', $schedules);
    }

    public function add(Request $req)
    {
        $validated_data = $req->validate([
            'schedule_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date'
        ]);

        Schedule::create($validated_data);
        return redirect('/manage-schedule')->with('success','Product successfully added!');
    }

    public function edit($id)
    {
        $schedule = Schedule::find($id);
        return view('edit-schedule')->with('schedule', $schedule);
    }

    public function update(Request $req, $id)
    {
        $validated_data = $req->validate([
            'start_time' => 'required|datetime',
            'end_time' => 'required|datetime'
        ]);

        Schedule::find($id)->update($validated_data);
        return redirect('/manage-schedule');
    }
    
    public function delete($id)
    {
        Schedule::find($id)->delete();
        return redirect('/manage-schedule')->with('success','Product successfully deleted!');
    }
}
