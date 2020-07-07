<?php

namespace App\Http\Controllers\Teacher;

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

use File;
use DB;
use SoapClient;

class teachersController extends Controller
{
	

   public function profile(){
	   	$teacher = Auth::guard("teachers")->user()->teacher;

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
		
	    return view("teachers.teachers.edit",compact('teacher','socialArray','monthsArr','countries'));
   }
   public function postProfile(Request $request){
   
   		DB::transaction(function() use($request){
            $user = Auth::guard("teachers")->user();
            if(Input::hasFile('image')){
                $image= $request->file('image');
                $imageName=$image->getClientOriginalName();

                $rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
                $imageName = $rnd.$imageName;
                $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
                $user->image = $imageName;
            }
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

            if($request->active)
                $user->active = 1;
            else
                $user->active = 0;

            if($request->email_verified)
                $user->email_verified = 1;
            else
                $user->email_verified = 0;
            if($request->mobile_verified)
                $user->mobile_verified = 1;
            else
                $user->mobile_verified = 0;
            $user->save();

            $teacher = $user->teacher;

            $teacher_trans = TeacherTranslation::where("teacher_id", $teacher->id)->where("lang", "ar")->first();
            if (empty($teacher_trans))
                $teacher_trans = new TeacherTranslation();
            $teacher_trans->teacher_id = $teacher->id;
            $teacher_trans->job = $request->ar_job;
            $teacher_trans->about = $request->ar_about;
            $teacher_trans->lang = "ar";
            $teacher_trans->save();

            if ($request->en_job != "") {
                $teacher_trans = TeacherTranslation::where("teacher_id", $teacher->id)->where("lang", "en")->first();
                if (empty($teacher_trans))
                    $teacher_trans = new TeacherTranslation();
                $teacher_trans->teacher_id = $teacher->id;
                $teacher_trans->job = $request->en_job;
                $teacher_trans->about = $request->en_about;
                $teacher_trans->lang = "en";
                $teacher_trans->save();
            }
            $this->saveSocials($request, $teacher);

			
			Session::flash('alert-success', 'teacher updated successfully...');
		});
		return redirect("/teachers/profile");

   }

	public function saveSocials($request,$teacher){
		
		//*********** update current socials***********
		foreach($teacher->socials as $social){
			if($request->get("social_name_".$social->id)){
				$social->name = $request->get("social_name_".$social->id);
				$social->font = $request->get("social_font_".$social->id);
				$social->link = $request->get("social_link_".$social->id);
				$social->update();
			}else{
				$social->delete();
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

    public function getUniqueUsername(Request $request){
        $id =  $request->id;
        $validator=Validator::make($request->toArray(),
            array(
                'username' => '|unique:users,username,'.$id,
            ));

        // Finally, return a JSON
        echo json_encode(array(
            'valid' => !$validator->fails(),
        ));
    }
    public function getUniqueEmail(Request $request){
        $id =  $request->id;
        $validator=Validator::make($request->toArray(),
            array(
                'email' => '|unique:users,email,'.$id,
            ));

        // Finally, return a JSON
        echo json_encode(array(
            'valid' => !$validator->fails(),
        ));
    }

}
