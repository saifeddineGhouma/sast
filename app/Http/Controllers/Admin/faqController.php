<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Faq;
use App\FaqTranslation;

use App\AdminHistory;
use File;
use DB;

class faqController extends Controller
{
	public function __construct() {
		/*if(!Auth::guard("admins")->user()->can("all")){
           abort(404);
        }*/
    }
	
    public function getIndex(){
      $faqs = Faq::get();
      return view('admin.faq.index',array("faqs"=>$faqs));
    }

    public function postCreate(Request $request) {
    	DB::transaction(function() use($request){
	        $faq = new Faq(); 
			$faq->sort_order = $request->sort_order;
	        $faq->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add FAQ"; 
			$adminhistory->save(); 
			
			$faq_trans = new FaqTranslation();
			$faq_trans->faq_id = $faq->id;
			$faq_trans->question = $request->ar_question;
			$faq_trans->answer = $request->ar_answer;
			$faq_trans->lang = "ar";
			$faq_trans->save();			
			
			if($request->en_question != ""){
				$faq_trans = new FaqTranslation();
				$faq_trans->faq_id = $faq->id;
				$faq_trans->question = $request->en_question;
				$faq_trans->answer = $request->en_answer;
				$faq_trans->lang = "en";
				$faq_trans->save();	
			}
		});
 		Session::flash('faq_inserted', 'Faq has been added succesfully...');
    }
	
	public function postEdit(Request $request,$id){
		 DB::transaction(function() use($request,$id){
			$faq = Faq::find($id);	
			$faq->sort_order = $request->sort_order;
			$faq->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update FAQ"; 
			$adminhistory->save(); 
			
       		$faq_trans = FaqTranslation::where("faq_id",$id)->where("lang","ar")->first();	
			if(empty($faq_trans))
				$faq_trans = new FaqTranslation();
			$faq_trans->faq_id = $id;
			$faq_trans->question = $request->ar_question;
			$faq_trans->answer = $request->ar_answer;
			$faq_trans->lang = "ar";		
			$faq_trans->save();
			
			if($request->en_question != ""){
				$faq_trans = FaqTranslation::where("faq_id",$id)->where("lang","en")->first();	
				if(empty($faq_trans))
					$faq_trans = new FaqTranslation();
				$faq_trans->faq_id = $id;
				$faq_trans->question = $request->en_question;
				$faq_trans->answer = $request->en_answer;
				$faq_trans->lang = "en";		
				$faq_trans->save();
			}
		});
		
		Session::flash('faq_updated', 'Faq has been updated succesfully...');
	}
	public function postDelete($id){
		$faq = Faq::findOrFail( $id );
		//handle related records don't forget to handle
		$faq->delete();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Delete FAQ"; 
			$adminhistory->save(); 
		
	}

}
