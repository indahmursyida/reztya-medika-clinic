<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function addClinicReview(Request $request) {
        $review = $request->validate([
            'review' => 'required'
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

            return back()->with('success', 'Reviu berhasil dikirim!');
        }

        return back()->with('success', 'Sudah pernah mengirim reviu!');
    }
}
