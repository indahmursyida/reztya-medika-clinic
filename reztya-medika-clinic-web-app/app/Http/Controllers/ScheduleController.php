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

    public function add()
    {
        return view('add-schedule');
    }

    public function store(Request $req)
    {
        $validated_data = $req->validate([
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time'
        ]);

        $validated_data['status'] = 'Ready';
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
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time'
        ]);
        $validated_data['status'] = 'Ready';
        Schedule::find($id)->update($validated_data);
        return redirect('/manage-schedule');
    }
    
    public function delete($id)
    {
        Schedule::find($id)->delete();
        return redirect('/manage-schedule')->with('success','Product successfully deleted!');
    }
}
