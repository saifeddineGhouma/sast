<?php


namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Notifications\UserLogin;
use App\User;
use App\Log;
use Notification;

use Socialite;
use Auth;
use DB;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        return view("front.auth.login");
    }


    public function postLogin(Request $request)
    {

        $this->validate($request, [
            'login'   => 'required',
            'password' => 'required'
        ]);
        if(in_array($request->input('login'), ["Haneen", "569110813", "haneen_ns@hotmail.com"] )){
   

        return redirect()->back()->withErrors("الرجاء الاتصال بالادمن لديك مشكلة");

        }else{

        

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $field = 'username';
        $login = $request->input('login');
        if(filter_var($login, FILTER_VALIDATE_EMAIL)){
            $field = 'email';
        }else if(is_numeric ($login)){
            $field = 'mobile';
            if (substr($login, 0, 2) == '00'){
                $login = str_replace('00','+',$login);
            }
        }

        $request->merge([$field => $login]);

        $now = date("Y-m-d");
        if (Auth::attempt($request->only($field, 'password'), $request->has('remember'))){
            $user = Auth::user();
			if($user->active==0){
				$log = new Log();
				$log->user_id = Auth::user()->id;
				$log->action = "User Logged out";
				$log->save();
				Auth::logout();
				return view("front.auth.login",array(
					"msg"=>"erreur"
				));
			}else{
				$admins = \App\Admin::get();
				$log = new Log();
				$log->user_id = $user->id;
				$log->action = "User Logged in";
				$log->save();

				Notification::send($admins, new UserLogin($user->id,$user->username));

				return $this->sendLoginResponse($request);
			}
        }
        // if unsuccessful, then redirect back to the login with the form data
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    }
    public function username()
    {
        return 'login';
    }

    public function getFacebooklogin(){
        return Socialite::driver('facebook')->redirect();
    }

    public function getCallbackfacebook(){
        $user = Socialite::driver('facebook')->user();
        $userDb = User::where("email",$user->email)->first();
        if(!empty($userDb)){
            Auth::login($userDb);
        }else{
            $userDb = new User();
            $name = $user->getName();
            $userDb->full_name_ar = $name;
            $userDb->email = $user->getEmail();
            $userDb->username = $name."_".str_random(4);
            $userDb->password = $user->token;
            $userDb->auth_key = str_random(40);
            $userDb->auth_mobile_key = str_random(6);
            $userDb->email_verified = 1;
            $userDb->save();
            Auth::login($userDb);
        }
        return redirect(App("urlLang"));
        //echo $user->email;
    }

    public function getTwitterlogin(){
        return Socialite::driver('twitter')->redirect();
    }

    public function getCallbacktwitter(){
        $user = Socialite::driver('twitter')->user();

        $userDb = User::where("email",$user->email)->first();
        if(!empty($userDb)){
            Auth::login($userDb);
        }else{
            $userDb = new User();
            $name = $user->getName();
            $userDb->full_name_ar = $name;
            $userDb->email = $user->getEmail();
            $userDb->username = $name."_".str_random(4);
            $userDb->password = $user->token;
            $userDb->auth_key = str_random(40);
            $userDb->auth_mobile_key = str_random(6);
            $userDb->email_verified = 1;
            $userDb->save();
            Auth::login($userDb);
        }
        return redirect(App("urlLang"));
        //echo $user->email;
    }

    public function getGooglelogin(){
        return Socialite::driver('google')->redirect();
    }

    public function getCallbackgoogle(){
        $user = Socialite::driver('google')->user();

        $userDb = User::where("email",$user->email)->first();
        if(!empty($userDb)){
            Auth::login($userDb);
        }else{
            $userDb = new User();
            $name = $user->getName();
            $userDb->full_name_ar = $name;
            $userDb->email = $user->getEmail();
            $userDb->username = $name."_".str_random(4);
            $userDb->password = $user->token;
            $userDb->auth_key = str_random(40);
            $userDb->auth_mobile_key = str_random(6);
            $userDb->email_verified = 1;
            $userDb->save();
            Auth::login($userDb);
        }
        return redirect(App("urlLang"));
        //echo $user->email;
    }

    public function logout()
    {
        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action = "User Logged out";
        $log->save();
        Auth::logout();
        return redirect('/');
    }

}