<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'category_id', 
        'name', 
        'description', 
        'size', 
        'price', 
        'expired_date',
        'stock',
        'image_path'
    ];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class, 'product_id');
    }
}
