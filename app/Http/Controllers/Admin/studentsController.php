<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Student;
use App\User;
use App\Teacher;
use App\Country;

use App\AdminHistory;
use File;
use DB;

class studentsController extends Controller
{
	
	
    public function getIndex(){
	  
      return view('admin.students.index');
    }
   
	
	public function getSearchresults(Request $request)
    {    	
		$created_at = $request->created_at;
        $email = $request->email;
        $username = $request->username;
		
    	$students = Student::join("users","students.id","=","users.id");
		
		if($request->full_name!=""){
			$students = $students->where(function($query) use($request){
				$query->where('users.full_name_ar','like','%'.$request->full_name.'%')
				->orWhere('users.full_name_en','like','%'.$request->full_name.'%');
			});
		}
        if($email != "")
            $students = $students->where('users.email',$email);
        if($username != "")
            $students = $students->where('users.username',$username);
		
		if($created_at != ""){
			$created_at =  date("y-m-d",strtotime($created_at));
			$students = $students->where(DB::raw("DATE(created_at)"),$created_at);
		}	
		$students = $students->get(["students.*"]);	
		
        return view('admin.students._search_results',	array(
        			'students'=>$students			
		)); 
		
    }

	public function getCreate(){		 	
		$users = User::get();
		$monthsArr = array(
			1=>"يناير",
			2=>"فبراير",
			3=>"مارس",
			4=>"إبريل",
			5=>"مايو",
			6=>"يونيو",
			7=>"يوليو",
			8=>"أغسطس",
			9=>"سبتمبر",
			10=>"أكتوبر",
			11=>"نوفمبر",
			12=>"ديسمبر",
		);
		$studentsData = Student::get();
        $countries = Country::get();
    	return view('admin.students.create',array(
    		"users"=>$users,"monthsArr"=>$monthsArr,
    		"studentsData"=>$studentsData,"countries"=>$countries
    		
		));
    }
	
	
	public function postCreate(Request $request){		
		DB::transaction(function() use($request){
			$user_id = 0;
			if($request->choose_user=="new"){
				$user = new User();
				$this->SetParameters($user, $request,"add");		
				if(Input::hasFile('image')){
			        $image= $request->file('image');
					$imageName=$image->getClientOriginalName();
					
					$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
					$imageName = $rnd.$imageName;
			        $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
					$user->image = $imageName;  
		        }
                if(Input::hasFile('passport')){
                    $image= $request->file('passport');
                    $imageName=$image->getClientOriginalName();

                    $rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
                    $imageName = $rnd.$imageName;
                    $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
                    $user->passport = $imageName;
                }
				$user->password = bcrypt($request->password);
		       	$user->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Add new student"; 
				$adminhistory->save();
				
				$user_id = $user->id;
			}else{
				$user_id = $request->user_id;
			}
			if($user_id!=0){
                $user = User::findOrFail($user_id);
                if(Input::hasFile('image')){
                    $image= $request->file('image');
                    $imageName=$image->getClientOriginalName();

                    $rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
                    $imageName = $rnd.$imageName;
                    $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
                    $user->image = $imageName;
                }
                $user->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update student"; 
				$adminhistory->save();
				
				$student = new Student();
				$student->id = $user_id;
                $student->health_info = $request->health_info;
				$student->save();
			}
			
		});
		
 		Session::flash('alert-success', 'Student has been added succesfully...');
       return redirect("admin/students/create");
   } 
	
	
   
