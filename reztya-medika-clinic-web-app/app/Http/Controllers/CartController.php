<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_role_id != 1) {
            $cart = null;
            $schedules = Schedule::where('status', 'Available')->get();
            $printServiceOnce = false;
            $printProductOnce = false;
            $totalPrice = 0;

            if(Auth::user()->user_role_id == 2)
                $cart = Cart::where('user_id', Auth::user()->user_id)->get();

            return view('view_cart')->with('cart', $cart)->with('schedules', $schedules)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
        }
        return redirect('/home');
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

    public function removeCart($id)
    {
        Cart::find($id)->delete();

        return redirect('/cart')->with('success','Item successfully deleted!');
    }

    public function buyProduct(Request $request)
    {
        $userId = Auth::user()->user_id;
        $validatedData = $request->validate(
            [
                'product_id' => 'required',
                'quantity' => 'required|integer|min:1|max:1000'
            ],
            [
                'product_id.required' => 'Produk wajib diisi',
                'quantity.required' => 'Jumlah produk wajib diisi',
                'quantity.min' => 'Jumlah produk minimal 1',
                'quantity.max' => 'Jumlah produk maksimal 1000'
            ]
        );
        $validatedData['user_id'] = $userId;
        $currentOrder = DB::table('cart')
        ->where('product_id', '=', $validatedData['product_id'])
        ->first();
        if($currentOrder){
            $newQuantity = $currentOrder->quantity + $validatedData['quantity'];
            DB::update('update cart set quantity = ? where product_id = ?',[$newQuantity, $validatedData['product_id']]);
        }else{
            Cart::create($validatedData);
        }
        return redirect('/home')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function bookService(Request $request)
    {
        $userId = Auth::user()->user_id;
        $validatedData = $request->validate(
            [
                'service_id' => 'required',
                'schedule_id' => 'required',
            ],
            [
                'service_id.required' => 'Perawatan wajib diisi',
                'schedule_id.required' => 'Jadwal wajib diisi'
            ]
        );
        $validatedData['user_id'] = $userId;
        Cart::create($validatedData);
        return redirect('/home')->with('success', 'Perawatan berhasil ditambahkan ke keranjang!');
    }
}
