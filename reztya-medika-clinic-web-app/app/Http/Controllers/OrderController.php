<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\Product;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        return view('order', [
            'products' => Product::all(),
            'services' => Service::all()
        ]);
    }
}
