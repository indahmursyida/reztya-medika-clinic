<?php

use App\Http\Controllers\BanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentReceiptController;

use Illuminate\Http\Request;
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
Route::permanentRedirect('/logout', '/home')->middleware(['auth', 'verified']);

Route::group(['middleware' => 'prevent-back-history'], function() {
    // Start Group cannot back //
    // Home
    Route::get('/home', [HomeController::class, 'home']);

    Route::get('/active-order', function () {
        return view('active-order');
    })->middleware(['auth', 'verified']);

    Route::get('/payment-receipt-form', function () {
        return view('payment-receipt-form');
    })->middleware(['auth', 'verified']);

    // Sign Up
    Route::get('/signup', [SignUpController::class, 'signUp'])->middleware('guest');
    Route::post('/signup', [SignUpController::class, 'userRegister']);

    Route::get('/email/verify', function () {
        return view('users.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/home');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link verifikasi telah dikirim!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // Sign In
    Route::get('/signin', function () {
        return view('users.signin');
    })->middleware('guest')->name('login');
    Route::post('/signin', [SignInController::class, 'userLogin']);

    // Sign Out
    Route::post('/signout', [SignInController::class, 'userLogout'])->middleware('auth');

    // View Profile
    Route::get('/view-profile/{username}', [ProfileController::class, 'viewProfile'])->middleware(['auth', 'verified']);

    // Edit Profile
    Route::get('/edit-profile/{username}', [ProfileController::class, 'viewEditProfile'])->middleware(['auth', 'verified']);
    Route::post('/edit-profile/{username}', [ProfileController::class, 'editProfile'])->middleware(['auth', 'verified']);

    // Change Password
    Route::post('/change-password/{username}', [ProfileController::class, 'changePassword'])->middleware(['auth', 'verified']);

    // Reset Password
    Route::get('/reset-password', function () {
        return view('users.reset_password');
    })->middleware('guest');
    Route::post('/reset-password', [ProfileController::class, 'resetPassword'])->middleware('guest');

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
    Route::get('/manage-schedules', [ScheduleController::class, 'index'])->middleware('admin');
    Route::get('/add-schedule', [ScheduleController::class, 'add'])->middleware('admin');
    Route::post('/add-schedule', [ScheduleController::class, 'store'])->middleware('admin');
    Route::get('/edit-schedule/{id}', [ScheduleController::class, 'edit'])->middleware('admin');
    Route::put('/update-schedule/{id}', [ScheduleController::class, 'update'])->middleware('admin');
    Route::get('/delete-schedule/{id}', [ScheduleController::class, 'delete'])->middleware('admin');

    //OrderDetail
    Route::post('/buy-product', [CartController::class, 'buyProduct'])->middleware(['auth', 'verified']);
    Route::post('/book-service', [CartController::class, 'bookService'])->middleware(['auth', 'verified']);

    // Ban and Unban User
    Route::get('/view-users', [BanController::class, 'viewUsers'])->middleware('admin');
    Route::post('/ban-user/{username}', [BanController::class, 'banUser'])->middleware('admin');
    Route::post('/unban-user/{username}', [BanController::class, 'unbanUser'])->middleware('admin');

    // Category
    Route::get('/manage-categories', [CategoryController::class, 'index'])->middleware('admin');
    Route::post('/delete-category/{id}', [CategoryController::class, 'destroy'])->middleware('admin');
    Route::get('/add-category', [CategoryController::class, 'create'])->middleware('admin');
    Route::post('/store-category', [CategoryController::class, 'store'])->middleware('admin');
    Route::get('/edit-category/{id}', [CategoryController::class, 'edit'])->middleware('admin');
    Route::put('/update-category/{id}', [CategoryController::class, 'update'])->middleware('admin');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->middleware(['auth', 'verified']);
    Route::put('/update-schedule/{id}', [CartController::class, 'updateCartSchedule'])->middleware(['auth', 'verified']);
    Route::put('/update-quantity/{id}', [CartController::class, 'updateCartQuantity'])->middleware(['auth', 'verified']);
    Route::get('/remove-cart/{id}', [CartController::class, 'removeCart'])->middleware(['auth', 'verified']);

    //Order
    Route::get('/create-order', [OrderController::class, 'create'])->middleware(['auth', 'verified']);
    Route::get('/active-order', [OrderController::class, 'activeOrder'])->middleware(['auth', 'verified']);

    Route::get('/order-detail/{id}', [OrderController::class, 'detailOrder'])->name('detail_order')->middleware(['auth', 'verified']);
    Route::put('/reschedule/{id}', [OrderController::class, 'reschedule'])->middleware(['auth', 'verified']);
    Route::get('/cancel-order/{id}', [OrderController::class, 'cancel_order'])->middleware(['auth', 'verified']);
    Route::get('/confirm-payment/{id}', [OrderController::class, 'confirmPayment'])->middleware('admin');
    Route::post('/update-payment-receipt/{id}', [OrderController::class, 'updatePaymentReceipt'])->middleware('admin');
    Route::get('/history-order', [OrderController::class, 'historyOrder'])->middleware(['auth', 'verified']);
    Route::get('/payment-receipt-form/{id}', [OrderController::class, 'form_payment_receipt'])->name('form_payment')->middleware('admin');

    Route::post('/add-payment-receipt/{id}', [OrderController::class, 'add_payment_receipt'])->middleware('admin');
    Route::get('/repeat-order/{id}', [OrderController::class, 'repeatOrder'])->middleware(['auth', 'verified']);

    Route::get('/history-order/finished', [OrderController::class, 'filterFinished'])->middleware(['auth', 'verified']);
    Route::get('/history-order/canceled', [OrderController::class, 'filterCanceled'])->middleware(['auth', 'verified']);

    Route::put('/upload-transfer-receipt/{id}', [PaymentReceiptController::class, 'transferReceipt'])->middleware(['auth', 'verified']);
});
