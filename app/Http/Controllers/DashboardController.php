<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
        public function index(Request $request)
    {
        // Check if the authenticated user does not have a one-time pin
        if (!Auth::user()->user_one_time_pin) {
            // Log the user out
            Auth::logout();

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate the CSRF token
            $request->session()->regenerateToken();

            // Prepare the notification message
            $notification = array(
                'message' => 'Ooops! One Time Pin was not captured, please login again.',
                'alert-type' => 'error'
            );

            // Redirect to the login route with the notification
            return redirect()->route('login')->with($notification);
        }

        // Return the dashboard view if the user has a one-time pin
        return view('dashboard.index');
    }
}
