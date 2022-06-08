<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\UserDetails;
use App\Models\UserBalance;
use App\Models\Sales;
use Illuminate\Support\Str;
use Auth;

class AgentSalesController extends Controller
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
        return view('agent.sales');
    }


    public function addSales(Request $request){
        $request->user()->authorizeRoles('agent');

        if($request->isMethod('post')){
            $data = $request->all();
            $sale = new Sales;
            $sale->property_id = $data['property_id'];
            $sale->user_id = Auth::user()->id;
            $sale->price = $data['price'];
            $sale->commission = 0;

            if($sale->save()){
                return redirect('/agent/sales')->with('success', 'Sales Created Successfully');
            }else{
                return redirect('/agent/sales/new')->with('error', 'Error cccured when creating sales, kindly try again.');
            }
        }

        return view('agent.add_sales');
    }


    public function salesData(){
        $users = DB::table('users')
                    ->join('sales', 'users.id', 'sales.agent_id')
                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                    // ->leftjoin('user_details as u2', 'users.upline_0_id', 'u2.user_id')
                    ->leftjoin('user_balance', 'users.id', 'user_balance.user_id')
                    ->where('users.id', Auth::user()->id)
                    ->select('sales.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no','user_balance.amount as balance', 
                        // 'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name'
                    )
                    ->get();

        return Datatables::of($users)
                ->addColumn('set-commission', function($users){
                    return '<button type="button" class="btn btn-dark btn-sm" id="updateCommission" data-toggle="modal" data-target="#exampleModal" data-agentid="'.$users->id.'" data-agentname="'.$users->first_name ." ". $users->last_name.'">Set Commission</button>';
                })
                ->addColumn('status', function($users){
                    if($users->status == 0){
                        return '<button class="btn btn-default btn-sm">Pending</button>';
                    }elseif($users->status == 1){
                        return '<button class="btn btn-info btn-sm">Started</button>';
                    }elseif($users->status == 2){
                        return '<button class="btn btn-primary btn-sm">Lawyer</button>';
                    }elseif($users->status == 3){
                        return '<button class="btn btn-secondary btn-sm">Payment</button>';
                    }elseif($users->status == 4){
                        return '<button class="btn btn-dark btn-sm">Registration</button>';
                    }else{
                        return '<button class="btn btn-success btn-sm">Ready</button>';
                    }
                    
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                // ->addColumn('referralname', function($users){
                //     return $users->referral_first_name ." ". $users->referral_last_name;
                // })
                ->rawColumns(['action', 'delete-action','set-commission','status'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }

}
