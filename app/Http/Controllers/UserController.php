<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

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
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'role' => ['required'],
        ]);

        if ($validator->fails()) {
            $notification = array(
                'message' => 'All fields are required. Also the email must be unique from all users',
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
            $notification = array(
                'message' => 'User added successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }catch(\Exception $e){
             // Log error or handle appropriately
             \Log::error('Failed to add user: ' . $e->getMessage());
             $notification = array(
                'message' => 'Failed to add user:'. $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
              // Failed to update
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
