<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Template;

use DB;

class templatesController extends Controller
{
	public function __construct() {
		if(!Auth::guard("admins")->user()->can("settings")){
            echo view("admin.not_authorized");
			die;
        }
    }
	
   public function getIndex(){
      $templates=Template::get();
      return view('admin.templates.index',array("templates"=>$templates));
    }
   
	/*public function getCreate(){
		session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		  
    	return view('admin.templates.create');
    }*/

	
	public function postCreate(Request $request){
		
	   	$template = new EmailTemplate();
		$template->name = $request->name; 
		$template->content_en = $request->content_en; 
		$template->content_ar = $request->content_ar; 
	   	$template->save();
		Session::flash('Template_Inserted', 'Template has been inserted successfully ..');
		return redirect("/admin/templates/create/");
   } 
	
   
   public function getEdit($id){
   	session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		 
	   	$template=Template::findOrFail($id);
	    return view("admin.templates.edit",compact('template'));
   }
   public function postEdit(Request $request,$id){
   	
		$template = Template::find($id);
		$template->name = $request->name; 
		$template->content_en = $request->content_en; 
		$template->content_ar = $request->content_ar; 
	   	$template->save();
		
		Session::flash('Template_Updated', 'Template has been updated successfully ..');
		return redirect("/admin/templates/edit/".$id);
   }
   
   public function postDelete($id){
		$template = Template::findOrFail( $id );		
		$template->delete();
   }
   
  
   

}
