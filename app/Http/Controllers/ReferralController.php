<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\AgentInvitationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use Auth;


class ReferralController extends Controller
{
    public function __construct()
    {
        if(Auth::check()){
            
        }else{
            return redirect('/');
        }
        parent::__construct();
    }

    public function adminInvite(Request $request){
        $request->user()->authorizeRoles('admin');
        $downlines = User::where('id','!=', 2)->with('upline')->with('downline')->orderby('id')->get(['id','username','upline_0_id','upline_1_id','upline_2_id'])->toArray();
        return view('admin.invite_agent')->with(compact('downlines'));
    }



    public function sendInvite(Request $request){
        $request->user()->authorizeRoles('admin');

        if($request->isMethod('post')){

            $data = $request->all();
            
            $validator = Validator::make($data, [
                            'agent_email' => ['required', 'email']
                        ]);
            
            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors());
            }

            $userid = Auth::user()->id;
            $user = User::findOrFail($userid);

            $isSent = Mail::to($data['agent_email'])->send(new AgentInvitationMail($user));

            if($isSent == null){
                return redirect()->back()->with('success', 'Invite Sent Successfully');
            }else{
                return redirect()->back()->with('error', 'Error occcured when sending invite, kindly try again.');
            }
        }
    }


    public function agentInvite(Request $request){
        $request->user()->authorizeRoles('agent');
        $downlines = User::where('id', Auth::user()->id)->with('downline')->get(['id','username','upline_0_id','upline_1_id','upline_2_id'])->toArray();

        return view('agent.invite_agent')->with(compact('downlines'));
    }

    public function sendAgentInvite(Request $request){
        $request->user()->authorizeRoles('agent');

        if($request->isMethod('post')){

            $data = $request->all();
            
            $validator = Validator::make($data, [
                            'agent_email' => ['required', 'email']
                        ]);
            
            if($validator->fails()){
                return redirect()->back()->with('error', $validator->errors());
            }

            $userid = Auth::user()->id;
            $user = User::findOrFail($userid);

            $isSent = Mail::to($data['agent_email'])->send(new AgentInvitationMail($user));

            if($isSent == null){
                return redirect()->back()->with('success', 'Invite Sent Successfully');
            }else{
                return redirect()->back()->with('error', 'Error occcured when sending invite, kindly try again.');
            }
        }
    }
}
