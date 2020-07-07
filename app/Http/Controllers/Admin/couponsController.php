<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\AdminHistory;
use App\User;
use App\Coupon;

use DB;

class couponsController extends Controller
{
	public function __construct() {
		
    }
	
    public function getIndex(){

	  $coupons = Coupon::get();
	  
      return view('admin.coupons.index',array(
      		"coupons"=>$coupons
		));
    }
   
	

	public function getCreate(){
		
    	return view('admin.coupons.create');
    }
	
	
	public function postCreate(Request $request){
		
		DB::transaction(function() use($request){
		   $coupon = new Coupon();
		   $coupon->coupon_number = $request->coupon_number;		   
		   $coupon->discount = $request->discount;
		   $coupon->ordertotal_greater = $request->ordertotal_greater;
		   $coupon->limits = $request->limits;
		   $coupon->date_from = $request->date_from;
		   $coupon->date_to = $request->date_to;
		   $coupon->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Add new coupons"; 
			$adminhistory->save(); 
		   
		   $usernames = explode(",", $request->usernames);
		   $userIds = User::whereIn("username",$usernames)->pluck("id")->all();
		   $coupon->users()->sync($userIds);
		   
			Session::flash('alert-success', 'Coupon Created Successfully...');
		});
		return redirect("/admin/coupons/create");
   } 
   
   public function getEdit($id){
		$coupon=Coupon::where("id",$id)->firstOrFail();
			
	    return view('admin.coupons.edit',array(
	        "coupon"=>$coupon
		));
   }
   public function postEdit(Request $request,$id){
   		
		DB::transaction(function() use($request,$id){
   			$coupon = Coupon::find($id); 
		   $coupon->coupon_number = $request->coupon_number;		   
		   $coupon->discount = $request->discount;
		   $coupon->ordertotal_greater = $request->ordertotal_greater;
		   $coupon->limits = $request->limits;
		   $coupon->date_from = $request->date_from;
		   $coupon->date_to = $request->date_to;
		   $coupon->save();
				
			$adminhistory = new AdminHistory; 
			$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
			$adminhistory->entree=date('Y-m-d H:i:s'); 
			$adminhistory->description="Update coupons"; 
			$adminhistory->save(); 
		   
		   $usernames = explode(",", $request->usernames);
		   $userIds = User::whereIn("username",$usernames)->pluck("id")->all();
		   $coupon->users()->sync($userIds);
			
			Session::flash('alert-success', 'Coupon Updated Successfully...');
		});
		return redirect("admin/coupons/edit/".$id);
   }

	
   
   public function postDelete($id){
		$coupon = Coupon::findOrFail( $id );
		$coupon->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete coupons"; 
		$adminhistory->save(); 
   }
   
   public function getUniqueNumber(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'coupon_number' => '|unique:coupons,coupon_number,'.$id,
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}
  

}
