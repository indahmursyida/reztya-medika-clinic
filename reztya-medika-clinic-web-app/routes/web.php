<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
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
Route::get('/signup', [SignUpController::class, 'signUp'])->middleware('guest');
Route::post('/signup', [SignUpController::class, 'userRegister']);

// Sign In
Route::get('/signin', function () {
    return view('users.signin');
})->middleware('guest');
Route::post('/signin', [SignInController::class, 'userLogin']);

// Sign Out
Route::post('/signout', [SignInController::class, 'userLogout'])->middleware('auth');

// View Profile
Route::get('/view-profile/{username}', [ProfileController::class, 'viewProfile'])->middleware('auth');

// Edit Profile
Route::get('/edit-profile/{username}', [ProfileController::class, 'viewEditProfile'])->middleware('auth');
Route::post('/edit-profile/{username}', [ProfileController::class, 'editProfile'])->middleware('auth');

// Change Password
Route::post('/change-password/{username}', [ProfileController::class, 'changePassword'])->middleware('auth');

//Product
Route::get('/manage-products', [ProductController::class, 'index']);
Route::get('/product-detail/{id}', [ProductController::class, 'show']);
Route::post('/delete-product/{id}', [ProductController::class, 'destroy']);
Route::get('/add-product', [ProductController::class, 'create']);
Route::post('/store-product', [ProductController::class, 'store']);
Route::get('/edit-product/{id}', [ProductController::class, 'edit']);
Route::put('/update-product/{id}', [ProductController::class, 'update']);

//Service
Route::get('/manage-services', [ServiceController::class, 'index']);
Route::get('/service-detail/{id}', [ServiceController::class, 'show']);
Route::post('/delete-service/{id}', [ServiceController::class, 'destroy']);
Route::get('/add-service', [ServiceController::class, 'create']);
Route::post('/store-service', [ServiceController::class, 'store']);
Route::get('/edit-service/{id}', [ServiceController::class, 'edit']);
Route::put('/update-service/{id}', [ServiceController::class, 'update']);
