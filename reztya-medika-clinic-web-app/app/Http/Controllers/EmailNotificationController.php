<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailNotificationController extends Controller
{
    public function index()
    {
        $content = [
            'title' => 'Informasi Perubahan Jadwal pada Perawatan Anda',
            'body' => 'Hai Indah, Jadwal perawatan anda telah'
        ];
        $emailAddress = 'indahbahrina@gmail.com';
        Mail::to($emailAddress)->send(new SendEmail($content));
        return 'Successfully sent email notification!';
    }
}
