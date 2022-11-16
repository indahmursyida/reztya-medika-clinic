<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Schedule;

class CartController extends Controller
{
    public function index()
    {
        $cart = null;
        $schedules = Schedule::all();
        $printServiceOnce = false;
        $printProductOnce = false;
        $totalPrice = 0;

        if(Auth::user()->user_role_id == 2)
            $cart = Cart::where('user_id', Auth::user()->user_id)->get();
        
        return view('view_cart')->with('cart', $cart)->with('schedules', $schedules)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
    }

    public function updateCartSchedule(Request $req, $id)
    {
        $validated_data = $req->validate([
            'schedule_id' => 'required'
        ]);

        $validated_data['cart_id'] = $id;

        Cart::find($id)->update($validated_data);

        return redirect('/cart');
    }

    public function updateCartQuantity(Request $req, $id)
    {
        $validated_data = $req->validate([
            'quantity' => 'numeric'
        ]);

        Cart::find($id)->update($validated_data);
        return redirect('/cart');
    }
}
