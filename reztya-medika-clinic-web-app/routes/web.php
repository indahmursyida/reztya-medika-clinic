<?php

use App\Http\Controllers\ScheduleController;
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

Route::get('/manage-schedule', [ScheduleController::class, 'index'])->name('manage-schedule');
Route::get('/edit-schedule/{id}', [ScheduleController::class, 'edit'])->name('edit-schedule');
Route::post('/update-schedule', [ScheduleController::class, 'update_schedule'])->name('update-schedule');
Route::get('/delete-schedule/{id}', [ScheduleController::class, 'delete_schedule'])->name('delete-schedule');

Route::get('/add-schedule', function () {
    return view('add-schedule');
});

Route::post('/add-schedule', function () {
    return view('add-schedule');
});

Route::get('/edit-schedule', function () {
    return view('edit-schedule');
});

Route::get('/view-order', function () {
    return view('view-order');
});
