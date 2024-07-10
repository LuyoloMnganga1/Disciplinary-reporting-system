<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\EmailGatewayController;
use App\Http\Controllers\EmailBodyController;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgotpassword');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ooops! The provided email doesn\'t exist in our records.',
                ]);
        }

        $token = Str::random(25);
        //first delete the exitsing record from the table
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        //insert the new token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $id = DB::table('users')->where('email', $request->email)->value('id');

        $mail = new EmailGatewayController();
        $mail->sendEmail($request->email, 'HR Focus | Disciplinary Report System - Forgot Password', EmailBodyController::forgotpassword($id, $token));

        return response()->json([
            'status' => 'success',
            'message' => 'A fresh verification link has been sent to your email address!',
        ]);
    }
}
