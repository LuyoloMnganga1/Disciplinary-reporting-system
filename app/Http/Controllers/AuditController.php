<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class AuditController extends Controller
{
    public function index()
    {
        return view('audit.index');
    }
    public static function getuser($id)
    {
        $user = User::where('id',$id)->first();
        $values = [$user->name,$user->email];
        return $values;
    }

    public function getAudits(Request $request)
    {

        if ($request->ajax()) {

            $data = DB::table('audits')->orderBy('created_at', 'desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()

                //**************DATE COLUMN**********//
                ->addColumn('created_at', function ($row) {

                    $to = Carbon::parse($row->created_at)->addHour(2);
                    $from = Carbon::now()->addHour(2);
                    $sec = $to->diffInSeconds($from);
                    $diff_in_minutes = $to->diffInMinutes($from);
                    $hours = $to->diffInHours($from);
                    $days = $to->diffInDays($from);
                    $timer ='';
                    if($sec<60){
                        $timer =$sec.' seconds ago';
                    }elseif ($diff_in_minutes==1) {
                        $timer = $diff_in_minutes.' minute ago';
                    }elseif ($diff_in_minutes<60 && $diff_in_minutes>1) {
                        $timer = $diff_in_minutes.' minutes ago';
                    }

                    $created_at  = $to." ".$timer;
                    return $created_at;
                })
                //**********END DATE COLUMN*********//

                //**************LOG COLUMN**********//
                ->addColumn('event', function ($row) {

                    $color = 'success';
                    if($row->event == 'deleted'){
                       $color = 'danger';
                    }
                    if($row->event == 'created'){
                       $color = 'success';
                    }
                    if($row->event == 'updated'){
                       $color = 'info';
                    }
                    if($row->event == 'restored'){
                       $color = 'secondary';
                    }
                    $event ='<span class="badge badge-'.$color.' text-light">'.ucfirst($row->event).'</span>';
                    if($row->auditable_type){
                        $event= substr($row->auditable_type,11) .'&nbsp;&nbsp; '.$event ;
                    }
                    return $event;
                })
                //**********END LOG COLUMN*********//


                //**************DONE BY COLUMN**********//
                ->addColumn('user_id', function ($row) {
                        $user = $row->user_id ?$this->getuser($row->user_id):null;
                        $user_id ='';
                        if($user){
                            $user_id = '<strong>'.$user[0].'</strong> <br> '.$user[1].' ';
                        }else{
                            $user_id = '<strong></strong> <br>';
                        }

                    return $user_id;
                })
                //**********END DONE BY COLUMN*********//


                //**************ACTION COLUMN**********//
                ->addColumn('action', function ($row) {
                    $action = '<div class="btn-group">
                    <a href="view_audit/' . $row->id . '" type="button" class="btn btn-sm btn-dark text-light">View</a>
                    </div>';
                    return $action;
                })
                //**********END ACTION COLUMN*********//

                ->rawColumns(['created_at', 'event', 'user_id', 'action'])
                ->make(true);
            return view('users')->with('data', $data);
        }
    }

    public function destroy($id)
    {
        try{
            $audit = DB::table('audits')->where('id',$id)->delete();
            $notification = array(
                'message' => 'Audit deleted',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }catch(\Exception $e){

            $notification = array(
                'message' => 'Audit not deleted',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function auditDetails($id){
        $audit = DB::table('audits')->where('id',$id)->get();
        return view('audit.audit_details')->with('audit',$audit);
    }
}
