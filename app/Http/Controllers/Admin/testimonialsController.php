<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Admin;
use App\Testimonial;
use App\TestimonialTranslation;

use App\AdminHistory;
use DB;

class testimonialsController extends Controller
{
	public function __construct() {
		/*if(!Auth::guard("admins")->user()->can("all")){
           abort(404);
        }*/
    }
	
    public function getIndex(){     
	  $testimonials = Testimonial::get();
	  
      return view('admin.testimonials.index',array(
      		"testimonials"=>$testimonials
		));
    }
	
	
	public function getCreate() {
      session_start();//to enable kcfinder for authenticated users
	 $_SESSION['KCFINDER'] = array();
	 $_SESSION['KCFINDER']['disabled'] = false; 
	 
	 
       return view("admin.testimonials.create");
    }

    public function postCreate(Request $request) {
    	DB::transaction(function() use($request){
			$testimonial = new Testimonial();
			$testimonial->image = $request->image;
			$testimonial->website = $request->website;
			if($request->active)
				$testimonial->active =  1;
			else {
				$testimonial->active =  0;
			}
			$testimonial->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add testimonials"; 
			$adminhistory->save(); 
			
			$testimonial_trans = new TestimonialTranslation();
			$testimonial_trans->testimonial_id = $testimonial->id;
			$testimonial_trans->title = $request->ar_title;
			$testimonial_trans->description = $request->ar_description;
			$testimonial_trans->name = $request->ar_name;
			$testimonial_trans->lang = "ar";
			$testimonial_trans->save();			
			
			if($request->en_title != ""){
				$testimonial_trans = new TestimonialTranslation();
				$testimonial_trans->testimonial_id = $testimonial->id;
				$testimonial_trans->title = $request->en_title;
				$testimonial_trans->description = $request->en_description;
				$testimonial_trans->name = $request->en_name;
				$testimonial_trans->lang = "en";
				$testimonial_trans->save();
			}			
			
		});
		
 		Session::flash('testimonial_inserted', 'Testimonial has been added succesfully...');
       return redirect("admin/testimonials/create");
    }
	
	public function getEdit($id){
		$testimonial = Testimonial::find($id);
		 session_start();//to enable kcfinder for authenticated users
		 $_SESSION['KCFINDER'] = array();
		 $_SESSION['KCFINDER']['disabled'] = false; 
		
		
		return view("admin.testimonials.edit",array(
			"testimonial"=>$testimonial
		));
	}
	public function postEdit(Request $request,$id){
		DB::transaction(function() use($request,$id){
			$testimonial = Testimonial::findOrFail($id);
			$testimonial->image = $request->image;
			$testimonial->website = $request->website;
			if($request->active)
				$testimonial->active =  1;
			else {
				$testimonial->active =  0;
			}
			$testimonial->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update testimonials"; 
			$adminhistory->save(); 
			
			$testimonial_trans = TestimonialTranslation::where("testimonial_id",$id)->where("lang","ar")->first();	
			if(empty($testimonial_trans))
				$testimonial_trans = new TestimonialTranslation();
			$testimonial_trans->testimonial_id = $testimonial->id;
			$testimonial_trans->title = $request->ar_title;
			$testimonial_trans->description = $request->ar_description;
			$testimonial_trans->name = $request->ar_name;
			$testimonial_trans->lang = "ar";
			$testimonial_trans->save();			
			
			
			$testimonial_trans = TestimonialTranslation::where("testimonial_id",$id)->where("lang","en")->first();	
			if(empty($testimonial_trans))
				$testimonial_trans = new TestimonialTranslation();
			$testimonial_trans->testimonial_id = $testimonial->id;
			$testimonial_trans->title = $request->en_title;
			$testimonial_trans->description = $request->en_description;
			$testimonial_trans->name = $request->en_name;
			$testimonial_trans->lang = "en";
			$testimonial_trans->save();			
			
		});
		
		Session::flash('testimonial_updated', 'Testimonial has been updated succesfully...');
		return redirect("admin/testimonials/edit/".$id);
	}
	public function postDelete($id){
		$testimonial = Testimonial::findOrFail( $id );		
		$testimonial->delete();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Delete testimonials"; 
			$adminhistory->save(); 
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
		
		$testimonial = Testimonial::find($ID);
		$testimonial->$field=$newsate;
		$testimonial->update();	
	}
	

}
