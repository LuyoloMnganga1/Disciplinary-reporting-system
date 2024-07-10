<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\UserPasswords;

class ResetPasswordController extends Controller {

  public function restPasswordForm($id,$token) {
    $email = User::where('id', $id)->value('email');

    if (!$email) {
        return redirect()->route('login');
    }

    // Retrieve the most recent password reset token for the user
    $latestReset = DB::table('password_reset_tokens')
        ->where('email', $email)
        ->orderBy('created_at', 'desc')
        ->first();

    if (!$latestReset || $latestReset->token !== $token) {
        return redirect()->route('login');
    }

    $tokenCreatedAt = new Carbon($latestReset->created_at);
    $currentTime = Carbon::now();

    // Check if the token is expired (considering a 10-minute validity period)
    if ($tokenCreatedAt->diffInMinutes($currentTime) > 10) {
        $notification = array(
            'message' => 'Ooops! Link expired, please request a new one.',
            'alert-type' => 'error'
        );
        return redirect('forgot-password')->with($notification);
    }

    // If the token is valid, load the reset password view
    return view('auth.resetpassword', [
        'token' => $token,
        'email' => $email,
        'date' => $currentTime,
    ]);


  }

  public function updatePassword(Request $request)
  {

    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users',
        'password' => [
            'required',
            'confirmed',
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
            'min:8',
        ],
        'password_confirmation' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Please provide a password that meets the specified requirements.',
            'errors' => $validator->errors(),
        ]);
    }

    // Check if the provided email and token combination exists in the password_reset_tokens table
    $updatePassword = DB::table('password_reset_tokens')
        ->where(['email' => $request->email, 'token' => $request->token])
        ->first();

    if (!$updatePassword) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid token!',
        ]);
    }

    // Retrieve the user ID associated with the provided email
    $id = User::where('email', $request->email)->value('id');

    // Retrieve the last 5 hashed passwords for the user
    $userPasswords = UserPasswords::where('user_id', $id)
        ->orderBy('updated_at', 'desc')
        ->pluck('password')
        ->take(5);


    // Check if the new password matches any of the last 7 hashed passwords
    $count = 0;
    foreach ($userPasswords as $hashedPassword) {
        if((Hash::check($request->password, $hashedPassword))) {
            $count++;
        }
    }
    if ($count > 4) {
        return response()->json([
            'status' => 'error',
            'message' => 'Ooops! The new password has been used 4 times before. Please generate a new password.',
        ]);
    }

    // Update the user's password in the users table
    User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);

    // Store the new hashed password in the user_passwords table
    UserPasswords::create([
        'user_id' => $id,
        'password' => Hash::make($request->password),
        'updated_at' => Carbon::now(),
    ]);

    // Redirect to the login page with a success message
    return response()->json([
        'status' => 'success',
        'message' => ' Your password has been changed successfully!',
        'route'=>'/login'
    ]);

  }
}
