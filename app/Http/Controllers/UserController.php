<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\User;

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
    public function updateUser(Request $request,$id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'User Updated Successfully',
            ]);
    }
}
