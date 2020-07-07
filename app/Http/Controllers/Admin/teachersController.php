<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Teacher;
use App\TeacherTranslation;
use App\TeacherSocial;
use App\Student;
use App\User;
use App\Country;


use App\AdminHistory;
use File;
use DB;
use SoapClient;

class teachersController extends Controller
{
	
	
	public function __construct() {
		
    }
	
   public function getIndex(){
      $teachers=Teacher::get();
      return view('admin.teachers.index',array("teachers"=>$teachers));
    }
   
	public function getCreate(){ 
		$users = User::get();
		$socialArray = array(
			"fa fa-facebook"=>"facebook",
			"fa fa-twitter"=>"twitter",
			"fa fa-instagram"=>"instagram",
			"fa fa-linkedin"=>"linkedin",
			"fa fa-google-plus"=>"google-plus",
			"fa fa-rss"=>"rss-square"
		);
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
        $countries = Country::get();
		
    	return view('admin.teachers.create',compact("users","socialArray","monthsArr","countries"));
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
                    //$image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
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
				$adminhistory->description="Add new Teacher"; 
				$adminhistory->save(); 
				
                $user_id = $user->id;
            }else{
                $user_id = $request->user_id;
            }
            if($user_id!=0) {
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
				$adminhistory->description="Add new Teacher"; 
				$adminhistory->save();

                $teacher = new Teacher();
                if ($user_id)
                    $teacher->id = $user_id;

                if ($request->active)
                    $teacher->active = 1;
                else
                    $teacher->active = 0;
                if ($request->show_in_home)
                    $teacher->show_in_home = 1;
                else
                    $teacher->show_in_home = 0;
                $teacher->save();

                $teacher_trans = new TeacherTranslation();
                $teacher_trans->teacher_id = $teacher->id;
                $teacher_trans->job = $request->ar_job;
                $teacher_trans->about = $request->ar_about;
                $teacher_trans->lang = "ar";
                $teacher_trans->save();

                if ($request->en_job != "") {
                    $teacher_trans = new TeacherTranslation();
                    $teacher_trans->teacher_id = $teacher->id;
                    $teacher_trans->job = $request->en_job;
                    $teacher_trans->about = $request->en_about;
                    $teacher_trans->lang = "en";
                    $teacher_trans->save();
                }
                $this->saveSocials($request, $teacher);
            }
			
			Session::flash('alert-success', 'Teacher inserted successfully ..');
		});
		return redirect("/admin/teachers/create");
   } 
   
   public function getEdit($id){   	 	
	   	$teacher=Teacher::findOrFail($id);
		$users = User::get();
       $socialArray = array(
           "fa fa-facebook"=>"facebook",
           "fa fa-twitter"=>"twitter",
           "fa fa-instagram"=>"instagram",
           "fa fa-linkedin"=>"linkedin",
           "fa fa-google-plus"=>"google-plus",
           "fa fa-rss"=>"rss-square"
       );
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
       $countries = Country::get();
		
	    return view("admin.teachers.edit",compact('teacher','users','socialArray','monthsArr','countries'));
   }
   public function postEdit(Request $request,$id){
   
   		DB::transaction(function() use($request,$id){
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
				$adminhistory->description="Update Teacher"; 
				$adminhistory->save();
				
                $user_id = $user->id;
            }else{
                $user_id = $request->user_id;
            }
            if($user_id!=0) {
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
				$adminhistory->description="Update Teacher"; 
				$adminhistory->save();

                $teacher = Teacher::find($id);
                if ($user_id)
                    $teacher->id = $user_id;
                if ($request->active)
                    $teacher->active = 1;
                else
                    $teacher->active = 0;
                if ($request->show_in_home)
                    $teacher->show_in_home = 1;
                else
                    $teacher->show_in_home = 0;
                $teacher->save();

                $teacher_trans = TeacherTranslation::where("teacher_id", $id)->where("lang", "ar")->first();
                if (empty($teacher_trans))
                    $teacher_trans = new TeacherTranslation();
                $teacher_trans->teacher_id = $teacher->id;
                $teacher_trans->job = $request->ar_job;
                $teacher_trans->about = $request->ar_about;
                $teacher_trans->lang = "ar";
                $teacher_trans->save();

                if ($request->en_job != "") {
                    $teacher_trans = TeacherTranslation::where("teacher_id", $id)->where("lang", "en")->first();
                    if (empty($teacher_trans))
                        $teacher_trans = new TeacherTranslation();
                    $teacher_trans->teacher_id = $teacher->id;
                    $teacher_trans->job = $request->en_job;
                    $teacher_trans->about = $request->en_about;
                    $teacher_trans->lang = "en";
                    $teacher_trans->save();
                }
                $this->saveSocials($request, $teacher);
            }
			
			Session::flash('alert-success', 'teacher updated successfully...');
		});
		return redirect("/admin/teachers/edit/".$id);

   }

	public function saveSocials($request,$teacher){
		
		//*********** update current socials***********
		foreach($teacher->socials as $social){
			if($request->get("social_name_".$social->id)){
				$social->name = $request->get("social_name_".$social->id);
				$social->font = $request->get("social_font_".$social->id);
				$social->link = $request->get("social_link_".$social->id);
				$social->update();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current socials"; 
				$adminhistory->save();
			}else{
				$social->delete();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete socials"; 
				$adminhistory->save();
			}
		}
		
		//***********Insert new downloadlink****************
		$socials = $request->get("socials");
		if(!empty($socials)){
			foreach($socials as $social){
				$teacherSocial = new TeacherSocial();
				$teacherSocial->teacher_id = $teacher->id;
				$teacherSocial->name = $social["name"];
				$teacherSocial->font = $social["font"];
				$teacherSocial->link = $social["link"];
				$teacherSocial->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new downloadlink"; 
				$adminhistory->save();
			}
		}
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
        if(!empty($request->government_id))
            $user->government_id = $request->government_id;
        else
            $user->government_id = null;
        $user->zip_code = $request->zip_code;
        $user->streat = $request->streat;
        $user->house_number = $request->house_number;
        $user->clothing_size = $request->clothing_size;

        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        if($request->active)
            $user->active = 1;
        else
            $user->active = 0;
    }
   
   public function postDelete($id){
		$teacher = Teacher::findOrFail( $id );		
		$teacher->delete();
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
		
		$teacher = Teacher::find($ID);
		$teacher->$field=$newsate;
		$teacher->update();	
	} 
   
   public function getUniqueUser(Request $request){
		$id =  $request->id;
		$teacher_id = $request->teacher_id;
		$countTeachers = 0;
		if($id!=$teacher_id){
			$countTeachers = Teacher::where("id",$id)->count();
			//$countTeachers += Student::where("id",$id)->count();
		}
		if($countTeachers>0)
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
