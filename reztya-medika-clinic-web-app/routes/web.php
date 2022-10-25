<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::permanentRedirect('/', '/home');

Route::get('/home', function () {
    return view('layout/main');
});

Route::get('/order', function () {
    return view('order');
});


Route::get('/active-order', function () {
    return view('active-order');
});

Route::get('/payment-receipt-form', function () {
    return view('payment-receipt-form');
});

