<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserBalance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\UserDetails;
use App\Models\VerifyUser;
use App\Mail\WelcomeMail;
use Image;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationForm(Request $request)
    {
        if ($request->has('ref')) {
            $ref = $request->query('ref');
            session(['referrer' => $request->query('ref')]);
        }

        return view('auth.register')->with(compact('ref'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
        //exit;
        try{
            
            $referrer = User::where('affiliate_id', $data['ref'])->first();

            $upline_0_id = null;
            $upline_0_commission = null;
            $upline_1_id = null;
            $upline_1_commission = null;
            $upline_2_id = null;
            $upline_2_commission = null;

            if($data['ref'] == "admin"){
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
                    'status'=> 0,
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

            Mail::to($data['email'])->send(new WelcomeMail($user));
            

            $this->guard()->logout();

            \Request::session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');

            return $user;
        }catch(\Exception $ex){
            
            \Request::session()->flash('warning', 'An error has occured.');
            return '/register';
            //return back()->withError($ex->getMessage())->withInput();
        }
        
    }


    public function redirectTo()
    {
        \Request::session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');
        return "/";
    }


}
