<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buyProduct(Request $request)
    {
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
        $currentOrder = DB::table('order_details')
        ->where('product_id', '=', $validatedData['product_id'])
        ->first();
        if($currentOrder){
            $newQuantity = $currentOrder->quantity + $validatedData['quantity'];
            DB::update('update order_details set quantity = ? where product_id = ?',[$newQuantity, $validatedData['product_id']]);
        }else{
            OrderDetail::create($validatedData);
        }
        return redirect('/home')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookService(Request $request)
    {
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
        OrderDetail::create($validatedData);
        return redirect('/home')->with('success', 'Perawatan berhasil ditambahkan ke keranjang!');
    }
}
