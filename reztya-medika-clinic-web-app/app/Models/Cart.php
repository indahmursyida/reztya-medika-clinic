<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';
    protected $fillable = [
        'user_id',
        'service_id', 
        'product_id',
        'schedule_id',
        'quantity'
    ];

    public function user(){
        return $this->hasOne(User::class, 'user_id');
    }

    public function service(){
        return $this->hasOne(Service::class, 'service_id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'product_id');
    }

    public function schedule(){
        return $this->hasOne(Schedule::class, 'schedule_id');
    }
}
