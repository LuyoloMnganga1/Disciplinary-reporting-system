<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
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
    return redirect()->route('login');
});

//*********************************** AUTHENTICATION ROUTES *************************************//
Route::get('/login',[LoginController::class, 'index'])->name('login');

Route::post('/authentication',[LoginController::class, 'authenticate'])->name('authentication');

Route::post('/verify',[LoginController::class, 'verifyOtp'])->name('verify');

Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password',[ForgotPasswordController::class, 'index'])->name('forgot-password');

Route::post('/send-password-reset-link',[ForgotPasswordController::class, 'sendPasswordResetLink'])->name('send-password-reset-link');

Route::get('/reset-password/{id}/{token}', [ResetPasswordController::class,'restPasswordForm'])->name('reset-password-form');
Route::post('/reset-password',  [ResetPasswordController::class,'updatePassword'])->name('reset-Password');

//*********************************** END OF AUTHENTICATION ROUTES *************************************//

//*********************************** BACK-END ROUTES *************************************************//
Route::group(['middleware' => ['auth']], function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
});
//*********************************** END OF BACK-END ROUTES *************************************************//
