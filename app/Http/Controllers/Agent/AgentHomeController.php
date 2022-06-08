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
use App\Models\Transaction;
use App\Models\Thread;
use App\Models\Channel;
use App\Filters\ThreadFilters;
use App\Models\Withdrawal;
use App\Notifications\UserNotification;
use Notification;
use Illuminate\Support\Str;
use Auth;

class AgentHomeController extends Controller
{
    public function __construct()
    {
        if(Auth::check()){
            
        }else{
            return redirect('/');
        }
        parent::__construct();
    }

    public function index(Request $request, Channel $channel, ThreadFilters $filters){
    	$request->user()->authorizeRoles('agent');
        
        $threads = $this->getThreads($channel, $filters);

        if(request()->wantsJson()){
            return $threads;
        }

        $user_balance = UserBalance::where('user_id', Auth::user()->id)->first();
        $pending_withdrawal = Withdrawal::where('user_id', Auth::user()->id)->where('status', 0)->sum('amount');
        $recuit_sales = Transaction::where('user_id', Auth::user()->id)->where('type', '+')->where('comment', '!=', 'Sales Bonus')->sum('amount');
        $own_sales = Transaction::where('user_id', Auth::user()->id)->where('comment', 'Sales Bonus')->sum('amount');
        $sales_comm = Auth::user()->commission_amt;

        $referrer = User::where('id','=', Auth::user()->id)->get();

        $commisionDeistribution = DB::table('users')
                                    ->join('role_user', 'users.id', 'role_user.user_id')
                                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                                    ->leftjoin('user_details as ul0', 'users.upline_0_id', 'ul0.user_id')
                                    ->leftjoin('user_details as ul1', 'users.upline_1_id', 'ul1.user_id')
                                    ->leftjoin('user_details as ul2', 'users.upline_2_id', 'ul2.user_id')
                                    ->where('users.id', Auth::user()->id)
                                    ->select( DB::raw("CONCAT(u1.first_name,' ',u1.last_name) as full_name"), 'users.commission', DB::raw("CONCAT(ul0.first_name,' ',ul0.last_name) as upline_0_full_name"), 'users.upline_0_commission', DB::raw("CONCAT(ul1.first_name,' ',ul1.last_name) as upline_1_full_name"), 'users.upline_1_commission', DB::raw("CONCAT(ul2.first_name,' ',ul2.last_name) as upline_2_full_name"), 'users.upline_2_commission')
                                    ->first();

        // dd($commisionDeistribution);exit;
        
        $sub_referrer = User::where('upline_0_id', '!=', 0)->get();
        $upine1 = User::where('upline_0_id', 0)->get();
        $line2 = User::where('upline_0_id', 0)->get();

        return view('agent.dashboard')->with(compact('referrer', 'sub_referrer', 'user_balance', 'sales_comm', 'commisionDeistribution','own_sales','recuit_sales', 'threads', 'pending_withdrawal'));
    }

    public function addWithdrawal(Request $request){
        $request->user()->authorizeRoles('agent');

        if($request->isMethod('post')){
            $data = $request->all();
            $withdrawal = new Withdrawal;
            $withdrawal->user_id = Auth::user()->id;
            $withdrawal->amount = $data['amount'];
            $withdrawal->comment = $data['comment'];
            $withdrawal->status = 0;
            
            if($withdrawal->save()){

                $userbalance = UserBalance::where('user_id', Auth::user()->id)->first();
                $userbalance->amount -= $data['amount'];
                $userbalance->save();

                $admin = User::find(1);

                $details = [
                    'greeting' => 'Hi,'.$admin->first_name,
                    'body' => 'New withdrawal with id '.$withdrawal->id,
                    'thanks' => '',
                    'actionText' => 'View',
                    'actionURL' => url('/admin/withdrawals'),
                    'data_id' => $withdrawal->id
                ];

                Notification::send($admin, new UserNotification($details));

                return redirect()->back()->with('success', 'Withdrawal Created Successfully');
            }else{
                return redirect()->back()->with('error', 'Error cccured when creating withdrawal, kindly try again.');
            }
        }
    }
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->with('ThreadImages')->filter($filters);
        if($channel->exists){
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }
}
