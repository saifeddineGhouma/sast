<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Agent;
use App\Country;

use App\AdminHistory;
use DB;
use Validator;

class agentsController extends Controller {
	 
	 public function __construct() {

    }
	 
  	public function getIndex()
    {
    	 $countries = Country::get();
		
    	 return view('admin.agents.index',array(
    	 	"countries"=>$countries
		)); 
    }
	public function getSearchagents($countryId)
	{
		$agents = Agent::with("country");
		
		if($countryId!=0)
			$agents = $agents->where('country_id',$countryId);
		
		$agents = $agents->get();	
	    return view('admin.agents._search_results',	array(
	    			'agents'=>$agents			
		)); 
		
	}

    public function postCreate(Request $request) {
    	DB::transaction(function() use($request){
	        $agent = new Agent();

            $rules = $agent->rules();
            $this->validate($request, $rules);

			$agent->fill($request->all());
	        $agent->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add new agent"; 
			$adminhistory->save(); 
		});
		
		
 		Session::flash('alert-success', 'Agent has been added succesfully...');
    }
	
	public function postEdit(Request $request,$id){
		 DB::transaction(function() use($request,$id){
			$agent = Agent::find($id);

            $rules = $agent->rules();
            $this->validate($request, $rules);

            $agent->fill($request->all());
			$agent->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update page"; 
			$adminhistory->save(); 
		});
		
		Session::flash('alert-success', 'Agent has been updated succesfully...');
	}
	public function postDelete($id){
		$agent = Agent::findOrFail( $id );
		//handle related records don't forget to handle
		$agent->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete page"; 
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

        $agent = Agent::find($ID);
        $agent->$field=$newsate;
        $agent->update();
    }
   
}