<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Withdrawal;
use Illuminate\Support\Str;
use Image;
use Auth;

class WithdrawalController extends Controller
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
        return view('admin.withdrawal');
    }

    public function approveWithdrawal(Request $request, $id=null){
        // $request->user()->authorizeRoles('admin');
        // var_dump($id);exit;
        $updated = Withdrawal::where(['id'=>$id])->update(['status'=>1, 'approved_by'=>Auth::user()->id]);

        if($updated){
            return redirect()->back()->with('success', 'Withdrawal Approved Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating withdrawal, kindly try again.');
        }
    }
    

    public function withdrawalsData(){
        $withdrawals = DB::table('withdrawal')
                    ->join('user_details as u1', 'withdrawal.user_id', 'u1.user_id')
                    ->select('withdrawal.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no')
                    ->latest();

        return Datatables::of($withdrawals)
                ->addColumn('action', function($withdrawals){
                    if($withdrawals->status == 0){
                        return '<a href="/admin/approve-withdrawal/'.$withdrawals->id.'" class="btn btn-danger btn-sm">Approve</a>';
                    }
                })
                ->addColumn('name', function($withdrawals){
                    return $withdrawals->first_name ." ". $withdrawals->last_name ;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


}