   public function getEdit($id){
	    $student = Student::find($id);

		$users = User::get();
		$monthsArr = array(
			1=>"يناير",
			2=>"فبراير",
			3=>"مارس",
			4=>"إبريل",
			5=>"مايو",
			6=>"يونيو",
			7=>"يوليو",
			8=>"أغسطس",
			9=>"سبتمبر",
			10=>"أكتوبر",
			11=>"نوفمبر",
			12=>"ديسمبر",
		);
		$studentsData = Student::where("id","!=",$id)->get();
        $countries = Country::get();
		
	    return view("admin.students.edit",array(
    		"users"=>$users,"monthsArr"=>$monthsArr,
    		"student"=>$student,"studentsData"=>$studentsData,
            "countries"=>$countries
		));
   }
   public function postEdit(Request $request,$id){
       $student_id = $id;
   		DB::transaction(function() use($request,$id,&$student_id){
			$user_id = 0;

			if($request->choose_user=="new"){
				$user = new User();
				$this->SetParameters($user, $request,"add");		
				if(Input::hasFile('image')){
			        $image= $request->file('image');
					$imageName=$image->getClientOriginalName();
					
					$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
					$imageName = $rnd.$imageName;
			        $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
					$user->image = $imageName;  
		        }
                if(Input::hasFile('passport')){
                    $image= $request->file('passport');
                    $imageName=$image->getClientOriginalName();

                    $rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
                    $imageName = $rnd.$imageName;
                    $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
                    $user->passport = $imageName;
                }
				$user->password = bcrypt($request->password);
		       	$user->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update student"; 
				$adminhistory->save();
				
				$user_id = $user->id;
			}else{
				$user_id = $request->user_id;
            }
			if($user_id!=0){
                $user = User::findOrFail($user_id);
                if(Input::hasFile('image')){
                    $image= $request->file('image');
                    $imageName=$image->getClientOriginalName();

                    $rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
                    $imageName = $rnd.$imageName;
                    $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
                    $user->image = $imageName;
                }
                $user->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update student"; 
				$adminhistory->save();

				$student = Student::findOrFail($id);
				$student->id = $user_id;
                $student->health_info = $request->health_info;
				$student->save();
                $student_id = $student->id;
			}
		});
		
		Session::flash('alert-success', 'Student has been updated succesfully...');
		return redirect("admin/students/edit/".$student_id);
   }
  
   
   public function postDelete($id){
       if($id==1)
           return "error";
		$student = Student::findOrFail( $id );
		$student->delete();		
   }
   
   public function SetParameters(&$user,$request,$method){
       $user->full_name_ar = $request->full_name_ar;
       $user->full_name_en = $request->full_name_en;
       $user->mobile = $request->mobile;
       $user->phone = $request->phone;
       $user->email = $request->email;
       $user->nationality = $request->nationality;
       $user->address = $request->address;
       if($request->months != 0 && $request->years!=0){
           $date1 = $request->months."/".$request->days."/".$request->years;
           if(!checkdate($request->months,$request->days,$request->years)){
               if($request->days == 0)
                   $date1 = $request->months."/"."1"."/".$request->years;
               else{
                   $date1 = $request->months."/"."28"."/".$request->years;
               }
           }
           $birthday = date("Y-m-d", strtotime($date1));
           $user->date_of_birth = $birthday;
       }
       $user->username = $request->username;
       if(!empty($request->government_id))
           $user->government_id = $request->government_id;
       else
           $user->government_id = null;
       $user->zip_code = $request->zip_code;
       $user->streat = $request->streat;
       $user->house_number = $request->house_number;
       $user->clothing_size = $request->clothing_size;


       $user->password = bcrypt($request->password);
       if($request->active)
           $user->active = 1;
       else
           $user->active = 0;
	 }
   
   public function getUserDetails(Request $request){
   	$user_id = $request->userId;
	$user = User::findOrFail($user_id);
	return view("admin.students.tabs._user_details",array("user"=>$user));
   }
	
	public function getUniqueUser(Request $request){
		$id =  $request->id;
		$student_id = $request->student_id;
		$countUsers = 0;
		if($id!=$student_id){
			$countUsers = Teacher::where("id",$id)->count();
			$countUsers += Student::where("id",$id)->count();
		}
		if($countUsers>0)
			// Finally, return a JSON
			echo json_encode(array(
			    'valid' => false,
			));
		else {
			echo json_encode(array(
			    'valid' => true,
			));
		}
		
	} 
  

}
