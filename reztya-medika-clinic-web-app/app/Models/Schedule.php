<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Schedule extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'schedule_id';
    protected $fillable = [
        'schedule_id',
        'start_time',
        'end_time'
    ];

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function set_date($value)
    {
        $this->attributes['start_time'] = Carbon::createFromFormat('m-d-Y', $value)->format('Y-m-d');
        // return Carbon::parse($this->attributes['start_time'])->translatedFormat('l, d F Y');
    }
}
