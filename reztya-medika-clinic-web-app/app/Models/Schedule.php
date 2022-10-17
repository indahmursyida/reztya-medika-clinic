<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
