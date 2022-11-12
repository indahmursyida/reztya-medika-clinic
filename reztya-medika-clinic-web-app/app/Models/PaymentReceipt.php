<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_receipt_id';
    protected $fillable = [
        'order_id',
        'feedback_id',
        'user_id',
        'payment_date',
        'payment_amount',
        'payment_method',
        'account_number'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
