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
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Support\Str;

use Auth;

class AgentTransactionsController extends Controller
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
        $own_sales = Transaction::where('user_id', Auth::user()->id)->where('comment', 'Sales Bonus')->sum('amount');
        $recuit_sales = Transaction::where('user_id', Auth::user()->id)->where('type', '+')->where('comment', '!=', 'Sales Bonus')->sum('amount');
        $user_balance = UserBalance::where('user_id', Auth::user()->id)->first();
        return view('agent.transactions')->with(compact('user_balance','own_sales','recuit_sales'));
    }

    public function transactionsData(){
        $users = DB::table('users')
                    ->join('transactions', 'users.id', 'transactions.user_id')
                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                    ->leftjoin('user_balance', 'users.id', 'user_balance.user_id')
                    ->where('users.id', Auth::user()->id)
                    ->select('transactions.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no','user_balance.amount as balance', 
                        // DB::raw('ROUND((transactions.amount * 20)/80, 2) AS service_charge'),
                        // DB::raw('(ROUND((transactions.amount * 20)/80, 2) + transactions.amount ) AS commission'),
                        DB::raw('CASE WHEN transactions.type ="+" THEN (ROUND((transactions.amount * 20)/80, 2) + transactions.amount ) WHEN transactions.type ="-" THEN (ROUND((transactions.amount * 2), 2) ) END AS commission'),
                        DB::raw('CASE WHEN transactions.type ="+" THEN ROUND((transactions.amount * 20)/80, 2) WHEN transactions.type ="-" THEN (ROUND((transactions.amount), 2) ) END AS service_charge'),
                        // 'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name'
                    )
                    ->get();

        return Datatables::of($users)
                ->addColumn('delete-action', function($users){
                    return '<a href="/admin/delete-agent/'.$users->id.'" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                ->rawColumns(['action', 'delete-action'])
                ->editColumn('id', '{{ date("Ymd",strtotime($created_at))}}{{$id}}')
                ->make(true);
    }


    public function withdrawalsData(){
        $withdrawals = DB::table('withdrawal')
                            ->join('user_details as u1', 'withdrawal.user_id', 'u1.user_id')
                            ->where('withdrawal.user_id', Auth::user()->id)
                            ->select('withdrawal.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no')
                            ->latest();

        return Datatables::of($withdrawals)
                ->addColumn('action', function($withdrawals){
                    // if($withdrawals->status == 0){
                    //     return '<a href="/admin/approve-withdrawal/'.$withdrawals->id.'" class="btn btn-danger btn-sm">Approve</a>';
                    // }
                })
                ->addColumn('name', function($withdrawals){
                    return $withdrawals->first_name ." ". $withdrawals->last_name ;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


}
