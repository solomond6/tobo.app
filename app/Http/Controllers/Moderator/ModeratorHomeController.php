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
use App\Models\VerifyUser;
use App\Models\Thread;
use App\Models\Channel;
use App\Filters\ThreadFilters;
use Illuminate\Support\Str;

use Auth;

class ModeratorHomeController extends Controller
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
    	$request->user()->authorizeRoles('moderator');
        $user_balance = UserBalance::where('user_id', Auth::user()->id)->first();

        $threads = $this->getThreads($channel, $filters);

        if(request()->wantsJson()){
            return $threads;
        }

        return view('moderator.dashboard')->with(compact('user_balance', 'threads'));
    }


    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::with('ThreadImages')->latest()->filter($filters);
        if($channel->exists){
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }

    public function register(Request $request){
        $request->user()->authorizeRoles('moderator');
        $userList = User::pluck('username','affiliate_id');
        return view('moderator.register')->with(compact('userList'));
    }


    public function addagent(Request $request){
        // $request->user()->authorizeRoles('moderator');

        $data = $request->all();

        $referrer = User::where('affiliate_id', $data['ref'])->first();

        $upline_0_id = null;
        $upline_0_commission = null;
        $upline_1_id = null;
        $upline_1_commission = null;
        $upline_2_id = null;
        $upline_2_commission = null;

        if($data['ref'] == "moderator"){
            $upline_0_id = 1;
            $upline_0_commision = 30;
            $upline_1_id = null;
            $upline_1_commission = null;
            $upline_2_id = null;
            $upline_2_commission = null;
        }else{
            if(!is_null($referrer->upline_0_id)){
                $upline_0_id = $referrer->id;
                $upline_0_commission = 25;
                $upline_1_id = $referrer->upline_0_id;
                $upline_1_commission = 5;
                $upline_2_id = null;
                $upline_2_commission = null;
            }

            if(!is_null($referrer->upline_0_id) && !is_null($referrer->upline_1_id)){
                $upline_0_id = $referrer->id;
                $upline_0_commission = 25;
                $upline_1_id = $referrer->upline_0_id;
                $upline_1_commission = 5;
                $upline_2_id = $referrer->upline_1_id;
                $upline_2_commission = 0;
            }
        }

        // exit;

        $user = User::create([
                'username' => $data['first_name'].'.'.$data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status'=> 1,
                'commission'=> 70,
                'upline_1_id'=>$upline_1_id,
                'upline_2_id'=>$upline_2_id,
                'upline_0_id' => $upline_0_id,
                'upline_0_commission'=> $upline_0_commission,
                'upline_1_commission'=> $upline_1_commission,
                'upline_2_commission'=> $upline_2_commission,
                'affiliate_id' => Str::random(10),
                
            ]);

        $userDetails = new UserDetails([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_no' => $data['phone_number'],
            'address' => $data['address'],
            'address1' => "",
            // 'city_id' => $data['city_id'],
            // 'state_id' => $data['state_id'],
            // 'country_id' => $data['country_id']
        ]);               

        $user->userdetails()->save($userDetails);

        //var_dump($userDetails);exit;
        $user->roles()->attach(Role::where('name', 'agent')->first());

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);

        $userBalance = UserBalance::create([
            'user_id' => $user->id,
            'amount' => 0,
            'credit' => 5000
        ]);

        if($userBalance){
            return redirect()->back()->with('success', 'Agent added Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured adding agent, kindly try again.');
        }
    }

}
