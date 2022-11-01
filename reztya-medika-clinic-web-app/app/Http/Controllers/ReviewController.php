<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function addClinicReview(Request $request) {
        return view('users.clinic_review');
    }
}
