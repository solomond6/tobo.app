<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\VerifyUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        //exit;
        //var_dump(\Auth::user()->roles[0]['name']);exit;

        if (\Auth::user()->verified != 1) {
            auth()->logout();
            \Request::session()->flash('error', 'You need to confirm your account. We have sent you an activation code, please check your email.');
            return "/";
        }else if(\Auth::user()->status != 1){
            auth()->logout();
            \Request::session()->flash('warning', 'This account has been deactivated or account not yet approved.');
            return "/";
        }else if (\Auth::user()->roles[0]['name'] == 'admin') {
            return "/admin/dashboard/";
        }elseif(\Auth::user()->roles[0]['name'] == 'sales'){
            return "/sales/dashboard/";
        }elseif(\Auth::user()->roles[0]['name'] == 'agent'){
            return "/agent/dashboard/";
        }elseif(\Auth::user()->roles[0]['name'] == 'moderator'){
            return "/moderator/dashboard";
        }else{
            \Request::session()->flash('warning', 'This sdaccount has been deactivated or account not yet approved.');
            return "/";
        }

        //return "/home";
        // or return route('routename');
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/')->with('warning', "Sorry your email cannot be identified.");
        }

        return redirect('/')->with('status', $status);
    }

    public function showLoginForm(Request $request){
        return view('auth/login');
    }

    public function showForgetPasswordForm(Request $request){
        return view('auth/forgot_password');
    }


    public function forgotPassword (Request $request){
        $request->validate(['email' => 'required|email']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT ? back()->with(['status' => __($status)]) : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, $token){
        $email = $request->query('email');
        return view('auth/reset_password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassord (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('/')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
