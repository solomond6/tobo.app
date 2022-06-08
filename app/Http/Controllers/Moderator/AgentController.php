<?php

namespace App\Http\Controllers\moderator;

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
use Illuminate\Support\Str;
use Image;

use Auth;

class AgentController extends Controller
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
        return view('moderator.agents');
    }

    public function deactivateAgent(Request $request, $id=null){
        // $request->user()->authorizeRoles('moderator');
        // var_dump($id);exit;
        $updated = User::where(['id'=>$id])->update(['status'=>2]);

        if($updated){
            return redirect()->back()->with('success', 'User Deactivated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating merchant, kindly try again.');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        $updated = User::find(Auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        
        if($updated){
            return redirect()->back()->with('success', 'Password Changed Successfully.');
        }else{
            return redirect()->back()->with('error', 'Error Changing Password.');
        }
        
    }

    public function resetPassword(Request $request, $id=null)
    {
   
        $updated = User::where(['id'=>$id])->update(['password'=> Hash::make('password')]);
        
        if($updated){
            return redirect()->back()->with('success', 'Password Changed Successfully.');
        }else{
            return redirect()->back()->with('error', 'Error Changing Password.');
        }
        
    }

    public function activateAgent(Request $request, $id=null){
        // $request->user()->authorizeRoles('moderator');
        $updated = User::where(['id'=>$id])->update(['status'=>1]);
        if($updated){
            return redirect()->back()->with('success', 'User Activated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating user, kindly try again.');
        }
    }

    public function deleteAgent(Request $request, $id=null){
        
        $getUpline0 = User::where(['upline_0_id'=>$id])->first();

        if(!empty($getUpline0)){
            $update0upline = User::where(['upline_0_id'=>$id])->update(['upline_0_id'=>$getUpline0->upline_1_id, 'upline_1_id'=> 0]);
        }

        $getUpline1 = User::where(['upline_1_id'=>$id])->first();

        if(!empty($getUpline1)){
            //$update0upline = User::where(['upline_1_id'=>$id])->update(['upline_0_id'=>$getUpline1->upline_1_id]);
            $update1upline = User::where(['upline_1_id'=>$id])->update(['upline_1_id'=>$getUpline1->upline_2_id, 'upline_2_id'=>0]);
        }
    
        $getUpline2 = User::where(['upline_2_id'=>$id])->first();

        if(!empty($getUpline2)){
            $update2upline = User::where(['upline_2_id'=>$id])->update(['upline_2_id'=>0]);
        }

        $deleted = User::where(['id'=>$id])->delete();

        if($deleted){
            return redirect()->back()->with('success', 'User Deleted Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when deleting users, kindly try again.');
        }
    }


    public function UpdateCommissionAmt(Request $request){
        // $request->user()->authorizeRoles('moderator');
        $updated = User::where(['id'=>$id])->update(['status'=>3]);
        if($updated){
            return redirect()->back()->with('success', 'Agent Commission Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating agent commission, kindly try again.');
        }
    }

    public function uploadAgentPic(Request $request){
        $request->user()->authorizeRoles('moderator');

        $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('image')){                

                $image_tmp = $request->file('image');

                $input['imagename'] = time().'.'.$image_tmp->getClientOriginalExtension();
                 
                $img = Image::make($image_tmp->getRealPath());

                $thumbnailpath = public_path('agent_images/'.$input['imagename']);
                
                $img = Image::make($image_tmp->getRealPath())->resize(200, 150, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath);

                $updated = UserDetails::where(['user_id'=>$data['agent_id']])->update(['image_path'=>$input['imagename']]);
                
                if($updated){
                    return redirect()->back()->with('success', 'Agent Pic Updated Successfully');
                }else{
                    return redirect()->back()->with('error', 'Error occcured when updating agent pic, kindly try again.');
                }
            }
            
            
        }
        $categoyList = Categories::pluck('name','id');
        return view('moderator.categories.add_category')->with(compact('categoyList'));
    }

    public function setCommission(Request $request){
        
        $request->user()->authorizeRoles('moderator');
        $data = $request->all();

        $updated = User::where(['id'=>$data['id']])->update(['commission_amt'=>$data['commission_amt']]);

        if($updated){
            return redirect()->back()->with('success', 'Agent Commission Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating agent commission, kindly try again.');
        }
    }


    public function viewAgent(Request $request, $id=null){
        $request->user()->authorizeRoles('moderator');
        // $productDetails = Products::where(['id'=> $id])->first();

        $agentDetails = DB::table('users')
                            ->join('user_details', 'users.id', 'user_details.user_id')
                            ->join('user_balance', 'users.id', 'user_balance.user_id')
                            ->where('users.id', $id)
                            ->select('users.id as id', 'users.username as username','users.email as email', 'user_details.image_path as agent_pic',
                                'user_balance.amount as user_balance',
                                'user_details.first_name as first_name',
                                'user_details.first_name as first_name',
                                'user_details.last_name as last_name',
                                'user_details.phone_no as phone_no',
                             'users.status as status' )
                            ->first();

        //var_dump($companyDetails);exit;
        return view('moderator.agent_details')->with(compact('agentDetails'));
    }


    public function transactionsData(Request $request){

        $data = $request->all();
        
        $agent_id = $data['agent_id'];

        $users = DB::table('users')
                    ->join('transactions', 'users.id', 'transactions.user_id')
                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                    ->leftjoin('user_balance', 'users.id', 'user_balance.user_id')
                    ->where('users.id', $agent_id)
                    ->select('transactions.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no','user_balance.amount as balance', 
                        DB::raw('ROUND((transactions.amount * 20)/80, 2) AS service_charge'),
                        DB::raw('(ROUND((transactions.amount * 20)/80, 2) + transactions.amount ) AS commission')
                        // 'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name'
                    )
                    ->get();

        return Datatables::of($users)
                ->addColumn('delete-action', function($users){
                    return '<a href="/moderator/delete-agent/'.$users->id.'" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                ->rawColumns(['action', 'delete-action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


    public function salesData(Request $request){

        $data = $request->all();
        
        $agent_id = $data['agent_id'];

        $users = DB::table('users')
                    ->join('sales', 'users.id', 'sales.agent_id')
                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                    // ->leftjoin('user_details as u2', 'users.upline_0_id', 'u2.user_id')
                    ->leftjoin('user_balance', 'users.id', 'user_balance.user_id')
                    ->where('users.id', $agent_id)
                    ->select('sales.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no','user_balance.amount as balance', 
                        // 'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name'
                    )
                    ->get();

        return Datatables::of($users)
                ->addColumn('delete-action', function($users){
                    return '<a href="/moderator/delete-agent/'.$users->id.'" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                ->rawColumns(['action', 'delete-action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    

    // public function setCommission(Request $request, $id=null){
    //     $request->user()->authorizeRoles('moderator');
        
    //     $user = DB::table('users')
    //                 ->join('user_details as u1', 'users.id', 'u1.user_id')
    //                 ->leftjoin('user_details as u2', 'users.referrer_id', 'u2.user_id')
    //                 ->leftjoin('user_details as u3', 'users.upline_1_id', 'u3.user_id')
    //                 ->leftjoin('user_details as u4', 'users.upline_2_id', 'u4.user_id')
    //                 ->where('users.id', $id)
    //                 ->select('users.*', 'u1.first_name as user_firstname', 'u1.last_name as user_lastname', 
    //                     'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name',
    //                     'u3.first_name as upline_1_first_name', 'u3.last_name as upline_1_last_name',
    //                     'u4.first_name as upline_2_first_name', 'u4.last_name as upline_2_last_name')
    //                 ->first();

    //     return view('moderator.set_commission')->with(compact('user'));
    // }

    public function agentData(){
        $users = DB::table('users')
                    ->join('role_user', 'users.id', 'role_user.user_id')
                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                    ->leftjoin('user_details as u2', 'users.upline_0_id', 'u2.user_id')
                    ->leftjoin('user_balance', 'users.id', 'user_balance.user_id')
                    ->where('role_user.role_id', 3)
                    ->select('users.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no','user_balance.amount as balance', 'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name')
                    ->get();

        return Datatables::of($users)
                ->addColumn('action', function($users){
                    if($users->status == 1){
                        return '<a href="/moderator/deactive-agent/'.$users->id.'" class="btn btn-danger btn-sm">De-Activate Agent</a>';
                    }else if ($users->status == 2 || $users->status == 0){
                        return '<a href="/moderator/active-agent/'.$users->id.'" class="btn btn-success btn-sm">Activate Agent</a>';
                    }
                })
                ->addColumn('delete-action', function($users){
                    return '<a href="/moderator/delete-agent/'.$users->id.'" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->addColumn('view-details', function($users){
                    // return '<button type="button" class="btn btn-dark btn-sm" id="updateCommission" data-toggle="modal" data-target="#exampleModal" data-agentid="'.$users->id.'" data-agentname="'.$users->first_name ." ". $users->last_name.'">View Details</button>';
                    return '<a href="/moderator/view-agent/'.$users->id.'" class="btn btn-info btn-sm">View Detials</a>';
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                ->addColumn('referralname', function($users){
                    return $users->referral_first_name ." ". $users->referral_last_name;
                })
                ->rawColumns(['action', 'delete-action','view-details'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


}
