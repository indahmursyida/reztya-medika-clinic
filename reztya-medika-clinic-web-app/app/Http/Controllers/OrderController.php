<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Schedule;
use App\Models\PaymentReceipt;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function createOrder()
    {
        $order = Order::create([
            'user_id' => Auth::user()->user_id,
            'order_date' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'status' => 'ON GOING'
        ]);

        $cart = Cart::where('user_id', Auth::user()->user_id)->get();

        foreach($cart as $x)
        {
            if($x->service_id)
            {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'service_id' => $x->service_id,
                    'schedule_id' => $x->schedule_id
                ]);
            }
            else
            {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $x->product_id,
                    'quantity' => $x->quantity
                ]);
            }
        }

        Cart::where('user_id', Auth::user()->user_id)->delete();

        
        
        return redirect('/active-order');
    }

    public function activeOrder()
    {
        $order = null;
        $totalPrice = 0;
        $schedules = Schedule::all();
        $printServiceOnce = false;
        $printProductOnce = false;

        if(Auth::user()->user_role_id == 1)
        {
            $order = Order::where('status', 'ON GOING')->get();
        }
        else
        {
            $order = Order::where('user_id', Auth::user()->user_id)->where('status', 'ON GOING')->get();
        }

        // dd($order);
        // dd($order[0]->orderDetail);
        if(!$order->isEmpty())
        {
            foreach($order as $x)
            {
                foreach($x->orderDetail as $y)
                {
                    if($y->service_id)
                        $totalPrice += $y->service->price;
                    else
                        $totalPrice += $y->product->price * $y->quantity;
                }
            }
        }

        return view('order_active')->with('order', $order)->with('schedules', $schedules)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
    }
    
    public function reschedule(Request $req, $id)
    {
        $validated_data = $req->validate([
            // 'order_detail_id' => 'required',
            'schedule_id' => 'required'
        ]);

        $validated_data['order_detail_id'] = $id;
        // dd($validated_data);

        OrderDetail::find($id)->update($validated_data);

        return redirect('/active-order');
    }

    public function delete_order_item($id)
    {
        OrderDetail::find($id)->delete();

        return redirect('/order')->with('success','Item successfully deleted!');
    }

    public function update_order_status_on_going($id)
    {
        $order = Order::find($id)->first();

        $order->status = 'ON GOING';
        $order->save();

        return redirect('/active-order');
    }

    public function cancel_order($id)
    {
        $order = Order::find($id); 
        $order->status = 'CANCELED';
        $order->save();
        return redirect('/history-order');
    }

    public function history_order()
    {
        if(Auth::user()->user_role_id == 1)
        {
            $order = Order::all()->where('status','!=','UNPAID');
        }
        else
        {
            $order = Order::where('user_id', Auth::user()->user_id)->where('status','!=','UNPAID')->get();
        }
        
        $printServiceOnce = false;
        $printProductOnce = false;
        $totalPrice = 0;

        if($order)
        {
            foreach($order as $x)
            {
                foreach($x->orderDetail as $y)
                {
                    if($y->service_id)
                        $totalPrice += $y->service->price * $y->quantity;
                    else
                        $totalPrice += $y->product->price * $y->quantity;
                }
            }
        }

        return view('order_history')->with('order', $order)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
    }

    public function finish_order($id)
    {
        $order = Order::find($id); 
        $order->status = 'FINISH';
        $order->save();
        return redirect()->route('form_payment', ['id' => $id]);
    }

    public function form_payment_receipt($id)
    {
        $order = Order::find($id); 
        $totalPrice = 0;

        foreach($order->orderDetail as $x)
        {
            if($x->service_id)
                $totalPrice += $x->service->price * $x->quantity;
            else
                $totalPrice += $x->product->price * $x->quantity;
        }

        return view('payment_receipt_form')->with('order', $order)->with('totalPrice', $totalPrice);
    }

    public function add_payment_receipt(Request $req)
    {
        if($req->payment_method == 'Cash')
        {
            $validated_data = $req->validate([
                'order_date' => 'required',
                'customer_name' => 'required',
                'payment_date' => 'required',
                'payment_amount' => 'required',
                'payment_method' => 'required|in:Cash', 
                'created_by' => 'required',
                'admin_password' => 'required'
            ]);
        }
        else{
            $validated_data = $req->validate([
                'order_date' => 'required',
                'customer_name' => 'required',
                'payment_date' => 'required',
                'payment_amount' => 'required',
                'payment_method' => 'required|in:Transfer', 
                'account_number' => 'numeric',
                'created_by' => 'required',
                'admin_password' => 'required'
            ]);
        }

        PaymentReceipt::create($validated_data);

        return redirect('/history-order');
    }

    public function filter_status($status)
    {
        if(Auth::user()->user_role_id == 1)
        {
            $order = Order::where('status', $status)->get();
        }
        else
        {
            $order = Order::where('user_id', Auth::user()->user_id)->where('status', $status)->get();
        }

        $printServiceOnce = false;
        $printProductOnce = false;
        $totalPrice = 0;

        if(!$order->isEmpty())
        {
            foreach($order as $x)
            {
                foreach($x->orderDetail as $y)
                {
                    if($y->service_id)
                        $totalPrice += $y->service->price * $y->quantity;
                    else
                        $totalPrice += $y->product->price * $y->quantity;
                }
            }
        }
        
        return view('order_history')->with('order', $order)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
    }

    public function repeat_order($id)
    {
        $order = Order::find($id);
        $new_order = $order->replicate();

        $new_order->status = 'UNPAID';
        $new_order->order_date = Carbon::parse(Carbon::now())->format('Y-m-d');
        $new_order->save();

        $order_detail = OrderDetail::where('order_id', $id)->get();

        // dd($order_detail);

        $new_order_detail = [];
        foreach($order_detail as $x)
        {
            $new_order_detail = $x->replicate();
            $new_order_detail->order_id = $new_order->order_id;
            $new_order_detail->save();
        }
        
        return redirect('/order');
    }
}
