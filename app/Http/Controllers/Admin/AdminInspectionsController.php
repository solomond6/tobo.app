<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Countries;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\UserDetails;
use App\Models\Inspection;
use Illuminate\Support\Str;
use App\Notifications\UserNotification;
use Notification;

use Auth;

class AdminInspectionsController extends Controller
{
    public function __construct()
    {
        if(Auth::check()){
            
        }else{
            return redirect('/');
        }
        parent::__construct();
    }

    public function index(Request $request){
    	$request->user()->authorizeRoles('admin');
        auth()->user()->unreadNotifications->markAsRead();
        return view('admin.inspections');
    }

    public function updateInspection(Request $request){
        // $request->user()->authorizeRoles('admin');

        $data = $request->all();

        $inspection = Inspection::find($data['id']);

        $updated = Inspection::where(['id'=>$data['id']])->update(['status'=>$data['status']]);

        if($data['status']== 1){
            $status = "Approved";
        }else{
            $status = "Rejected";
        }

        if($updated){

            $user = User::find($inspection->user_id);

            $details = [
                'greeting' => 'Hi,'.$user->first_name,
                'body' => 'Inspection trip with id '.$inspection->id.' has been '.$status,
                'thanks' => '',
                'actionText' => 'View',
                'actionURL' => url('/agent/inspections'),
                'data_id' => $inspection->id
            ];
      
            Notification::send($user, new UserNotification($details));

            return redirect()->back()->with('success', 'Inspection Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating inspection, kindly try again.');
        }
    }


    public function inspectionsData(){
        $inspections = DB::table('inspections')
                    ->join('user_details as u1', 'inspections.user_id', 'u1.user_id')
                    ->select('inspections.*', 'u1.first_name as agent_firstname', 'u1.last_name as agent_lastname')->latest();

        return Datatables::of($inspections)
                ->addColumn('update-action', function($inspections){

                    if($inspections->status == 0){
                        return '<button type="button" class="btn btn-dark btn-sm" id="updateInspection" data-toggle="modal" data-target="#exampleModal" data-inspectionid="'.$inspections->id.'" >Update Status</button>';
                    }else{
                        return "";
                    }
                    
                })
                ->addColumn('status', function($inspections){
                    if($inspections->status == 0){
                        return '<button class="btn btn-default btn-sm">Pending</button>';
                    }elseif($inspections->status == 1){
                        return '<button class="btn btn-success btn-sm">Approved</button>';
                    }else{
                        return '<button class="btn btn-danger btn-sm">Rejected</button>';
                    }  
                })
                ->addColumn('agent_name', function($inspections){
                    return $inspections->agent_firstname ." ". $inspections->agent_lastname;
                })
                ->rawColumns(['action', 'update-action', 'status'])
                ->editColumn('id', '{{$id}}')
                ->make(true);
    }


}
