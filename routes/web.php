<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

//*********************************** AUTHENTICATION ROUTES *************************************//
Route::post('auth',[LoginController::class, 'authenticate'])->name('auth');

Route::post('verify',[LoginController::class, 'verifyOtp'])->name('verify');

Route::post('logout',[LoginController::class, 'logout'])->name('logout');

//*********************************** END OF AUTHENTICATION ROUTES *************************************//
