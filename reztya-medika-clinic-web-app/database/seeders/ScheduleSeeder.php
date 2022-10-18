<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $dt = Carbon::now();
        // $date_now = $dt->toDateTimeString();
        $duration = 
        $schedules = [
            [
                'schedule_id'=> 1, 
                'start_time'=> Carbon::createFromFormat('d-m-Y H:i:s', '01-11-2022 10:00:00'),
                'end_time'=> Carbon::createFromFormat('d-m-Y H:i:s', '01-11-2022 11:00:00')
            ],
            [
                'schedule_id'=> 2, 
                'start_time'=> Carbon::createFromFormat('d-m-Y H:i:s', '02-11-2022 11:00:00'), 
                'end_time'=> Carbon::createFromFormat('d-m-Y H:i:s', '02-11-2022 12:00:00')
            ],
            [
                'schedule_id'=> 3, 
                'start_time'=> Carbon::createFromFormat('d-m-Y H:i:s', '03-11-2022 13:00:00'), 
                'end_time'=> Carbon::createFromFormat('d-m-Y H:i:s', '03-11-2022 14:00:00')
            ]
        ];
        DB::table('schedules')->insert($schedules);
    }
}
