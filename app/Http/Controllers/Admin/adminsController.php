<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Admin;
use App\Role;
use App\Student;
use App\AdminHistory;
use File;
use DB;

use Validator;

class adminsController extends Controller {
	
	public function __construct() {
		
    }
	 
  	public function getIndex()
    {
    	if(!Auth::guard("admins")->user()->can("admins")){
           echo view("admin.not_authorized");
			die;
        }
        $admins = Admin::active()->get();
		 
		 
    	 return view('admin.admins.index',array("admins"=>$admins)); 
    }
	 public function getCreate() {
	 	if(!Auth::guard("admins")->user()->can("admins")){
           echo view("admin.not_authorized");
			die;
        }
		
        $roles = Role::get();
		
        return view("admin.admins.create", compact("roles"));
    }

    public function postCreate(Request $request) {
    	if(!Auth::guard("admins")->user()->can("admins")){
           echo view("admin.not_authorized");
			die;
        }
    	
        $this->validate($request, [
            'username' => '|unique:admins',
            'email' => '|unique:admins',  
            'image'=> '|mimes:jpeg,bmp,png|max:1024'              
        ],['username.unique'=>'username is already registered',
           'email.unique'=>'email is already registered '
           ]);
		
		$admin = new Admin();
		$admin->username = $request->get("username");
		$admin->name = $request->get("name");
		$admin->email = $request->get("email");
		$admin->password = bcrypt($request->get("password"));
		if(Input::hasFile('image')){
	        $image= $request->file('image');
			$imageName=$image->getClientOriginalName();
			$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
			$imageName = $rnd.$imageName;
	        $image->move( 'uploads/kcfinder/upload/image/admins/' , $imageName );
			$admin->image = $imageName;  
        }
		$admin->save();	
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Add new admin"; 
		$adminhistory->save();
		
		$admin->roles()->attach($request->role_id);
		       
		
 		Session::flash('alert-success', 'Admin has been Inserted Successfully...');
        return redirect("admin/admins/create");
    }
	
	public function getEdit($id){
		if(!(Auth::guard("admins")->user()->can("admins") || Auth::guard("admins")->user()->id==$id)){
           echo view("admin.not_authorized");
			die;
        }
		
		$admin = Admin::findOrFail($id);
		$roles = Role::get();
		
		return view("admin.admins.edit",array("admin"=>$admin,"roles"=>$roles
			));
	}
	
	public function postEdit(Request $request,$id){
		$this->validate($request, [
            'username' => '|unique:admins,username,'.$id,
            'email' => '|unique:admins,email,'.$id, 
            'image'=> '|mimes:jpeg,bmp,png|max:1024'             
        ],['username.unique'=>'username is already registered',
           'email.unique'=>'email is already registered '
           ]);
		   
		$admin = Admin::findOrFail($id);
		$admin->username = $request->get("username");
		$admin->name = $request->get("name");
		$admin->email = $request->get("email");
		if(Input::hasFile('image')){
	        $image= $request->file('image');
			$imageName=$image->getClientOriginalName();
			if(!empty($admin->image)){   //delete old image
				File::delete('uploads/kcfinder/upload/image/admins/'. $admin->image);
			}
			$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
			$imageName = $rnd.$imageName;
	        $image->move( 'uploads/kcfinder/upload/image/admins/' , $imageName );
			$admin->image = $imageName;  
        }
		
		if($request->checkPassword)
			$admin->password = bcrypt($request->get("password"));
		$admin->save();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Update admin"; 
		$adminhistory->save();
		
		if(Auth::guard("admins")->user()->can("admins")){
			$admin->roles()->sync(array($request->role_id));
		}
		
		Session::flash('alert-success', 'Admin has been Updated Successfully...');
		return redirect("admin/admins/edit/".$admin->id);
	}
	
    public function addStudent($id){
    	
        try {
            $student = new  Student();
            if(!empty($student)){
                $student->id = $id;
                $student->save();
            }
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return back();
    }
    
	public function postDelete($id){
		if(!Auth::guard("admins")->user()->can("admins")){
           echo view("admin.not_authorized");
			die;
        }
			
		$admin = Admin::findOrFail( $id );	
		
        if($id==1){
            return "error";
        }

        if(!empty($admin->image)){
            File::delete('uploads/kcfinder/upload/image/admins/'. $admin->image);
        }
        $admin->active = 0;
        $admin->save();
        //$admin->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete admin"; 
		$adminhistory->save();

	}
	
	public function postDeleteimaeajax(Request $request){
		
		$data = json_decode(stripslashes( $request->get("data")), true);		
		
		File::delete('uploads/admins/'. $data[1]);
		
		$admin = Admin::find($data[0]);
		$admin->image = Null;
		$admin->update();	
		
		return view('admin.admins._images',array('admin'=>new Admin));
       
	}		
   
}
