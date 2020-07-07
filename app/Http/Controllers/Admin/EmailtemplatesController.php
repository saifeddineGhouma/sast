<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\EmailTemplate;

use App\AdminHistory;
use DB;

class EmailtemplatesController extends Controller
{
	public function __construct() {

    }
	
   public function getIndex(){
       if(!Auth::guard("admins")->user()->can("users")){
           abort(404);
       }
      $emailTemplates=EmailTemplate::get();
      return view('admin.emailtemplates.index',array("emailTemplates"=>$emailTemplates));
    }
   
	public function getCreate(){
		session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		  
    	return view('admin.emailtemplates.create');
    }

	
	public function postCreate(Request $request){
		
	   	$emailTemplate = new EmailTemplate();
		$emailTemplate->subject = $request->subject; 
		$emailTemplate->body = $request->body; 
		if($request->active)
			$emailTemplate->active = 1;
		else
			$emailTemplate->active = 0;  
	   	$emailTemplate->save();
		Session::flash('EmailTemplate_Inserted', 'Template has been inserted successfully ..');
		return redirect("/admin/emailtemplates/create/");
   } 
	
   
   public function getEdit($id){
   	session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		 
	   	$emailTemplate=EmailTemplate::findOrFail($id);
	    return view("admin.emailtemplates.edit",compact('emailTemplate'));
   }
   public function postEdit(Request $request,$id){
   	
		$emailTemplate = EmailTemplate::find($id);
		$emailTemplate->subject = $request->subject; 
		$emailTemplate->body = $request->body; 
		if($request->active)
			$emailTemplate->active = 1;
		else
			$emailTemplate->active = 0;  
	   	$emailTemplate->save();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Add email Template"; 
		$adminhistory->save(); 
		
		Session::flash('EmailTemplate_Updated', 'Template has been updated successfully ..');
		return redirect("/admin/emailtemplates/edit/".$id);
   }
   
   public function postDelete($id){
		$emailTemplate = EmailTemplate::findOrFail( $id );		
		$emailTemplate->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete email Template"; 
		$adminhistory->save();
   }
   
   public function postSendtestmail(Request $request){
   		
		$email = $request->get("testmail");
		$subject = $request->get("subject");
		$message1 = $request->get("body");
		$status = 0;
		try {
			$status = Mail::send('emails.testmail', ['subject'=>$subject,'message1'=>$message1,'email'=>$email], function($message) use ($email,$subject)
			{
			    $message->to($email)->subject($subject);
			});
			if( $status ) 
				echo "<div class='alert alert-success'>لقد تم إرسال الرسالة بنجاح</div>";
		}catch(\Exception $e){
			echo "<div class='alert alert-danger'>".$e->getMessage()."</div>";
		}
		
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
		
		$emailTemplate = EmailTemplate::find($ID);
		$emailTemplate->$field=$newsate;
		$emailTemplate->update();	
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Update email Template"; 
		$adminhistory->save();
	}

}
