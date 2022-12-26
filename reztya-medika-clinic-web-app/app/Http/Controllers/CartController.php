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
            $schedules = Schedule::all();
            $printServiceOnce = false;
            $printProductOnce = false;
            $totalPrice = 0;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=166&destination=".Auth::user()->city_id."&weight=1000&courier=jne",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: 460abd066bcb244bf02b1c284f49e55a"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $costs = json_decode($response)->rajaongkir->results[0]->costs;

            $origin[0] = json_decode($response)->rajaongkir->destination_details->province;
            if (json_decode($response)->rajaongkir->destination_details->type == 'Kota') {
                $origin[1] = "Kota ".json_decode($response)->rajaongkir->destination_details->city_name;
            } else if (json_decode($response)->rajaongkir->destination_details->type == 'Kabupaten') {
                $origin[1] = "Kab. ".json_decode($response)->rajaongkir->destination_details->city_name;
            } else {
                $origin[1] = str(json_decode($response)->rajaongkir->destination_details->city_name);
            }

            if ($err) {
                return redirect('/home')->with('signupError', 'Terjadi masalah dengan pendaftaran. Harap coba ulang.');
            }

            if(Auth::user()->user_role_id == 2){
                $cart = Cart::where('user_id', Auth::user()->user_id)->get();
            }

            return view('view_cart')
                ->with('cart', $cart)
                ->with('schedules', $schedules)
                ->with('printServiceOnce', $printServiceOnce)
                ->with('printProductOnce',$printProductOnce)
                ->with('totalPrice', $totalPrice)
                ->with(compact('costs'))
                ->with(compact('origin'));
        }
        return redirect('/home');
    }

    public function updateCartSchedule(Request $req, $id)
    {
        $validated_data = $req->validate([
            'schedule_id' => 'required',
            'home_service' => 'required'
        ]);

        $old_schedule = Schedule::find($req['old_schedule_id']);
        $old_schedule->status = 'Available';
        $old_schedule->save();

        $new_schedule = Schedule::find($req['schedule_id']);
        $new_schedule->status = 'Booked';
        $new_schedule->save();

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
        $currentOrder = DB::table('carts')
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
