<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';
    protected $fillable = [
        'start_time',
        'end_time'
    ];

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'schedule_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
