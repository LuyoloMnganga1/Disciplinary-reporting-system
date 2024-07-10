<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserPasswords;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'All fields are required',
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Auth::logoutOtherDevices(request('password'));

            // Check password expiration
            $password_data_date = UserPasswords::where('user_id', Auth::user()->id)
                ->orderBy('updated_at', 'desc')
                ->value('updated_at');

            $now = Carbon::now();
            $password_date = new Carbon($password_data_date);

            if ($password_date->diffInDays($now) >= 90) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Password has expired. Request a password reset link via forgot password.',
                ]);
            } else {
                $results = $this->sendOTP();

                if ($results === true) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login successful. OTP has been sent!',
                    ]);
                } else {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to send OTP. Contact the System Administrator.',
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials. Please try again.',
        ]);
    }

    public function verifyOTP(Request $request) {
        // Validate the request input
        $validator = Validator::make($request->all(), [
            'otp' => ['required'],
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'message' => 'One Time Pin is required',
            ]);
        }

        // Retrieve the OTP and its timestamp for the authenticated user
        $user = Auth::user();
        $storedOtp = $user->one_time_pin;
        $otpTimestamp = new Carbon($user->one_time_pin_time);
        $currentTimestamp = Carbon::now();

        // Check if the provided OTP matches the stored OTP
        if ($storedOtp == $request->otp) {
            // Check if the OTP is still valid (within 3 minutes)
            if ($otpTimestamp->diffInMinutes($currentTimestamp) <= 3) {
                // Update the user's one_time_pin to indicate verification
                $user->update(['user_one_time_pin' => $request->otp]);
                $request->session()->regenerate();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Provide One Time Pin is correct',
                    'route'=>'/dashboard'
                ]);

            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Oops! One Time Pin has expired, please request a new OTP.',
                ]);
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Incorrect One Time Pin. Please enter the correct One Time Pin.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function sendOTP()
    {
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $id = $user->id;

        // Generate OTP
        $one_time_pin = $this->genOtp();
        $one_time_pin_time = Carbon::now()->toDateTimeString();

        // Update user with OTP and date
        User::whereId($id)->update([
            'one_time_pin' => $one_time_pin,
            'one_time_pin_time' => $one_time_pin_time,
        ]);

        // Prepare OTP message
        $message = "Disciplinary Report System OTP: $one_time_pin. This OTP will expire in 3 minutes";

        // Initialize Email sending classes
        $mail = new EmailGatewayController();

        // Send OTP via email
        try {
            $mail->sendEmail($email, 'HR Focus | Disciplinary Report System - OTP verification', EmailBodyController::sendotp($name, $message));
            return true; // Successfully sent OTP via email
        } catch (\Exception $e) {
            // Log error or handle appropriately
            \Log::error('Failed to send OTP via email: ' . $e->getMessage());
            return false; // Failed to send OTP via email
        }
    }

    public function genOtp()
    {
        // Generate a 6-digit OTP
        $otp =  rand(100000, 999999);
        return $otp;
    }
}
