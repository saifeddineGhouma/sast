<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Government;
use App\GovernmentTranslation;
use App\Country;

use App\AdminHistory;
use DB;
use Validator;

class governmentsController extends Controller {
	 
	 public function __construct() {

    }
	 
  	public function getIndex()
    {
    	 $countries = Country::get();
		
    	 return view('admin.governments.index',array(
    	 	"countries"=>$countries
		)); 
    }
	public function getSearchgovernments($countryId)
	{
		$governments = Government::with("country");
		
		if($countryId!=0)
			$governments = $governments->where('country_id',$countryId);
		
		$governments = $governments->get();	
	    return view('admin.governments._search_results',	array(
	    			'governments'=>$governments			
		)); 
		
	}

    public function postCreate(Request $request) {
    	DB::transaction(function() use($request){
	        $government = new Government(); 
			$government->country_id = $request->get('country_id');		     
	        $government->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add new government"; 
			$adminhistory->save(); 
			
			$govern_trans = new GovernmentTranslation();
			$govern_trans->government_id = $government->id;
			$govern_trans->name = $request->en_name;
			$govern_trans->lang = "en";
			$govern_trans->save();
			
			
			if($request->ar_name != ""){
				$govern_trans = new GovernmentTranslation();
				$govern_trans->government_id = $government->id;
				$govern_trans->name = $request->ar_name;
				$govern_trans->lang = "ar";
				$govern_trans->save();				
			}
		});
		
		
 		Session::flash('government_inserted', 'Government has been added succesfully...');
    }
	
	public function postEdit(Request $request,$id){
		 DB::transaction(function() use($request,$id){
			$government = Government::find($id);
			$government->country_id = $request->get('country_id');	
			$government->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update government"; 
			$adminhistory->save(); 
			
       		$govern_trans = GovernmentTranslation::where("government_id",$id)->where("lang","en")->first();	
			if(empty($govern_trans))
				$govern_trans = new GovernmentTranslation();
			$govern_trans->government_id = $id;
			$govern_trans->name = $request->en_name;
			$govern_trans->lang = "en";		
			$govern_trans->save();
			
			if($request->ar_name != ""){
				$govern_trans = GovernmentTranslation::where("government_id",$id)->where("lang","ar")->first();	
				if(empty($govern_trans))
					$govern_trans = new GovernmentTranslation();
				$govern_trans->government_id = $id;
				$govern_trans->name = $request->ar_name;
				$govern_trans->lang = "ar";		
				$govern_trans->save();				
			}
		});
		
		Session::flash('government_updated', 'Government has been updated succesfully...');
	}
	public function postDelete($id){
		$government = Government::findOrFail( $id );
		//handle related records don't forget to handle
		$government->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Deletew government"; 
		$adminhistory->save(); 
		
	}
	
	public function getUniqueName(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'name' => '|unique:governments_translations,name,'.$id.',government_id',     
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}
   
}