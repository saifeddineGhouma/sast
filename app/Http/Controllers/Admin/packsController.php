<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\CourseQuestion;
use App\OrderProduct;
use App\StudentCertificate;
use App\StudentQuiz;
use App\StudentVideoExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Course;
use App\CourseTranslation;
use App\Category;
use App\CourseType;
use App\Teacher;
use App\Country;
use App\Government;
use App\CourseTypeVariation;
use App\CourseDiscount;
use App\CourseStudy;
use App\VideoExam;
use App\Quiz;
use App\CourseQuiz;
use App\CourseVideoExam;
use App\Certificate;
use App\User;
use App\Student;
use App\OrderproductStudent;
use App\Order;
use App\OrderOnlinepayment;
use App\UserPoint;

use App\Notifications\OrderCreated;
use Notification;

use App\AdminHistory;
use App\Packs;
use App\Courses;
use DB;
use Excel;
use File;

class packsController extends Controller
{
    private $table_name = "packs";
    private $record_name = "packs";

    public function __construct() {

    }
    
    public function getIndex(){
		$packs = packs::get();
		$courses = Course::get();

		return view('admin.packs.index',[
			"packs"=>$packs,
			"courses"=>$courses
		]);
    }
   
	public function getCreate(){
		
		$courses = Course::get();
		
    	return view('admin.packs.create',[
			"courses"=>$courses
		]);
    }
	
	
	public function postCreate(Request $request){
		DB::transaction(function() use($request){
			$packs = new Packs();
			$packs->titre = $request->title;
			$packs->cours_id1 = $request->course_id1;		   
			$packs->cours_id2 = $request->course_id2;
			$packs->prix = $request->price;
			$packs->description = $request->ar_content;
			$packs->lang = $request->lang;
			if(Input::hasFile('image')){
		        $image= $request->file('image');
				$imageName=$image->getClientOriginalName();
				
				$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
				$imageName = $rnd.$imageName;
		        $image->move( 'uploads/kcfinder/upload/image/packs/' , $imageName ); 
				$packs->image = $imageName;  
	        }
			$packs->save();
		   
			Session::flash('alert-success', 'Pack Created Successfully...');
		});
		return redirect("/admin/packs/create");
   }
	public function getedit($id){
		$packs=packs::where("id",$id)->firstOrFail();
		$courses = Course::get();
			
	    return view('admin.packs.edit',[
	        "packs"=>$packs,
			"courses"=>$courses
		]);
   }
   public function postedit(Request $request,$id){
   		
		DB::transaction(function() use($request,$id){
   			$packs = Packs::find($id); 
			$packs->titre = $request->title;
			$packs->cours_id1 = $request->course_id1;		   
			$packs->cours_id2 = $request->course_id2;
			$packs->prix = $request->price;
			$packs->description = $request->ar_content;
			$packs->lang = $request->lang;
			if(Input::hasFile('image')){
		        $image= $request->file('image');
				$imageName=$image->getClientOriginalName();
				
				$rnd = strtotime(date('Y-m-d H:i:s'));  // generate random number between 0-9999
				$imageName = $rnd.$imageName;
		        $image->move( 'uploads/kcfinder/upload/image/packs/' , $imageName ); 
				$packs->image = $imageName;  
	        }
			$packs->save();
			
			Session::flash('alert-success', 'packs Updated Successfully...');
		});
		return redirect("admin/packs/edit/".$id);
   }
    public function postDeleteimaeajax(Request $request){
		
		$data = json_decode(stripslashes( $request->get("data")), true);		
		
		File::delete('uploads/kcfinder/upload/image/packs/'. $data[1]);
		
		$user = User::find($data[0]);
		$user->image = Null;
		$user->update();	
		
		return view('admin.packs._images',array('User'=>new User));
       
	}
	
	 public function postDelete($id){
		$packs = Packs::findOrFail( $id );
		$packs->delete();
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete Packs"; 
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

        $packs = Packs::find($ID);
        $packs->$field=$newsate;
        $packs->update();
    }

}
