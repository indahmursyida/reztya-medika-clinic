<?php

use App\Http\Controllers\BanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\EmailNotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    return view('home.home_page');
});

Route::get('/active-order', function () {
    return view('active-order');
});

Route::get('/payment-receipt-form', function () {
    return view('payment-receipt-form');
});

// Sign Up
Route::get('/signup', [SignUpController::class, 'signUp'])->middleware('guest');
Route::post('/signup', [SignUpController::class, 'userRegister']);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Link verifikasi telah dikirim!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Sign In
Route::get('/signin', function () {
    return view('users.signin');
})->middleware('guest');
Route::post('/signin', [SignInController::class, 'userLogin']);

// Sign Out
Route::post('/signout', [SignInController::class, 'userLogout'])->middleware('auth');
Route::post('/signout', [SignInController::class, 'userLogout'])->middleware('auth');

// View Profile
Route::get('/view-profile/{username}', [ProfileController::class, 'viewProfile'])->middleware('auth');

// Edit Profile
Route::get('/edit-profile/{username}', [ProfileController::class, 'viewEditProfile'])->middleware('auth');
Route::post('/edit-profile/{username}', [ProfileController::class, 'editProfile'])->middleware('auth');

// Change Password
Route::post('/change-password/{username}', [ProfileController::class, 'changePassword'])->middleware('auth');

// Products
Route::get('/view-products', [ProductController::class, 'view']);
Route::get('/manage-products', [ProductController::class, 'index'])->middleware('admin');
Route::get('/product-detail/{id}', [ProductController::class, 'show']);
Route::post('/delete-product/{id}', [ProductController::class, 'destroy'])->middleware('admin');
Route::get('/add-product', [ProductController::class, 'create'])->middleware('admin');
Route::post('/store-product', [ProductController::class, 'store'])->middleware('admin');
Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->middleware('admin');
Route::put('/update-product/{id}', [ProductController::class, 'update'])->middleware('admin');
Route::get('/view-products/search-product', [ProductController::class, 'search']);
Route::get('/view-products/filter/name/a-to-z', [ProductController::class, 'filterAtoZ']);
Route::get('/view-products/filter/name/z-to-a', [ProductController::class, 'filterZtoA']);
Route::get('/view-products/filter/price/high-to-low', [ProductController::class, 'filterPriceHightoLow']);
Route::get('/view-products/filter/price/low-to-high', [ProductController::class, 'filterPriceLowtoHigh']);
Route::get('/view-products/filter/category/{category_name}', [ProductController::class, 'filterCategory']);


// Services
Route::get('/view-services', [ServiceController::class, 'view']);
Route::get('/manage-services', [ServiceController::class, 'index'])->middleware('admin');
Route::get('/service-detail/{id}', [ServiceController::class, 'show']);
Route::post('/delete-service/{id}', [ServiceController::class, 'destroy'])->middleware('admin');
Route::get('/add-service', [ServiceController::class, 'create'])->middleware('admin');
Route::post('/store-service', [ServiceController::class, 'store'])->middleware('admin');
Route::get('/edit-service/{id}', [ServiceController::class, 'edit'])->middleware('admin');
Route::put('/update-service/{id}', [ServiceController::class, 'update'])->middleware('admin');
Route::get('/view-services/search-services', [ServiceController::class, 'search']);
Route::get('/view-services/filter/name/a-to-z', [ServiceController::class, 'filterAtoZ']);
Route::get('/view-services/filter/name/z-to-a', [ServiceController::class, 'filterZtoA']);
Route::get('/view-services/filter/price/high-to-low', [ServiceController::class, 'filterPriceHightoLow']);
Route::get('/view-services/filter/price/low-to-high', [ServiceController::class, 'filterPriceLowtoHigh']);
Route::get('/view-services/filter/category/{category_name}', [ServiceController::class, 'filterCategory']);

// Schedules
Route::get('/manage-schedules', [ScheduleController::class, 'index']);
Route::get('/add-schedule', [ScheduleController::class, 'add']);
Route::post('/add-schedule', [ScheduleController::class, 'store']);
Route::get('/edit-schedule/{id}', [ScheduleController::class, 'edit']);
Route::put('/update-schedule/{id}', [ScheduleController::class, 'update']);
Route::get('/delete-schedule/{id}', [ScheduleController::class, 'delete']);

//OrderDetail
Route::post('/buy-product', [OrderDetailController::class, 'buyProduct']);
Route::post('/book-service', [OrderDetailController::class, 'bookService']);

// Ban and Unban User
Route::get('/view-users', [BanController::class, 'viewUsers'])->middleware('admin');
Route::post('/ban-user/{username}', [BanController::class, 'banUser'])->middleware('admin');
Route::post('/unban-user/{username}', [BanController::class, 'unbanUser'])->middleware('admin');

// Category
Route::get('/manage-categories', [CategoryController::class, 'index']);
Route::post('/delete-category/{id}', [CategoryController::class, 'destroy']);
Route::get('/add-category', [CategoryController::class, 'create']);
Route::post('/store-category', [CategoryController::class, 'store']);
Route::get('/edit-category/{id}', [CategoryController::class, 'edit']);
Route::put('/update-category/{id}', [CategoryController::class, 'update']);

// Order
Route::get('/order', [OrderController::class, 'order']);
Route::put('/update-order-item/{id}', [OrderController::class, 'update_order_item']);
Route::post('/update_order_status_on_going/{id}', [OrderController::class, 'update_order_status_on_going']);
Route::get('/active-order', [OrderController::class, 'active_order']);
Route::put('/reschedule/{id}', [OrderController::class, 'reschedule']);
Route::get('/delete-order-item/{id}', [OrderController::class, 'delete_order_item']);
Route::get('/cancel-order/{id}', [OrderController::class, 'cancel_order']);
Route::get('/finish-order/{id}', [OrderController::class, 'finish_order']);
Route::get('/history-order', [OrderController::class, 'history_order']);
Route::get('/payment-receipt-form/{id}', [OrderController::class, 'form_payment_receipt'])->name('form_payment');
Route::get('/history-order/filter/status/{status}', [OrderController::class, 'filter_status']);
Route::post('/add-payment-receipt', [OrderController::class, 'add_payment_receipt']);

//Notification Email
Route::get('/send-notification', [EmailNotificationController::class, 'index']);