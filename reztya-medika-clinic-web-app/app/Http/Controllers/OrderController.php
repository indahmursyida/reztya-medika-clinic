<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Schedule;
use App\Models\PaymentReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function order()
    {
        $order = Order::where('user_id', Auth::user()->user_id)->where('status', 'UNPAID')->first();
        $printServiceOnce = false;
        $printProductOnce = false;
        $totalPrice = 0;
        return view('order_cart')->with('order', $order)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
    }

    public function active_order()
    {
        $isUnpaid = false;
        $totalPrice = 0;

        if(Auth::user()->user_role_id == 1)
        {
            $order = Order::where('status', 'UNPAID')->get();
        }
        else
        {
            $order = Order::where('user_id', Auth::user()->user_id)->where('status', 'UNPAID')->get();
        }

        if($order)
        {
            $isUnpaid = true;
        }
        else
        {
            $isUnpaid = false;
        }
        
        $schedules = Schedule::all();
        $printServiceOnce = false;
        $printProductOnce = false;

        if($isUnpaid == true)
        {
            foreach($order as $x)
            {
                $x->status = 'ON GOING';
                $x->save();
            }
            $isUnpaid = false;
        }
        
        if($isUnpaid == false)
        {
            if(Auth::user()->user_role_id == 1)
            {
                $order = Order::where('status', 'ON GOING')->get();
            }
            else
            {
                $order = Order::where('user_id', Auth::user()->user_id)->where('status', 'ON GOING')->get();
            }
        }

        foreach($order as $x)
        {
            foreach($x->orderDetail as $y)
            {
                dd($y);
                if($y->service_id)
                    $totalPrice += $y->service->price * $y->quantity;
                else
                    $totalPrice += $y->product->price * $y->quantity;
            }
        }

        return view('order_active')->with('order', $order)->with('schedules', $schedules)->with('printServiceOnce', $printServiceOnce)->with('printProductOnce',$printProductOnce)->with('totalPrice', $totalPrice);
    }
    
    public function reschedule(Request $req, $id)
    {
        // $order = Order::where('user_id', Auth::user()->user_id)->where('status', 'UNPAID')->first();
        // // $schedule_id = $req->input('schedule');
        // foreach($order->orderDetail as $x)
        // {
        //     dd($x->service_id);
        // }

        // dd($service_id);

        // $orderdetail = OrderDetail::where('order_detail_id', $id)->first();

        // foreach($orderdetail as $x)
        // {
            
        //         $item = $x->where()
        // }
        // if($x->service_id == $service_id)

        $validated_data = $req->validate([
            'schedule_id' => 'required'
        ]);

        OrderDetail::find($id)->update($validated_data);

        return redirect('/active-order');
    }

    public function delete_order_item($id)
    {
        OrderDetail::find($id)->delete();

        return redirect('/order')->with('success','Item successfully deleted!');
    }

    public function cancel_order($id)
    {
        $order = Order::find($id); 
        $order->status = 'CANCELED';
        $order->save();
        return redirect('/');
    }

    public function history_order()
    {
        if(Auth::user()->user_role_id == 1)
        {
            $order = Order::where('status', 'FINISH')->get();
        }
        else
        {
            $order = Order::where('user_id', Auth::user()->user_id)->where('status', 'FINISH')->get();
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
        $validated_data = $req->validate([
            'order_date' => 'required',
            'customer_name' => 'required',
            'payment_date' => 'required',
            'payment_amount' => 'required',
            'payment_method' => 'required|in:Cash,Transfer', 
            'account_number' => 'numeric',
            'created_by' => 'required',
            'admin_password' => 'required'
        ]);

        PaymentReceipt::create($validated_data);

        // $pr->order_id = $id;
        // $pr->save();

        return redirect('/history-order');
    }
}
