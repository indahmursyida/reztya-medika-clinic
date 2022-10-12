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

Route::get('/manage-schedule', function () {
    return view('manage-schedule');
});

Route::get('/add-schedule', function () {
    return view('add-schedule');
});

