<?php

namespace App\Http\Controllers\Moderator;

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

use Auth;

class ModeratorInspectionsController extends Controller
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
    	$request->user()->authorizeRoles('moderator');
        return view('moderator.inspections');
    }

    public function updateInspection(Request $request){
        // $request->user()->authorizeRoles('moderator');

        $data = $request->all();

        $updated = Inspection::where(['id'=>$data['id']])->update(['status'=>$data['status']]);

        if($updated){
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
