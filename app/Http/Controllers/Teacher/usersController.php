<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Teacher;
use App\User;
use App\Country;
use App\Government;

use File;
use DB;


class usersController extends Controller
{
	public function __construct() {

    }
	
    public function getIndex(){
        if(!Auth::guard("teachers")->user()->can("users")){
            echo view("teachers.not_authorized");
            die;
        }

	    $users = User::get();
        return view('teachers.users.index',array(
            "users"=>$users
        ));
    }
   
	
	public function getSearchresults(Request $request)
    {
    	$email = $request->email;
    	$active = $request->active;
		$created_at = $request->created_at;
		$username = $request->username;
		
    	$users = User::with("newsletter_subscibers");

        if($request->full_name!=""){
            $users = $users->where(function($query) use($request){
                $query->where('users.full_name_ar','like','%'.$request->full_name.'%')
                    ->orWhere('users.full_name_en','like','%'.$request->full_name.'%');
            });
        }
		if($email != "")
    		$users = $users->where('email',$email);
        if($username != "")
            $users = $users->where('username',$username);
		if($created_at != ""){
			$created_at =  date("y-m-d",strtotime($created_at));
			$users = $users->where(DB::raw("DATE(created_at)"),$created_at);
		}
		if($active != "")
			$users = $users->where('active',$active);
			
		
		$users = $users->get(["users.*"]);	
		
        return view('teachers.users._search_results',	array(
        			'users'=>$users			
		));
    }

	public function getCreate(){
				
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
    	return view('admin.users.create',array(
    		"monthsArr"=>$monthsArr,"countries"=>$countries
		));
    }
	
	
	public function postCreate(Request $request){
		$this->validate($request, [
            'username' => '|unique:users,username',
            'email' => '|unique:users,email',
            'mobile' => '|unique:users,mobile',
            'image'=> '|mimes:jpeg,bmp,png|max:1024'          
        ],['username.unique'=>'username is already registered',
           'email.unique'=>'email is already registered '
           ]);
		   
		DB::transaction(function() use($request){	   
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
            $user->auth_key = str_random(40);
            $user->auth_mobile_key = rand(1111,9999);
            $user->save();
			Session::flash('alert-success', 'user has been added succussfully ..');
		});
		return redirect("/teachers/users/create");
   } 
	
	
   
