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

Route::get('/manage-schedule', [ScheduleController::class, 'index']);
Route::post('/add-schedule', [ScheduleController::class, 'add']);
Route::get('/edit-schedule/{id}', [ScheduleController::class, 'edit']);
Route::put('/update-schedule/{id}', [ScheduleController::class, 'update']);
Route::get('/delete-schedule/{id}', [ScheduleController::class, 'delete']);
