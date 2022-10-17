<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'service_id';
    protected $fillable = [
        'category_id', 
        'schedule_id', 
        'name', 
        'description', 
        'price', 
        'image_path'
    ];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function schedule(){
        return $this->hasMany(Schedule::class, 'schedule_id');
    }
}
