<?php

namespace App\Http\Controllers\Moderator;

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
use App\Models\Transaction;
use Illuminate\Support\Str;

use Auth;

class ModeratorTransactionsController extends Controller
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
        return view('moderator.transactions');
    }

    public function transactionsData(){
        $users = DB::table('users')
                    ->join('transactions', 'users.id', 'transactions.user_id')
                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                    ->leftjoin('user_balance', 'users.id', 'user_balance.user_id')
                    ->select('transactions.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no','user_balance.amount as balance', 
                        // 'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name'
                    )
                    ->get();

        return Datatables::of($users)
                ->addColumn('delete-action', function($users){
                    return '<a href="#'.$users->id.'" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                ->rawColumns(['action', 'delete-action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


}
