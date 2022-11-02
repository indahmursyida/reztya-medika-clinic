<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $primaryKey = 'feedback_id';
    protected $fillable = [
        'order_detail_id',
        'feedback_body'
    ];

    public function feedback(){
        return $this->belongsTo(OrderDetail::class, 'feedback_id', 'feedback_id');
    }

}