   public function getEdit($id){
	    $user = User::find($id);
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
       $governments = null;
       if(!empty($user->government)) {
           $country_id = $user->government->country_id;
           $country = Country::find($country_id);
           $governments = $country->governments;
       }
       $mergeUsers = User::where("id","!=",$user->id)->where("id","!=",1)->get();

       foreach(Auth::guard("teachers")->user()->unreadnotifications as $notification){
           if(isset($notification->data['userlogin'])&&$notification->data['userlogin']['id']==$id){
               $notification->markAsRead();
           }
           if(isset($notification->data['userregistered'])&&$notification->data['userregistered']['id']==$id){
               $notification->markAsRead();
           }
       }

	    return view("teachers.users.edit",compact('user','monthsArr','countries',
            'governments','mergeUsers'
        ));
   }
   public function postEdit(Request $request,$id){
   		$this->validate($request, [
            'username' => '|unique:users,username,'.$id,
            'email' => '|unique:users,email,'.$id,
            'mobile' => '|unique:users,mobile,'.$id,
            'image'=> '|mimes:jpeg,bmp,png|max:1024'             
        ],['username.unique'=>'username is already registered',
           'email.unique'=>'email is already registered '
           ]);
   		DB::transaction(function() use($request,$id){
   			$user = User::find($id);	   
		   	$this->SetParameters($user, $request,"edit");
			
			if(Input::hasFile('image')){
		        $image= $request->file('image');
				$imageName=$image->getClientOriginalName();
				if(!empty($user->image)){   //delete old image
					File::delete('uploads/kcfinder/upload/image/users/'. $user->image);
				}
				$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
				$imageName = $rnd.$imageName;
		        $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName ); 
				$user->image = $imageName;  
	        }
            if(Input::hasFile('passport')){
                $image= $request->file('passport');
                $imageName=$image->getClientOriginalName();
                if(!empty($user->passport)){   //delete old image
                    File::delete('uploads/kcfinder/upload/image/users/'. $user->passport);
                }
                $rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
                $imageName = $rnd.$imageName;
                $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );
                $user->passport = $imageName;
            }
            if($request->checkPassword)
				$user->password = bcrypt($request->password);
	       	$user->save();
	       	
			Session::flash('alert-success', 'user has been updated succussfully ..');
		});
		return redirect("/teachers/users/edit/".$id);
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
	 }

	public function getView($id){
		$user = User::findOrFail($id);
		return view("teachers.users.view",array(
			"user"=>$user
		));
	}
   public function postEditfield(Request $request){
   		$name = $request->name;
		$id = $request->pk;
		if($name == "username"){
			$this->validate($request, [
	            'value' => '|unique:users,username,'.$id        
	        ]);
		}else if($name == "email"){
			$this->validate($request, [
	            'value' => 'email|unique:users,email,'.$id           
	        ]);
		}
		$user = User::findOrFail($id);
		$user->$name = $request->value;
		$user->save();
		
   		
  }
   public function postEditimage(Request $request){
   		$id = $request->id;
   		$user = User::findOrFail($id);
		if(Input::hasFile('image')){
	        $image= $request->file('image');
			$imageName=$image->getClientOriginalName();
			if(!empty($user->image)){   //delete old image
				File::delete('uploads/kcfinder/upload/image/users/'. $user->image);
			}
			$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
			$imageName = $rnd.$imageName;
	        $image->move( 'uploads/kcfinder/upload/image/users/' , $imageName ); 
			$user->image = $imageName;  
        } 
		$user->save();
   }
   public function postChangepassword(Request $request){
   		$id = $request->user_id;
		$user = User::findOrFail($id);
		$user->password = bcrypt($request->password);
		$user->save();
		Session::flash('password_updated', 'password has been updated succussfully ..');
		return redirect("/teachers/users/view/".$id);
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
    public function getUniqueMobile(Request $request){
        $id =  $request->id;
        $validator=Validator::make($request->toArray(),
            array(
                'mobile' => '|unique:users,mobile,'.$id,
            ));

        // Finally, return a JSON
        echo json_encode(array(
            'valid' => !$validator->fails(),
        ));
    }
  
   
   public function postDelete($id){
        if($id==1)
            return "error";
		$user = User::findOrFail( $id );
		if(!empty($user->image)){
			File::delete('uploads/kcfinder/upload/image/users/'. $user->image);
		}
		$user->delete();
   }
   
  
  public function postDeleteimaeajax(Request $request){
		
		$data = json_decode(stripslashes( $request->get("data")), true);		
		
		File::delete('uploads/kcfinder/upload/image/users/'. $data[1]);
		
		$user = User::find($data[0]);
		$user->image = Null;
		$user->update();	
		
		return view('teachers.users._images',array('User'=>new User));
       
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
		
		$user = User::find($ID);
		$user->$field=$newsate;
		$user->update();	
	}

    public function getGovernments(Request $request){
        $result = array();

        $countryId = $request->get("countryId");

        $governments = Government::where('country_id',$countryId)->get();

        $result["governments"] = '<option value="">--- Please Select ---</option>';

        if(!$governments->isEmpty()){
            foreach($governments as $government){
                if(isset($government->government_trans(App("lang"))->name))
                    $name = $government->government_trans(App("lang"))->name;
                else {
                    $name = $government->government_trans("en")->name;
                }
                $result["governments"] .= '<option value="'.$government->id.'">'.$name.'</option>';
            }
        }
        return $result;
    }

    public function postMerge(Request $request){
        DB::transaction(function() use($request) {
            $user_ids = (array)$request->user_ids;
            $id = $request->user_id;
            $user = User::findOrFail($id);
            $student = $user->student;
            if (count($user_ids) > 0) {
                foreach ($user_ids as $user_id) {
                    $usersPoints = \App\UserPoint::where("user_id", $user_id)
                        ->get();
                    foreach ($usersPoints as $usersPoint) {
                        $usersPoint->user_id = $user->id;
                        $usersPoint->save();
                    }

                    $couponUsers = \App\CouponUser::where("user_id", $user_id)
                        ->get();
                    foreach ($couponUsers as $couponUser) {
                        $couponUser->user_id = $user->id;
                        $couponUser->save();
                    }

                    $courseQuestions = \App\CourseQuestion::where("user_id", $user_id)
                        ->get();
                    foreach ($courseQuestions as $courseQuestion) {
                        $courseQuestion->user_id = $user->id;
                        $courseQuestion->save();
                    }

                    $courseRatings = \App\CourseRating::where("user_id", $user_id)
                        ->get();
                    foreach ($courseRatings as $courseRating) {
                        $courseRating->user_id = $user->id;
                        $courseRating->save();
                    }

                    $orders = \App\Order::where("user_id", $user_id)
                        ->get();
                    foreach ($orders as $order) {
                        $order->user_id = $user->id;
                        $order->save();

                        foreach($order->orderproducts as $orderproduct){
                            foreach($orderproduct->orderproducts_students as $orderproducts_student){
                                if($orderproducts_student->student_id == $user_id){
                                    $orderproducts_student->student_id = $user->id;
                                    $orderproducts_student->save();
                                }
                            }
                        }

                    }

                    $mergeStudent = \App\Student::find($user_id);
                    if (!empty($mergeStudent)) {
                        $studentCertificates = \App\StudentCertificate::where("student_id", $user_id)
                            ->get();
                        foreach ($studentCertificates as $studentCertificate) {
                            $studentCertificate->student_id = $user->id;
                            $studentCertificate->save();
                        }

                        $studentQuizzes = \App\StudentQuiz::where("student_id", $user_id)
                            ->get();
                        foreach ($studentQuizzes as $studentQuiz) {
                            $studentQuiz->student_id = $user->id;
                            $studentQuiz->save();
                        }

                        $studentVideos = \App\StudentVideoExam::where("student_id", $user_id)
                            ->get();
                        foreach ($studentVideos as $studentVideo) {
                            $studentVideo->student_id = $user->id;
                            $studentVideo->save();
                        }
                        $mergeStudent->delete();
                    }

                    User::find($user_id)->delete();

                }
                $request->session()->flash('alert-success', 'Users Merged Successfully...');
            }else {
                $request->session()->flash('alert-danger', 'no thing to merge...');
            }
        });
        return redirect("/teachers/users/edit/".$request->user_id);
    }

}
