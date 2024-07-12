<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserPasswords;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {

            $data = User::all();

            return Datatables::of($data)
                ->addIndexColumn()

                //**************NAME COLUMN**********//
                ->addColumn('name', function ($row) {

                    return $row->name;
                })
                //**********END NAME COLUMN*********//

                //**************EMAIL COLUMN**********//
                ->addColumn('email', function ($row) {

                    return $row->email;
                })
                //**********END EMAIL COLUMN*********//


                //**************ROLE COLUMN**********//
                ->addColumn('role', function ($row) {
                    $role = $row->role;
                    return $role;
                })
                //**********ROLE COLUMN*********//


                //**************ACTION COLUMN**********//
                ->addColumn('action', function ($row) {
                    $user = User::where('email',$row->email)->first();
                    $action = '<div class="btn-group">
                    <button type="button" class="btn btn-warning text-light" data-id="'.$user->id.'" data-bs-toggle="modal" id="edit"><i class="fa fa-pencil"></i></button>
                    <button type="button" class="btn btn-danger" data-id="'.$user->id.'" data-bs-toggle="modal"  id="delete"><i class="fa fa-trash"></i></button>
                    </div>';
                    return $action;
                })
                //**********END ACTION COLUMN*********//

                ->rawColumns(['created_at', 'event', 'user_id', 'action'])
                ->make(true);
            return view('users')->with('data', $data);
        }
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'All fields are required. Also,the email must be unique from all users',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        try{
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            $user = User::where('email',$request->email)->first();
            $token = Str::random(20);
            $name = $user->name;
            $id = $user->id;

            $mail = new EmailGatewayController();
            $mail->sendEmail($user->email,'HR Focus | Disciplinary Report System - User Account Created',EmailBodyController::useraccount($name,$id, $token));

            $notification = array(
                'message' => 'User added successfully and an email has been sent to the user to create a password',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }catch(\Exception $e){
             // Log error or handle appropriately
             \Log::error('Failed to add user and send email: ' . $e->getMessage());
             $notification = array(
                'message' => 'Failed to add user and send email:'. $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
              // Failed to update
        }
    }
    public function passwordCreate($id,$token)
    {
        return view('auth.password')->with(
            [
                'id'=> $id,
                'token'=> $token
            ]);
    }

    public function setPassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
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

    try {
        // Retrieve the user ID from the request
        $id = $request->id;

        // Update the user's password in the users table
        User::whereId($id)->update(['password' => Hash::make($request->password)]);

        // Store the new hashed password in the user_passwords table
        UserPasswords::create([
            'user_id' => $id,
            'password' => Hash::make($request->password),
            'updated_at' => Carbon::now(),
        ]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Your password has been captured successfully!',
            'route' => '/login'
        ]);

    } catch (\Exception $e) {
        \Log::error('Failed to update password: ' . $e->getMessage());

        // Return error response
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update password: ' . $e->getMessage(),
        ]);
    }
  }
    public function editUser($id)
    {
        $user = User::find($id);

        return response()->json([
            'status' => 'success',
            'name'=>$user->name,
            'email'=>$user->email,
            'role'=>$user->role,
        ]);
    }
    public function updateUser(Request $request)
    {
        $id = $request->user_id;
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,'.$id],
            'role' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'All fields are required. Also,the email must be unique from all users',
            ]);
        }

        try {
            $user = User::findOrFail($request->user_id);
            User::whereId($user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Updated Successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            // Handle the case where the user is not found
            \Log::error('User not found: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        } catch (\Exception $e) {
            // Log error or handle appropriately
            \Log::error('Failed to update user: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user: ' . $e->getMessage(),
            ]); // Failed to update
        }
    }
    public function deleteUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->delete();
            $notification = array(
                'message' => 'User Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } catch (ModelNotFoundException $e) {
            // Handle the case where the user is not found
            \Log::error('User not found: ' . $e->getMessage());
            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            // Log error or handle appropriately
            \Log::error('Failed to delete user: ' . $e->getMessage());
            $notification = array(
                'message' => 'Failed to delete user: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

}
