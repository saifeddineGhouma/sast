<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Country;
use App\CountryTranslation;

use App\Government;
use App\GovernmentTranslation;

use App\AdminHistory;
use DB;
use Validator;

class countriesController extends Controller {
	 
	public function __construct() {

    }

		 
  	public function getIndex()
    {
    	 $countries = Country::orderBy('code', 'ASC')->get();		
    	 return view('admin.countries.index',array("countries"=>$countries)); 
    }

    public function postCreate(Request $request) {
    	DB::transaction(function() use($request){
	        $country = new Country(); 
			$country->code = $request->code;
            $country->sort_order = $request->sort_order;
            $country->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add new countrie"; 
			$adminhistory->save(); 
			
			$country_trans = new CountryTranslation();
			$country_trans->country_id = $country->id;
			$country_trans->name = $request->en_name;
			$country_trans->lang = "en";
			$country_trans->save();			
			
			if($request->ar_name != ""){
				$country_trans = new CountryTranslation();
				$country_trans->country_id = $country->id;
				$country_trans->name = $request->ar_name;
				$country_trans->lang = "ar";
				$country_trans->save();
				
			}
		});
		
 		Session::flash('country_inserted', 'Country has been added succesfully...');
    }
	
	public function postEdit(Request $request,$id){
		 DB::transaction(function() use($request,$id){
			$country = Country::find($id);	
			$country->code = $request->code;
             $country->sort_order = $request->sort_order;
			$country->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Edit countrie"; 
			$adminhistory->save(); 
			
       		$country_trans = CountryTranslation::where("country_id",$id)->where("lang","en")->first();	
			if(empty($country_trans))
				$country_trans = new CountryTranslation();
			$country_trans->country_id = $id;
			$country_trans->name = $request->en_name;
			$country_trans->lang = "en";		
			$country_trans->save();
			
			if($request->ar_name != ""){
				$country_trans = CountryTranslation::where("country_id",$id)->where("lang","ar")->first();	
				if(empty($country_trans))
					$country_trans = new CountryTranslation();
				$country_trans->country_id = $id;
				$country_trans->name = $request->ar_name;
				$country_trans->lang = "ar";		
				$country_trans->save();
			}
		});
		
		Session::flash('country_updated', 'Country has been updated succesfully...');
	}
	public function postDelete($id){
		$country = Country::findOrFail( $id );
		//handle related records don't forget to handle
		$country->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete countrie"; 
		$adminhistory->save(); 
		
	}
	
	public function getUniqueName(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'name' => '|unique:countries_translations,name,'.$id.',country_id',      
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}
   
}
