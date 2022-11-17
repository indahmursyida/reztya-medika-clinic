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
        'payment_date',
        'payment_amount',
        'payment_method',
        'account_number',
        'account_name',
        'image_path'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'payment_receipt_id');
    }

    public function feedback(){
        return $this->hasOne(Feedback::class, 'feedback_id');
    }
}
