<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $primaryKey = 'feedback_id';
    protected $fillable = [
        'payment_receipt_id',
        'feedback_body'
    ];

    public function paymentReceipt(){
        return $this->belongsTo(PaymentReceipt::class, 'feedback_id', 'feedback_id');
    }

}
