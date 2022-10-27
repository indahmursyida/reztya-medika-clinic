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

// Redirects
Route::permanentRedirect('/', '/home');
Route::permanentRedirect('/login', '/signin')->middleware('guest');
Route::permanentRedirect('/logout', '/home')->middleware('auth');

// Home
Route::get('/home', function () {
    return view('layout.main');
});

// Sign Up
Route::get('/signup', [\App\Http\Controllers\SignUpController::class, 'signUp'])->middleware('guest');
Route::post('/signup', [\App\Http\Controllers\SignUpController::class, 'userRegister']);

// Sign In
Route::get('/signin', function () {
    return view('users.signin');
})->middleware('guest');
Route::post('/signin', [\App\Http\Controllers\SignInController::class, 'userLogin']);

// Sign Out
Route::post('/signout', [\App\Http\Controllers\SignInController::class, 'userLogout'])->middleware('auth');

// View Profile
Route::get('/view-profile/{username}', [\App\Http\Controllers\ProfileController::class, 'viewProfile'])->middleware('auth');

// Edit Profile
Route::get('/edit-profile/{username}', [\App\Http\Controllers\ProfileController::class, 'viewEditProfile'])->middleware('auth');
Route::post('/edit-profile/{username}', [\App\Http\Controllers\ProfileController::class, 'editProfile'])->middleware('auth');

// Change Password
Route::post('/change-password/{username}', [\App\Http\Controllers\ProfileController::class, 'changePassword'])->middleware('auth');

//Product
Route::get('/manage-products', [\App\Http\Controllers\ProductController::class, 'index']);
Route::get('/product-detail/{id}', [\App\Http\Controllers\ProductController::class, 'show']);
Route::post('/delete-product/{id}', [\App\Http\Controllers\ProductController::class, 'destroy']);
Route::get('/add-product', [\App\Http\Controllers\ProductController::class, 'create']);
Route::post('/store-product', [\App\Http\Controllers\ProductController::class, 'store']);
Route::get('/edit-product/{id}', [\App\Http\Controllers\ProductController::class, 'edit']);
Route::put('/update-product/{id}', [\App\Http\Controllers\ProductController::class, 'update']);

//Service
Route::get('/manage-services', [\App\Http\Controllers\ServiceController::class, 'index']);
Route::get('/service-detail/{id}', [\App\Http\Controllers\ServiceController::class, 'show']);
Route::post('/delete-service/{id}', [\App\Http\Controllers\ServiceController::class, 'destroy']);
Route::get('/add-service', [\App\Http\Controllers\ServiceController::class, 'create']);
Route::post('/store-service', [\App\Http\Controllers\ServiceController::class, 'store']);
Route::get('/edit-service/{id}', [\App\Http\Controllers\ServiceController::class, 'edit']);
Route::put('/update-service/{id}', [\App\Http\Controllers\ServiceController::class, 'update']);
