<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            notify()->success('Login Successfully, OTP has been sent!');
            return response()->json(
                [
                    'status'=>'success',
                    'message'=>'Login Successfully, OTP has been sent!',
                ]
            );
        }
        notify()->error('The provided credentials do not match our records.');
        return response()->json(
            [
                'status'=>'error',
                'message'=>'The provided credentials do not match our records.',
            ]
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
