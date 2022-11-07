<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $fillable = [
        'cancel_id', 
        'payment_receipt_id', 
        'user_id', 
        'order_date', 
        'status'
    ];
    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function cancel(){
        return $this->hasOne(OrderCancel::class, 'cancel_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id');
    }

    public function payment_receipt(){
        return $this->hasOne(PaymentReceipt::class, 'payment_receipt_id');
    }
}
