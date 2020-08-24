<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Auth;
use App\Student;
use App\User;
use App\Log;
use App\AdminHistory;
use DB;

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
	protected $guard = 'admins';
    public function __construct()
    {
      $this->middleware('guest:admins', ['except' => ['logout']]);
    }

    public function getLogin()
    {
       
      return view("admin.auth.login");
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
		
	    if (Auth::guard("admins")->attempt($request->only($field, 'password'), $request->has('remember'))){

			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Log In"; 
			$adminhistory->save(); 
			
			$User = User::get();
			//print_r($User);
			foreach ($User as $users) {
				if($users->active==1){
					$mois=date("m", strtotime($users->date_of_birth));
					$jour=date("d", strtotime($users->date_of_birth));
					if($mois==date("m") and $jour==date("d") and $users->env_mail==0){
						$to = $users->email;
						$mime_boundary = "----MSA Shipping----" . md5(time());
						$subject = "Swedish Academy: Happy birthday";
						$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
						$headers .= "MIME-Version: 1.0\n";
						$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
						$message1 = "--$mime_boundary\n";
						$message1 .= "Content-Type: text/html; charset=UTF-8\n";
						$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
						$message1 .= "<html>\n";
						$message1 .= "<body>";
						$message1 .= "<table width='800'>";
						$message1 .= "<tr>";
						$message1 .= "<td>";
						$message1 .= "<img src='https://swedish-academy.se/assets/admin/img/1.jpg' />";
						$message1 .= "</td>";
						$message1 .= "</tr>";
						$message1 .= '</table>';
						$message1 .= '</body>';
						$message1 .= '</html>';
						mail($to, $subject, $message1, $headers);
						
						$users->env_mail = 1;
						$users->update();
					}
				}
			}
			
			return $this->sendLoginResponse($request);
        }
			
       // if unsuccessful, then redirect back to the login with the form data
		$this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
    public function username()
    {
        return 'login';
    }

    public function logout()
    {
		 
        $log = new Log();
        $log->user_id = Auth::guard("admins")->user()->id;
        $log->action = "Admin Logged out";
        $log->save();
        Auth::guard('admins')->logout();
        return redirect('/');
    }
}
