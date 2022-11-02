<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function addClinicReview(Request $request) {
        $review = $request->validate([
            'review' => 'required'
        ]);
        $order_detail_id = $request->order_detail_id;

        $feedback_id = DB::table('feedback')->insert([
            'order_detail_id' => $order_detail_id,
            'feedback_body' => $review
        ]);

        DB::table('order_details')
            ->where('order_detail_id', $order_detail_id)->insert([
            'feedback_id' => $feedback_id->feedback_id
        ]);

        return redirect('/home');
    }

    public function clinicReview() {
        $orderDetail = DB::table('order_details')->get();
        return view('users.clinic_review')->with(compact('orderDetail'));
    }
}
