<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';
    protected $fillable = [
        'category_id', 
        'name', 
        'description', 
        'duration', 
        'price', 
        'image_path'
    ];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}