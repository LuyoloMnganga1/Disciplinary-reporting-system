<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;

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

Route::post('/create-password',  [UserController::class,'setPassword'])->name('create-password');

Route::get('/set-password/{id}/{token}',  [UserController::class,'passwordCreate'])->name('set-Password');

//*********************************** END OF AUTHENTICATION ROUTES *************************************//

//*********************************** BACK-END ROUTES *************************************************//
Route::group(['middleware' => ['auth']], function(){
    //**************************************DASHBOARD ROUTES *********************************//

    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

     //*******************************END OF DASHBOARD ROUTES *********************************//

     //*******************************AUDIT ROUTES *********************************//
     Route::get('/audit',[AuditController::class, 'index'])->name('audit');

     Route::get('view_audit/{id}', [AuditController::class, 'auditDetails'])->name('view_audit');

     Route::get('get_audits', [AuditController::class, 'getAudits'])->name('get_audits');
     //*******************************END OF AUDIT ROUTES *********************************//

    //*******************************USERS ROUTES *********************************//
    Route::get('/users',[UserController::class, 'index'])->name('users');

    Route::get('/get_users', [UserController::class, 'getUsers'])->name('get_users');

    Route::get('/user/edit/{id}', [UserController::class, 'editUser']);

    Route::post('/user/update', [UserController::class, 'updateUser'])->name('update-user');

    Route::post('/user/delete', [UserController::class, 'deleteUser'])->name('delete-user');

    Route::post('/user/add', [UserController::class, 'addUser'])->name('add-user');
     //*******************************END OF USERS ROUTES *********************************//
});
//*********************************** END OF BACK-END ROUTES *************************************************//
