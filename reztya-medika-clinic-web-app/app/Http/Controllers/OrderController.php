<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Schedule;
use App\Models\PaymentReceipt;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function create(Request $req)
    {
        $order_duplicate = Order::with(['orderDetail' => function($query){
            $all_cart = Cart::where('user_id', Auth::user()->user_id)->whereNotNull('schedule_id')->get();

            $all_cart_arrays = $all_cart->map(function ($cart) {
                return collect($cart->toArray())
                    ->only('schedule_id')
                    ->all();
            })->unique();

            $query->whereIn('schedule_id', $all_cart_arrays);
        }])->where('status', 'ongoing')->orWhere('status', 'waiting')->first();
        
        if($order_duplicate)
        {
            if(count($order_duplicate->orderDetail) != 0)
            {
                $invalid_schedule = Cart::where('user_id', Auth::user()->user_id)->where('schedule_id', $order_duplicate->orderDetail()->first()->schedule_id)->first();
                return redirect()->back()->withErrors(['msg' => 'Pesanan tidak dapat dibuat karena jadwal perawatan ' . $invalid_schedule->service->name . ' sudah dipesan oleh member lain. Silahkan ubah jadwal perawatan tersebut.']);
            }
        }
        
        $orders = Order::create([
            'user_id' => Auth::user()->user_id,
            'order_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'status' => 'ongoing',
        ]);
        
        $validated_delivery_service = $req->validate([
            'delivery_service' => 'required'
        ],[
            'delivery_service.required' => 'Tipe pengiriman wajib diisi'
        ]);
        
        $orders['delivery_service'] = $validated_delivery_service['delivery_service'];
        $orders['weight'] = $req['weight'];
        
        if($validated_delivery_service['delivery_service'] == 1)
        {
            $validated_cost = $req->validate([
                'cost' => 'required'
            ],[
                'cost.required'=> 'Jasa pengiriman wajib diisi'
            ]);
            
            $json_decoded = json_decode($validated_cost['cost']);
            
            $orders['delivery_name'] = $json_decoded->service;
            $orders['delivery_duration'] = $json_decoded->cost[0]->etd;
            $orders['delivery_destination'] = $req['origin'];
            $orders['delivery_fee'] = $json_decoded->cost[0]->value * $orders['weight'];
        }
        $orders->save();
        
        $carts = Cart::where('user_id', Auth::user()->user_id)->get();
        
        foreach($carts as $cart)
        {
            if($cart->service_id)
            {
                OrderDetail::create([
                    'order_id' => $orders->order_id,
                    'service_id' => $cart->service_id,
                    'schedule_id' => $cart->schedule_id
                ]);
            }
            else
            {
                $product = Product::where('product_id', $cart->product_id)->first();
                
                $product->stock -= $cart->quantity;
                $product->save();
                
                OrderDetail::create([
                    'order_id' => $orders->order_id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity
                ]);
            }
        }
        
        Cart::where('user_id', Auth::user()->user_id)->delete();
        return redirect()->route('detail_order', ['id' => $orders->order_id]);
    }

    public function createServiceOrder()
    {
        $orders = Order::create([
            'user_id' => Auth::user()->user_id,
            'order_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'status' => 'ongoing',
        ]);

        $carts = Cart::where('user_id', Auth::user()->user_id)->get();

        foreach($carts as $cart)
        {
            if($cart->service_id)
            {
                OrderDetail::create([
                    'order_id' => $orders->order_id,
                    'service_id' => $cart->service_id,
                    'schedule_id' => $cart->schedule_id
                ]);
            }
            else
            {
                OrderDetail::create([
                    'order_id' => $orders->order_id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity
                ]);
            }
        }

        Cart::where('user_id', Auth::user()->user_id)->delete();

        return redirect()->route('detail_order', ['id' => $orders->order_id]);
    }

    public function activeOrder()
    {
        $orders = null;
        $schedules = Schedule::all();
        $totalPrice = 0;

        if(Auth::user()){
            if(Auth::user()->user_role_id == 1)
            {
                $orders = Order::where('status', 'ongoing')->orWhere('status', 'waiting')->get();
            }
            else
            {
                $orders = Order::where('user_id', Auth::user()->user_id)->where(function ($query) {
                    $query->where('status', 'waiting')->orWhere('status', 'ongoing');
                })->get();
            }
        }

        return view('order_active')->with('orders', $orders)->with('schedules', $schedules)->with('totalPrice', $totalPrice);
    }

    public function detailOrder($id)
    {
        $order = null;
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

        $order = Order::find($id);

        return view('order_detail')
            ->with('order', $order)
            ->with('schedules', $schedules)
            ->with('printServiceOnce', $printServiceOnce)
            ->with('printProductOnce',$printProductOnce)
            ->with('totalPrice', $totalPrice)
            ->with(compact('costs'))
            ->with(compact('origin'));
    }

    public function reschedule(Request $req, $id)
    {
        $validated_data = $req->validate([
            'schedule_id' => 'required',
            'home_service' => 'required'
        ]);

        if($req['schedule_id'] != $req['old_schedule_id'])
        {
            $old_schedule = Schedule::find($req['old_schedule_id']);
            $old_schedule->status = 'available';
            $old_schedule->save();

            $new_schedule = Schedule::find($req['schedule_id']);
            $new_schedule->status = 'unavailable';
            $new_schedule->save();
        }

        $validated_data['order_detail_id'] = $id;

        $newSchedule = Schedule::find($validated_data['schedule_id']);
        $content = [
            'title' => 'Informasi Perubahan Jadwal Perawatan di Klinik Reztya Medika',
            'username' => $req['username'],
            'name' => $req['name'],
            'old_schedule' => Carbon::parse($req['old_schedule'])->translatedFormat('l, d F Y, H:i'),
            'old_schedule_id' => $req['old_schedule_id'],
            'order_id' => $req['order_id'],
            'service_name' => $req['service_name'],
            'new_schedule' => Carbon::parse($newSchedule->start_time)->translatedFormat('l, d F Y, H:i')
        ];

        OrderDetail::find($id)->update($validated_data);
        $order_detail = OrderDetail::find($id);

        if(OrderDetail::where('schedule_id', $validated_data['schedule_id'])->count() == 0){
            return redirect()
            ->route('detail_order', ['id' => $order_detail->order_id])
            ->with('error', 'Jadwal ulang gagal karena terdapat perawatan di keranjang yang mempunyai jadwal yang sama!');
        }

        if(Auth::user()->user_role_id == 2){
            $emailAddress = "klinikreztya@gmail.com";
            Mail::to($emailAddress)->send(new SendEmail($content));
        }else{
            $emailAddress = $req['email'];
            Mail::to($emailAddress)->send(new SendEmail($content));
        }
        
        return redirect()
        ->route('detail_order', ['id' => $order_detail->order_id])
        ->with('success', 'Jadwal ulang perawatan berhasil!');
    }

    public function delete_order_item($id)
    {
        OrderDetail::find($id)->delete();

        return redirect('/order')->with('success','Order berhasil dihapus!');
    }

    public function update_order_status_on_going($id)
    {
        $orders = Order::find($id)->first();

        $orders->status = 'ongoing';
        $orders->save();

        return redirect('/active-order');
    }

    public function cancel_order($id)
    {
        $orders = Order::find($id);
        $orders->status = 'canceled';
        $orders->save();
        return redirect('/history-order');
    }

    public function updatePaymentReceipt(Request $req, $id)
    {
        $validated_data = $req->validate([
            'confirmed_by' => 'required'
        ]);

        $payment_receipt = PaymentReceipt::find($id);

        $payment_receipt->update($validated_data);

        $orders = Order::where('payment_receipt_id', $id)->first();

        $orders->status = 'finished';
        $orders->save();

        return redirect('/history-order');
    }

    public function historyOrder()
    {
        if(Auth::user()->user_role_id == 1)
        {
            $orders = Order::where('status','finished')->orWhere('status','canceled')->get();
        }
        else
        {
            $orders = Order::where('user_id', Auth::user()->user_id)->where('status','finished')->orWhere('status','canceled')->get();
        }

        $printServiceOnce = false;
        $printProductOnce = false;
        $totalPrice = 0;

        return view('order_history')->with('orders', $orders)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
    }

    public function confirmPayment($id)
    {
        $order = Order::find($id);

        $payment_receipt = PaymentReceipt::where('payment_receipt_id', $order->payment_receipt_id)->first();

        if($order->status == 'waiting')
        {
            return view('transfer_payment')->with('payment_receipt', $payment_receipt);
        }
        return redirect()->route('form_payment', ['id' => $id]);
    }

    public function form_payment_receipt($id)
    {
        $order = Order::find($id);
        $totalPrice = 0;
        $payment_receipt = null;

        if($order->payment_receipt_id)
        {
            $payment_receipt = PaymentReceipt::where('payment_receipt_id', $order->payment_receipt_id)->first();
        }

        foreach($order->orderDetail as $order_detail)
        {
            if($order_detail->service_id)
                $totalPrice += $order_detail->service->price;
            else
                $totalPrice += $order_detail->product->price * $order_detail->quantity;
        }
        $totalPrice += $order->delivery_fee;

        return view('payment_receipt_form')->with('order', $order)->with('totalPrice', $totalPrice)->with('payment_receipt', $payment_receipt);
    }

    public function add_payment_receipt(Request $req, $id)
    {
        $order = Order::find($id);
        $totalPrice = 0;

        foreach($order->orderDetail as $order_detail)
        {
            if($order_detail->service_id)
                $totalPrice += $order_detail->service->price;
            else
                $totalPrice += $order_detail->product->price * $order_detail->quantity;
        }
        $totalPrice += $order->delivery_fee;

        $validated_data = $req->validate([
            'confirmed_by' => 'required',
            'password' => 'required'
        ],[
            'confirmed_by.required' => 'Username wajib diisi',
            'password.required' => 'Kata sandi wajib diisi'
        ]);

        $user = User::where('username', $validated_data['confirmed_by'])->first();

        if($user)
        {
            if(password_verify($validated_data['password'], $user->password))
            {
                if($order->status == 'ongoing')
                {
                    $payment_receipt = PaymentReceipt::create([
                        'confirmed_by' => $validated_data['confirmed_by'],
                        'payment_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                        'payment_amount' => $totalPrice,
                        'payment_method' => 'Cash'
                    ]);
                    $order->payment_receipt_id = $payment_receipt->payment_receipt_id;
                    $order->save();   
                }
                else if($order->status == 'waiting'){
                    $payment_receipt = PaymentReceipt::where('payment_receipt_id', $order->payment_receipt_id)->first();
                    $payment_receipt->confirmed_by = $validated_data['confirmed_by'];
                    $payment_receipt->save();
                }
                $order->status = 'finished';
                $order->save();
                return redirect('/history-order');
            }
        }
        return redirect()->back()->withErrors(['invalid' => 'Informasi yang dimasukkan salah!']);
    }

    public function statusFilter($status)
    {
        if(Auth::user()->user_role_id == 1)
        {
            $orders = Order::where('status', $status)->get();
        }
        else
        {
            $orders = Order::where('user_id', Auth::user()->user_id)->where('status', $status)->get();
        }

        $printServiceOnce = false;
        $printProductOnce = false;

        if($status == "finished" || $status == "canceled")
        {
            return view('order_history')->with('orders', $orders)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce);
        }
        return view('order_active')->with('orders', $orders)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce);
    }

    public function repeatOrder($id)
    {
        $order_details = OrderDetail::where('order_id', $id)->get();

        foreach($order_details as $order_detail)
        {
            if($order_detail->service_id)
            {
                $carts = Cart::where('user_id', Auth::user()->user_id)->where('service_id', $order_detail->service_id)->get();

                if($carts->isEmpty())
                {
                    Cart::create([
                        'user_id' => Auth::user()->user_id,
                        'service_id' => $order_detail->service_id,
                        'schedule_id' => $order_detail->schedule_id
                    ]);
                }
            }
            else
            {
                $carts = Cart::where('user_id', Auth::user()->user_id)->where('product_id', $order_detail->product_id)->get();
                $product = Product::find($order_detail->product_id);

                if(!$carts->isEmpty())
                {
                    foreach($carts as $cart)
                    {
                        $cart->quantity += $order_detail->quantity;
                        $product->stock -= $order_detail->quantity;
                        $product->save();
                        if($cart->quantity > $product->stock){
                            $cart->quantity = $product->stock;
                            $cart->save();
                        }
                    }
                    
                }
                else
                {
                    if($order_detail->quantity <= $product->stock)
                    {
                        Cart::create([
                            'user_id' => Auth::user()->user_id,
                            'product_id' => $order_detail->product_id,
                            'quantity' => $order_detail->quantity
                        ]);
                        return redirect('/cart')->withSuccess('repeatOrder', 'Berhasil ditambahkan ke keranjang');
                    }
                }
                return redirect('/cart')->withErrors('repeatOrderFailed', 'Berhasil ditambahkan ke keranjang');
            }
        }
        return redirect('/cart')->withSuccess('repeatOrder', 'Stok produk ' . $product->name . ' hanya tersisa ' . $product->stock . ' produk');
        return redirect('/cart');
    }
}
