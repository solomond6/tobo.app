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
use App\Models\UserBalance;
use App\Models\Sales;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Auth;
use App\Notifications\UserNotification;
use Notification;

class AdminSalesController extends Controller
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
        return view('admin.sales');
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

    public function setCommission(Request $request){
        
        $request->user()->authorizeRoles('admin');
        $data = $request->all();

        $updated = Sales::where(['id'=>$data['id']])->update(['commission'=>$data['commission_amt']]);

        if($updated){
            return redirect()->back()->with('success', 'Agent Commission Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating agent commission, kindly try again.');
        }
    }


     public function updateSales(Request $request){
        
        $request->user()->authorizeRoles('admin');
        $data = $request->all();

        $sales = Sales::find($data['id']);

        $updated = Sales::where(['id'=>$data['id']])->update(['status'=>$data['status'], 'comment'=>$data['comment']]);

        if($updated){

            $user = User::find($sales->agent_id);

            if($data['status']== 5){
                $status = "Ready";
            }elseif($data['status']== 4){
                $status = "Registration";
            }elseif($data['status']== 3){
                $status = "Payment";
            }elseif($data['status']== 2){
                $status = "Lawyer";
            }else{
                $status = "Started";
            }

            $details = [
                'greeting' => 'Hi,'.$user->first_name,
                'body' => 'Deal with id '.$sales->id.' was updated to '.$status,
                'thanks' => '',
                'actionText' => 'View',
                'actionURL' => url('/agent/sales'),
                'data_id' => $sales->id
            ];
      
            Notification::send($user, new UserNotification($details));

            if($data['status'] == 5){
                $distribute_commission = User::where('id', $sales->agent_id)->first();

                $sales_comm = $sales->commission;

                $credit_balnace = UserBalance::where('user_id', $sales->agent_id)->first();

                //dd($credit_balnace);
                $creditBalnace = $credit_balnace->credit;

                //var_dump($data['agent_id']);exit;
                // var_dump($creditBalnace);exit;

                $commission = [];
                $creditCommission = [];

                if($distribute_commission->upline_2_id != 0 || $distribute_commission->upline_2_id != null){

                    if($creditBalnace == 0){
                        // echo "block2";
                        $agentComm = ($sales_comm * $distribute_commission->commission/100) *0.8;
                
                        $newdata =  array (
                          'id' => $data['agent_id'],
                          'amount' => $agentComm,
                        );
                        array_push($commission , $newdata);


                        $upline0Comm = ($sales_comm * $distribute_commission->upline_0_commission/100) *0.8;
                        
                        $newdata =  array (
                          'id' => $distribute_commission->upline_0_id,
                          'amount' => $upline0Comm
                        );
                        array_push($commission , $newdata);

                        $upline1Comm = ($sales_comm * $distribute_commission->upline_1_commission/100) *0.8;
                        

                        $newdata =  array (
                          'id' => $distribute_commission->upline_1_id,
                          'amount' => $upline1Comm
                        );
                        array_push($commission , $newdata);

                        $upline2Comm = (($sales_comm * $distribute_commission->commission/100) *0.2) + (($sales_comm * $distribute_commission->upline_0_commission/100) * 0.2) + (($sales_comm * $distribute_commission->upline_1_commission/100) *0.2);
                        
                        $newdata =  array (
                          'id' => 1,
                          'amount' => $upline2Comm
                        );
                        array_push($commission , $newdata);
                    }else{

                        $upline0Comm = ($sales_comm * $distribute_commission->upline_0_commission/100) *0.8;
                        
                        $upline0CommCredit = $upline0Comm/2;

                        $newdata =  array (
                          'id' => $distribute_commission->upline_0_id,
                          'amount' => $upline0Comm
                        );
                        array_push($commission , $newdata);

                        $newComDta =  array (
                          'id' => $distribute_commission->upline_0_id,
                          'amount' => $upline0CommCredit
                        );
                        array_push($creditCommission , $newComDta);


                        $upline1Comm = ($sales_comm * $distribute_commission->upline_1_commission/100) *0.8;
                        
                        $upline1CommCredit = $upline1Comm/2;

                        $newdata =  array (
                          'id' => $distribute_commission->upline_1_id,
                          'amount' => $upline1Comm
                        );
                        array_push($commission , $newdata);

                        $newComDta =  array (
                          'id' => $distribute_commission->upline_1_id,
                          'amount' => $upline1CommCredit
                        );
                        array_push($creditCommission , $newComDta);

                        $upline2Comm = (($sales_comm * $distribute_commission->commission/100) *0.2) + (($sales_comm * $distribute_commission->upline_0_commission/100) * 0.2) + (($sales_comm * $distribute_commission->upline_1_commission/100) *0.2);
                        
                        // $upline2CommCredit = $upline2Comm/2;

                        $newdata =  array (
                          'id' => 1,
                          'amount' => $upline2Comm
                        );
                        array_push($commission , $newdata);

                        $agentComm = ($sales_comm * $distribute_commission->commission/100) *0.8;
                
                        $newdata =  array (
                          'id' => $sales->agent_id,
                          'amount' => $agentComm,
                        );
                        array_push($commission , $newdata);
                    }
                    
                }
                elseif($distribute_commission->upline_1_id != 0 || $distribute_commission->upline_1_id != null && ($distribute_commission->upline_2_id == 0 || $distribute_commission->upline_2_id == null)){

                    if($creditBalnace == 0){
                        $agentComm = ($sales_comm * $distribute_commission->commission/100)*0.8;

                        $newdata =  array (
                          'id' => $sales->agent_id,
                          'amount' => $agentComm
                        );
                        array_push($commission , $newdata);

                        $upline0Comm = ($sales_comm * $distribute_commission->upline_0_commission/100)*0.8;

                        $newdata =  array (
                          'id' => $distribute_commission->upline_0_id,
                          'amount' => $upline0Comm
                        );

                        array_push($commission, $newdata);

                        $upline1Comm = (($sales_comm * $distribute_commission->commission/100) *0.2) + (($sales_comm * $distribute_commission->upline_0_commission/100) * 0.2) + (($sales_comm * $distribute_commission->upline_1_commission/100));

                        $newdata =  array (
                          'id' => $distribute_commission->upline_1_id,
                          'amount' => $upline1Comm
                        );
                        array_push($commission , $newdata);

                    }else{

                        $agentComm = ($sales_comm * $distribute_commission->commission/100)*0.8;

                        $newdata =  array (
                          'id' => $sales->agent_id,
                          'amount' => $agentComm
                        );
                        array_push($commission , $newdata);

                        $upline0Comm = ($sales_comm * $distribute_commission->upline_0_commission/100)*0.8;

                        $upline0CommCredit = $upline0Comm/2;

                        $newComDta =  array (
                          'id' => $distribute_commission->upline_0_id,
                          'amount' => $upline0CommCredit
                        );
                        array_push($creditCommission , $newComDta);

                        $newdata =  array (
                          'id' => $distribute_commission->upline_0_id,
                          'amount' => $upline0Comm
                        );

                        array_push($commission, $newdata);

                        $upline1Comm = (($sales_comm * $distribute_commission->commission/100) *0.2) + (($sales_comm * $distribute_commission->upline_0_commission/100) * 0.2) + (($sales_comm * $distribute_commission->upline_1_commission/100));

                        $newdata =  array (
                          'id' => $distribute_commission->upline_1_id,
                          'amount' => $upline1Comm
                        );
                        array_push($commission , $newdata);

                        $upline1CommCredit = $upline1Comm/2;

                        $newComDta =  array (
                          'id' => $distribute_commission->upline_1_id,
                          'amount' => $upline1CommCredit
                        );
                        array_push($creditCommission , $newComDta);

                    }
                    // echo "block1";
                }
                elseif($distribute_commission->upline_2_id == 0 || $distribute_commission->upline_2_id == null && ($distribute_commission->upline_1_id == 0 || $distribute_commission->upline_1_id == null)){
                    $agentComm = ($sales_comm * $distribute_commission->commission/100)*0.8;

                    $newdata =  array (
                      'id' => $sales->agent_id,
                      'amount' => $agentComm
                    );

                    array_push($commission, $newdata);

                    $upline0Comm = ($sales_comm * $distribute_commission->upline_0_commission/100) + (($sales_comm * $distribute_commission->commission/100) *0.2);
                    
                    $newdata =  array (
                      'id' => $distribute_commission->upline_0_id,
                      'amount' => $upline0Comm
                    );

                    array_push($commission, $newdata);

                    // echo "block0";
                }
                // else{
                //     $agentComm = ($sales_comm * $commisionDeistribution->commission/100) *0.8;
                //     $upline0Comm = ($sales_comm * $distribute_commission->upline_0_commission/100) *0.8
                // }

                // echo "<pre>"; print_r($commission); echo "</pre>";
                // echo "<pre>"; print_r($creditCommission); echo "</pre>";

                // exit;                


                sort($commission);

                foreach($commission as $key => $agent){
                    // var_dump($agent);exit;
                    // if (in_array($agent['id'], $creditCommission)) {
                    //     echo "Got Irix";
                    //     exit;
                    // }

                    $user = User::where('id', $agent['id'])->first();

                    //dd($user->status);
                    if(!empty($user)){
                        if($user->status == 1){
                            $agent_balance = UserBalance::where('user_id', $agent['id'])->first();
                            $agent_balance->amount += $agent['amount'];
                            $agent_balance->save();

                            $trans = new Transaction;

                            $trans->user_id = $agent['id'];
                            $trans->amount = $agent['amount'];
                            $trans->type = '+';

                            if($agent['id'] == $sales->agent_id){
                                $trans->comment = 'Sales Bonus';

                                $user = User::find($agent['id']);

                                $details = [
                                    'greeting' => 'Hi,'.$user->first_name,
                                    'body' => ' Sales Bonus from Deal',
                                    'thanks' => '',
                                    'actionText' => 'View',
                                    'actionURL' => url('/agent/transactions'),
                                    'data_id' => $sales->id
                                ];
                          
                                Notification::send($user, new UserNotification($details));
                            }else{
                                $trans->comment = 'Upline Bonus for sales from '.$distribute_commission->username;

                                if($agent['id'] == 1){
                                    $user = User::find($agent['id']);

                                    $details = [
                                        'greeting' => 'Hi,'.$user->first_name,
                                        'body' => 'Upline Bonus for sales from '.$distribute_commission->username,
                                        'thanks' => '',
                                        'actionText' => 'View',
                                        'actionURL' => url('/admin/transactions'),
                                        'data_id' => $sales->id
                                    ];
                                }else{
                                    $user = User::find($agent['id']);

                                    $details = [
                                        'greeting' => 'Hi,'.$user->first_name,
                                        'body' => 'Upline Bonus for sales from '.$distribute_commission->username,
                                        'thanks' => '',
                                        'actionText' => 'View',
                                        'actionURL' => url('/agent/transactions'),
                                        'data_id' => $sales->id
                                    ];
                                }
                                
                          
                                Notification::send($user, new UserNotification($details));
                            }

                            $trans->save();
                        }else{
                            $agent_balance = UserBalance::where('user_id', 1)->first();
                            $agent_balance->amount += $agent['amount'];
                            $agent_balance->save();

                            $trans2 = new Transaction;

                            $trans2->user_id = 1;
                            $trans2->amount = $agent['amount'];
                            $trans2->type = '+';

                            $trans2->comment = 'Admin Get Upline Bonus for sales from '.$distribute_commission->username.' due to '.$user->username. ' deactivation';

                            $trans2->save();

                            // dd($trans);
                        }
                    }
                    
                }


                sort($creditCommission);

                foreach($creditCommission as $key => $credit){
                    // var_dump($agent);exit;

                    $user = User::where('id', $credit['id'])->where('status', 1)->first();
                    
                    if(!empty($user)){

                        $upline_agent = UserBalance::where('user_id', $credit['id'])->first();

                        if($upline_agent->credit != 0 && $upline_agent->credit >= $credit['amount']){
                            // $agent_balance->credit -= $credit['amount'];
                            // $agent_balance->save();


                            $level_balance = UserBalance::where('user_id', $credit['id'])->first();
                            $level_balance->amount -= $credit['amount'];
                            $level_balance->credit -= $credit['amount'];
                            $level_balance->save();

                            $trans = new Transaction;

                            $trans->user_id = $credit['id'];
                            $trans->amount = $credit['amount'];
                            $trans->type = '-';
                            $trans->comment = 'Paid part of credit from '.$distribute_commission->username. ' commission';
                            $trans->save();

                            $user = User::find($credit['id']);

                            $details = [
                                'greeting' => 'Hi,'.$user->first_name,
                                'body' => 'Paid part of credit from '.$distribute_commission->username. ' commission',
                                'thanks' => '',
                                'actionText' => 'View',
                                'actionURL' => url('/agent/transactions'),
                                'data_id' => $sales->id
                            ];
                      
                            Notification::send($user, new UserNotification($details));

                            $admin_balance = UserBalance::where('user_id', 1)->first();
                            $admin_balance->amount += $credit['amount'];
                            $admin_balance->save();

                            $dist_comm_user = User::where('id', $credit['id'])->first();

                            $trans1 = new Transaction;
                            $trans1->user_id = 1;
                            $trans1->amount = $credit['amount'];
                            $trans1->type = '+';
                            $trans1->comment = 'Credit Payment from '.$dist_comm_user->username;
                            $trans1->save();
                        }
                    }
                    
                }


                // foreach($creditCommission as $key => $credit){
                //     // var_dump($agent);exit;
                //     $upline_balance = UserBalance::where('user_id', $data['agent_id'])->first();

                //     if($agent_balance->credit != 0 && $agent_balance->credit >= $credit['amount']){
                //         // $agent_balance->credit -= $credit['amount'];
                //         // $agent_balance->save();


                //         $level_balance = UserBalance::where('user_id', $credit['id'])->first();
                //         $level_balance->amount -= $credit['amount'];
                //         $level_balance->save();

                //         $trans = new Transaction;

                //         $trans->user_id = $credit['id'];
                //         $trans->amount = $credit['amount'];
                //         $trans->type = '-';
                //         $trans->comment = 'Paid part of credit from '.$distribute_commission->username. ' commission';
                //         $trans->save();

                //         $admin_balance = UserBalance::where('user_id', 1)->first();
                //         $admin_balance->amount += $credit['amount'];
                //         $admin_balance->save();

                //         $dist_comm_user = User::where('id', $credit['id'])->first();

                //         $trans1 = new Transaction;
                //         $trans1->user_id = 1;
                //         $trans1->amount = $credit['amount'];
                //         $trans1->type = '+';
                //         $trans1->comment = 'Credit Payment from '.$dist_comm_user->username;
                //         $trans1->save();
                //     }
                    
                // }
            }
            return redirect()->back()->with('success', 'Deal Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating deal, kindly try again.');
        }
    }

    public function addSales(Request $request){
        $request->user()->authorizeRoles('admin');

        if($request->isMethod('post')){
            $data = $request->all();
            $sale = new Sales;
            $sale->property_id = $data['property_id'];
            $sale->user_id = Auth::user()->id;
            $sale->price = $data['price'];
            $sale->lawyer_name = $data['lawyer_name'];
            $sale->agent_id = $data['agent_id'];
            $sale->client_name = $data['client_name'];
            $sale->date_of_sale = $data['date_of_sale'];
            $sale->payment_terms = $data['payment_terms'];
            $sale->comment = $data['comment'];
            $sale->date_of_completion = $data['date_of_completion'];
            $sale->commission = $data['commission'];

            if($sale->save()){

                $user = User::find($data['agent_id']);

                $details = [
                    'greeting' => 'Hi,'.$user->first_name,
                    'body' => 'New Deal with id '.$sale->id.' was assigned to you',
                    'thanks' => '',
                    'actionText' => 'View',
                    'actionURL' => url('/agent/sales'),
                    'data_id' => $sale->id
                ];
          
                Notification::send($user, new UserNotification($details));

                return redirect('/admin/sales')->with('success', 'Sales Created Successfully');
            }else{
                return redirect('/admin/sales/new')->with('error', 'Error cccured when creating sales, kindly try again.');
            }
        }

        $agents = User::pluck('username','id');

        return view('admin.add_sales')->with(compact('agents'));
    }

    public function salesData(){
        $users = DB::table('users')
                    ->join('sales', 'users.id', 'sales.agent_id')
                    ->join('user_details as u1', 'users.id', 'u1.user_id')
                    ->leftjoin('user_balance', 'users.id', 'user_balance.user_id')
                    ->select('sales.*', 'u1.first_name', 'u1.last_name', 'u1.phone_no','user_balance.amount as balance', 
                        // 'u2.first_name as referral_first_name', 'u2.last_name as referral_last_name'
                    )
                    ->get();

        return Datatables::of($users)
                ->addColumn('delete-action', function($users){
                    return '<a href="/admin/delete-agent/'.$users->id.'" class="btn btn-danger btn-sm">Delete</a>';
                })
                ->addColumn('set-commission', function($users){
                    return '<button type="button" class="btn btn-dark btn-sm" id="updateCommission" data-toggle="modal" data-target="#exampleModal" data-agentid="'.$users->id.'" data-agentname="'.$users->first_name ." ". $users->last_name.'">Set Commission</button>';
                })
                ->addColumn('update-status', function($users){
                    return '<button type="button" class="btn btn-info btn-sm" id="updateStatus" data-toggle="modal" data-target="#exampleModal" data-agentid="'.$users->id.'" data-agentname="'.$users->first_name ." ". $users->last_name.'">Update Deal Status</button>';
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                ->rawColumns(['action', 'delete-action','set-commission','update-status'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


}
