<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $fillable = [
        'order_detail_id', 
        'cancel_id', 
        // 'payment_receipt_id', 
        'user_id', 
        'order_date', 
        'status'
    ];
    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'order_detail_id');
    }

    public function cancel(){
        return $this->hasOne(OrderCancel::class, 'cancel_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id');
    }

}
