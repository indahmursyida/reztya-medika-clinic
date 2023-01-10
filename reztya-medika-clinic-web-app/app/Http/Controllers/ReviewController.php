<?php

namespace App\Http\Controllers;

use App\Mail\NotifySuggestionsAndCritics;
use App\Mail\SendEmail;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function addClinicReview(Request $request) {
        $review = $request->validate([
            'review' => 'required|min:10',
            'order_id' => 'required',
            'order_date' => 'required|date'
        ],
        [
            'review.required' => 'Kritik dan Saran tidak boleh kosong.',
            'review.min' => 'Kritik dan Saran harus lebih dari 10 karakter.'
        ]);

        $payment_receipt_id = $request->payment_receipt_id;

        $exists = DB::table('feedback')->where('payment_receipt_id', 'LIKE', $payment_receipt_id)->get();

        if ($exists->isEmpty()){
            $feedback_id = Feedback::create([
                'payment_receipt_id' => $payment_receipt_id,
                'feedback_body' => $review['review']
            ]);

            DB::table('payment_receipts')
                ->where('payment_receipt_id', $payment_receipt_id)->insert([
                    'feedback_id' => $feedback_id->feedback_id
            ]);

            if(Auth::user()->user_role_id == 2){
                $emailAddress = 'klinikreztya@gmail.com';
                $content = [
                    'review' => $review['review'],
                    'username' => Auth::user()->username,
                    'name' => Auth::user()->name,
                    'order_id' => $review['order_id'],
                    'order_date' => $review['order_date']
                ];
                Mail::to($emailAddress)->send(new NotifySuggestionsAndCritics($content));
            }

            return back()->with('success', 'Kritik dan Saran berhasil dikirim!');
        }

        return back()->with('success', 'Sudah pernah mengirim Kritik dan Saran!');
    }
}
