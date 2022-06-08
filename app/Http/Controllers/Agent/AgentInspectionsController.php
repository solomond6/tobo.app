<?php

namespace App\Http\Controllers\Agent;

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

class AgentInspectionsController extends Controller
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
    	$request->user()->authorizeRoles('agent');
        auth()->user()->unreadNotifications->markAsRead();
        return view('agent.inspections');
    }

    public function UpdateCommissionAmt(Request $request){
        // $request->user()->authorizeRoles('admin');
        $updated = User::where(['id'=>$id])->update(['status'=>3]);
        if($updated){
            return redirect()->back()->with('success', 'Agent Commission Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating agent commission, kindly try again.');
        }
    }


    public function addInspection(Request $request){
        $request->user()->authorizeRoles('agent');

        if($request->isMethod('post')){
            $data = $request->all();
            $inspection = new Inspection;
            $inspection->user_id = Auth::user()->id;
            $inspection->fullname = $data['fullname'];
            $inspection->email = $data['email'];
            $inspection->phone_no = $data['phone_no'];
            $inspection->country = $data['country'];
            $inspection->no_of_people = $data['no_of_people'];
            $inspection->budget = $data['budget'];
            $inspection->arrival_date = $data['arrival_date'];
            $inspection->arrival_time = $data['arrival_time'];
            $inspection->arrival_airport = $data['arrival_airport'];
            $inspection->arrival_flight_no = $data['arrival_flight_no'];
            $inspection->arrival_airline = $data['arrival_airline'];
            $inspection->departure_date = $data['departure_date'];
            $inspection->departure_time = $data['departure_time'];
            $inspection->departure_airport = $data['departure_airport'];
            $inspection->departure_flight_no = $data['departure_flight_no'];
            $inspection->departure_airline = $data['departure_airline'];
            $inspection->transfer_inquiry = $data['transfer_inquiry'];
            $inspection->accommodation_inquiry = $data['accommodation_inquiry'];
            $inspection->additional_note = $data['additional_note'];
            $inspection->status = 0;
            
            if($inspection->save()){

                $admin = User::find(1);

                $details = [
                    'greeting' => 'Hi,'.$admin->first_name,
                    'body' => 'New Inspection trip with id '.$inspection->id,
                    'thanks' => '',
                    'actionText' => 'View',
                    'actionURL' => url('/admin/inspections'),
                    'data_id' => $inspection->id
                ];

                Notification::send($admin, new UserNotification($details));

                return redirect('/agent/inspections')->with('success', 'Inspection Created Successfully');
            }else{
                return redirect('/agent/inspections/new')->with('error', 'Error cccured when creating inspection, kindly try again.');
            }
        }

        $countries = Countries::pluck('name','id');

        return view('agent.add_inspections')->with(compact('countries'));
    }

    public function inspectionsData(){
        $inspections = DB::table('inspections')
                    ->join('user_details as u1', 'inspections.user_id', 'u1.user_id')
                    ->select('inspections.*', 'u1.first_name as agent_firstname', 'u1.last_name as agent_lastname')->latest();

        return Datatables::of($inspections)
                ->addColumn('update-action', function($inspections){
                    return '<a href="/admin/delete-agent/'.$inspections->id.'" class="btn btn-danger btn-sm">Delete</a>';
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
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


}
