<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentReceipt;
use Carbon\Carbon;

class PaymentReceiptController extends Controller
{
    public function transferReceipt(Request $req, $id)
    {
        $validated_data = $req->validate([
            'account_number' => 'required|numeric',
            'account_name' => 'required',
            'image_path' => 'required|image'
        ],[
            'account_number.required' => 'Nomor akun bank wajib diisi',
            'account_number.numeric' => 'Nomor akun bank harus angka',
            'account_name.required' => 'Nama akun bank wajib diisi',
            'image_path.required' => 'Foto bukti transfer wajib diisi',
            'image_path.image' => 'Foto bukti transfer tidak valid',
        ]);

        $order = Order::where('order_id', $id)->first();
        $order->status = 'waiting';
        $order->save();

        $order_details = OrderDetail::where('order_id', $id)->get();

        $totalPrice = 0;
        foreach($order_details as $order_detail)
        {
            if($order_detail->service_id)
                $totalPrice += $order_detail->service->price;
            else
                $totalPrice += $order_detail->product->price * $order_detail->quantity;
        }
        $totalPrice += $order->delivery_fee;

        $payment_receipt = PaymentReceipt::create([
            'payment_date' => Carbon::now(),
            'payment_amount' => $totalPrice,
            'payment_method' => 'Transfer',
            'account_number' => $validated_data['account_number'],
            'account_name' => $validated_data['account_name'],
            'image_path' => $validated_data['image_path']
        ]);

        $order->payment_receipt_id = $payment_receipt->payment_receipt_id;
        $order->save();

        if($req->file('image_path'))
        {
            $validated_data['image_path'] = $req->file('image_path')->store('transfer_images');
        }

        return redirect('/active-order');
    }
}
