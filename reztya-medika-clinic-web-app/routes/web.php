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

// View Profile
Route::get('/view-profile', [\App\Http\Controllers\ProfileController::class, 'viewProfile']);

// Edit Profile
Route::get('/edit-profile', [\App\Http\Controllers\ProfileController::class, 'viewEditProfile']);
Route::post('/edit-profile', [\App\Http\Controllers\ProfileController::class, 'editProfile']);
