<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\NewsletterSubscriber;
use App\User;
use App\Teacher;
use App\TeacherUser;
use App\Log;

use DB;
class HomeController extends Controller
{
	public function getIndex(){
		if(Auth::guard("teachers")->check()){

			
			/*$orders = Order::orderBy("created_at","desc")->take(10)->get();*/
		    return view("teachers.welcome");
		}
	}
	

	
    public function getLock(){
    	if(Auth::guard("teachers")->check()){
            Session::put('locked', true);
			
            return view('teachers.auth.lock');
        }else{
        	return redirect('/teachers');
        }
    }
	
	 public function postLock(Request $request){
	 	// if user in not logged in 
        if(!Auth::guard("teachers")->check())
            return "autherror";

        $password = $request->get('password');

        if(\Hash::check($password,Auth::guard("teachers")->user()->password)){
            Session::forget('locked');
            return "success";
        }		
		
		return "passwordIncorrect";//redirect("admin/home/lock");
	 }

	 public function loginUser($user_id){
         Auth::loginUsingId($user_id, true);
         return redirect('/');
     }
	 
	 public function getLogout1(){
	 	Auth::guard("teachers")->logout();
		   \Session::forget('locked');
		 return redirect('/teachers');
	 }
	 
	 public function postSendemail(Request $request){
	 	$email = $request->get("quick_email");
		$subject = $request->get("quick_subject");
		$message1 = $request->get("quick_message");
		$status = 0;
		try {
			$status = Mail::send('emails.testmail', ['subject'=>$subject,'message1'=>$message1,'email'=>$email], function($message) use ($email,$subject)
			{
			    $message->to($email)->subject($subject);
			});
			if( $status ) 
				echo "<div class='alert alert-success'>Message has been sent successfully...</div>";
		}catch(\Exception $e){
			echo "<div class='alert alert-danger'>".$e->getMessage()."</div>";
		}
	 }
	 
	 public function getUnique(Request $request){
		$columnfield = $request->columnfield;
		$value = $request->value;
		$id = $request->id;
		$idcolumn = $request->idcolumn;
		
		//$field1arr = explode("_", $field);
		
		$tableCount =  DB::table($request->table)->where($idcolumn,"!=",$id)->where($columnfield,$value)->count();
		return $tableCount;
	}

    public function getGovernments(Request $request){
        $result = array();

        $countryId = $request->get("countryId");

        $governments = Government::where('country_id',$countryId)->get();

        $result["governments"] = '<option value="">--- Please Select ---</option>';

        if(!$governments->isEmpty()){
            foreach($governments as $government){
                if(isset($government->government_trans(App("lang"))->name))
                    $name = $government->government_trans(App("lang"))->name;
                else {
                    $name = $government->government_trans("en")->name;
                }
                $result["governments"] .= '<option value="'.$government->id.'">'.$name.'</option>';
            }
        }
        return $result;
    }
   
}
