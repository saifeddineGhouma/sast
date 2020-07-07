<?php

namespace App\Http\Controllers\Teacher\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Auth;
use App\Student;
use App\User;
use App\Teacher;
use App\TeacherUser;
use App\TeacherSocial;
use App\TeacherTranslation;
use App\Log;
use DB;
use Crypt;
class LoginController extends Controller
{
	use AuthenticatesUsers;
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
	protected $guard = 'teachers';
    /*public function __construct()
    {
      $this->middleware('guest:teachers', ['except' => ['logout']]);
    }*/

    public function getLogin()
    {
		//if(Auth::check())

			//return redirect()->route('teacherIndex');
			
			return view("teachers.auth.login");
    }

    public function postLogin(Request $request)
    {
		  $this->validate($request, [
	        'login'   => 'required',
	        'password' => 'required'
	      ]);
		  
		  if ($this->hasTooManyLoginAttempts($request)) {
	            $this->fireLockoutEvent($request);
	
	            return $this->sendLockoutResponse($request);
	        }
		
		$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
	    $request->merge([$field => $request->input('login')]);
        $loggable = \App\TeacherUser::where($field,$request->{$field})->where("active",1)
                ->has("teacher")->first();

        if(!empty($loggable)){
            if (Auth::guard("teachers")->attempt($request->only($field, 'password'), $request->has('remember'))){

                return $this->sendLoginResponse($request);
            }
        }
			
       // if unsuccessful, then redirect back to the login with the form data
      $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function idLogin(Request $request){
        $user = Auth::user();
		
		$credentials = [
		   'username' => $user->username,
		   'password' => $decrypt,
		];

		if (Auth::validate($credentials)) {
			echo "Afef";
			return Auth::user()->id;
		}
      
    }
    
    public function username()
    {
        return 'login';
    }

    public function logout()
    {
        Auth::guard('teachers')->logout();
        return redirect('/teachers/login');
    }
}
