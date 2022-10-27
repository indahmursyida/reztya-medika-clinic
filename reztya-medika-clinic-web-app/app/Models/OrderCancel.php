<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancel extends Model
{
    use HasFactory;

    protected $primaryKey = 'cancel_id';
    protected $fillable = [
        'cancel_status', 
        'cancel_description', 
        'created_by'
    ];
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
