<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_receipt_id';
    protected $guarded = ['payment_receipt_id'];

    public function order(){
        return $this->belongsTo(Order::class, 'payment_receipt_id');
    }

    public function feedback(){
        return $this->hasOne(Feedback::class, 'feedback_id');
    }
}
