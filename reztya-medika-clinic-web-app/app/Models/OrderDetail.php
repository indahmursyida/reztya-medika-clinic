<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_detail_id';
    protected $fillable = [
        'service_id', 
        'product_id',
        'schedule_id',  
        'quantity'
    ];
    public function service(){
        return $this->hasMany(Service::class, 'service_id');
    }

    public function product(){
        return $this->hasMany(Product::class, 'product_id');
    }

    public function schedule(){
        return $this->hasMany(Service::class, 'schedule_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

}
