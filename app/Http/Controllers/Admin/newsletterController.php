<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Newsletter;
use App\EmailTemplate;
use App\User;

use App\AdminHistory;
use DB;

class newsletterController extends Controller
{
	public function __construct() {

    }
	public function getIndex(){
        if(!Auth::guard("admins")->user()->can("users")){
            echo view("admin.not_authorized");
            die;
        }
        $newsletters=Newsletter::get();
        return view('admin.newsletter.index',array("newsletters"=>$newsletters));
    }
	
    public function getSubscribers(){
        $subscribers=NewsletterSubscriber::get();
        return view('admin.newsletter.subscriber',array("subscribers"=>$subscribers));
    }
   
   
    public function getCreate(){

		$emailTemplates = EmailTemplate::get();
		
		session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		 
    	return view('admin.newsletter.create',array("emailTemplates"=>$emailTemplates));
    }

	
	public function postCreate(Request $request){
		DB::transaction(function() use($request){	
		   	$newsletter = new Newsletter();
			$newsletter->subject = $request->subject; 
			$newsletter->body = $request->body; 
			$newsletter->sendto = $request->sendto;
			$newsletter->otheremail = $request->othermail;  
			if($request->checkbydate){
				$newsletter->checkbydate = 1;
				$newsletter->start_date = $request->start_date;   
				$newsletter->end_date = $request->end_date;   
				$newsletter->repeated = $request->repeated;    
			} 
			if($request->active)
				$newsletter->active = 1;
			else 
				$newsletter->active = 0;
		   	$newsletter->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add newsletter"; 
			$adminhistory->save(); 
			
			$message = "";
			if(!$request->checkbydate){
				$message = $this->sendEmail($newsletter);
			}
			Session::flash('Newsletter_Inserted', 'newsletter as been inserted successfully ..<br/>'.$message);
		});
		return redirect("/admin/newsletter/create/");
   } 
	
	
   public function getEdit($id){
	   	$newsletter=Newsletter::findOrFail($id);
		$emailTemplates = EmailTemplate::get();
		
		session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		 
	    return view("admin.newsletter.edit",compact('newsletter','emailTemplates'));
   }
   public function postEdit(Request $request,$id){
   		DB::transaction(function() use($request,$id){	
			$newsletter = Newsletter::find($id);
			$newsletter->subject = $request->subject; 
			$newsletter->body = $request->body; 
			$newsletter->sendto = $request->sendto;
			$newsletter->otheremail = $request->othermail;  
			if($request->checkbydate){
				$newsletter->checkbydate = 1; 
				$newsletter->start_date = $request->start_date;   
				$newsletter->end_date = $request->end_date;   
				$newsletter->repeated = $request->repeated;    
			} 
			if($request->active)
				$newsletter->active = 1;
			else 
				$newsletter->active = 0;
			
		   	$newsletter->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update newsletter"; 
			$adminhistory->save(); 
			$message = "";
			if(!$request->checkbydate){
				$message = $this->sendEmail($newsletter);
			}
			Session::flash('Newsletter_Updated', 'newsletter has been updated succussfully ..<br/>'.$message);
		});
		return redirect("/admin/newsletter/edit/".$id);
   }
   
   public function postDeletesubscriber($id){
		$subscriber = NewsletterSubscriber::findOrFail( $id );		
		$subscriber->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete newsletter"; 
		$adminhistory->save(); 
   }
   
   public function getTemplate($id){
   		return EmailTemplate::find($id);
		
   }
   public function postDelete($id){
		$newsletter = Newsletter::findOrFail( $id );		
		$newsletter->delete();
   }
   
   public function postUpdatestateajax(Request $request){
		$ID = $request->get("sp");
		$newsate =$request->get("newsate");
		$field = $request->get("field");	
		
		if($newsate=='true'){
			$newsate = 1;
		}else{
			$newsate = 0;
		}
		
		$newsletter = Newsletter::find($ID);
		$newsletter->$field=$newsate;
		$newsletter->update();	
	}
   


public function recurseDate($startDate,$newsletter){
		 $date=date("Y-m-d");
		 if($date == $startDate){
		 	return $this->sendEmail($newsletter);
		 }else if($date>$startDate){
		 	echo $startDate."<br/>";
		 	$startDate = date('Y-m-d', strtotime($startDate . "+ ".$newsletter->repeated." days")); 
			$this->recurseDate($startDate,$newsletter);
		 }else
		 	return;
	}

   public function sendEmail($newsletter){
   		$sendTo = $newsletter->sendto;
		 $to_emails = array();
		if($sendTo==0){
			$to_emails = NewsletterSubscriber::where("active",1)->pluck("email")->all();
			
		}elseif($sendTo==1){
			$to_emails = User::where("active",1)->pluck("email")->all();
		}elseif($sendTo==2){
			$to_emails = User::where("active",1)->where("group_id",$newsletter->group_id)->pluck("email")->all();
		}
		if($newsletter->otheremail!=""){
			$otherarr = array();
			$otherarr = explode("," , $newsletter->otheremail);
			$to_emails = array_merge($to_emails,array_values($otherarr));
		}
		
   		
		$subject = $newsletter->subject;
		$message1 =  $newsletter->body;
		$message2 = $message1;
		
		$status = 0;
		try {
			foreach ($to_emails as $to_email) {
				$user = User::where("email",$to_email)->first();
				$username = "";
				if(!empty($user)){
					$username = $user->username;					
				}
				$message1 = str_replace('{username}', $username, $message1);
				$status = Mail::send('emails.testmail', ['message1'=>$message1], function($message) use ($to_email,$subject)
				{
				    $message->to($to_email)->subject($subject);
				});
				$message1 = $message2;
			}
			
			if( $status ) 
				return "<div class='alert alert-success'>لقد تم إرسال الرسالة بنجاح</div>";
		}catch(\Exception $e){
			return "<div class='alert alert-danger'>".$e->getMessage()."</div>";
		}
   }
	
	
}
