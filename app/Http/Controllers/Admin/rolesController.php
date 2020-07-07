<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Admin;
use App\Role;
use App\Permission;
use App\AdminHistory;
use DB;
use Validator;

class rolesController extends Controller {
	protected $user;
	
	public function __construct() {		
		 $this->middleware(function ($request, $next) {
	        $this->user = Auth::guard("admins")->user();
	        return $next($request);
	    });
    }
	 
  	public function getIndex()
    {
    	if(!$this->user->can("admins")){
           echo view("admin.not_authorized");
			die;
        }
		
    	 $roles = Role::get();		
    	 return view('admin.roles.index',array("roles"=>$roles)); 
    }
	 public function getCreate() {
        $permissions = Permission::get();
        return view("admin.roles.create", compact("permissions"));
    }

    public function postCreate(Request $request) {
		$role = new Role();
		$role->name =  $request->name;
		$role->display_name =  $request->display_name;
		$role->description =  $request->description;
		$role->save();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Add new user"; 
		$adminhistory->save();
		
		//$permissions = array_filter(array_values($request->perms));		
		$role->perms()->sync((array) $request->perms);
		
 		Session::flash('alert-success', 'Role has been added succesfully...');
       return redirect("admin/roles/create");
    }
	
	public function getEdit($id){
		$role = Role::find($id);
		$permissions = Permission::get();
		return view("admin.roles.edit",array(
			"role"=>$role,"permissions"=>$permissions		
		));
	}
	public function postEdit(Request $request,$id){
		
		$role = Role::findOrFail($id);
		$role->name =  $request->name;
		$role->display_name =  $request->display_name;
		$role->description =  $request->description;
		$role->save();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Update user"; 
		$adminhistory->save();
		
		//$permissions = array_filter(array_values($request->perms));		
		$role->perms()->sync((array) $request->perms);
		
		Session::flash('alert-success', 'Role has been updated succesfully...');
		return redirect("admin/roles/edit/".$role->id);
	}
	public function postDelete($id){
		$role = Role::findOrFail( $id );		
		$role->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete user"; 
		$adminhistory->save();
	}
	
   
}
