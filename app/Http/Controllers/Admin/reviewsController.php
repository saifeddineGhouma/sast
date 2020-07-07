<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Admin;
use App\CourseRating;
use App\User;
use App\Course;

use App\AdminHistory;
use DB;

class reviewsController extends Controller
{
	public function __construct() {
		
    }
	
    public function getIndex(){
	  $users = User::get();
	  $courses = Course::get();

    foreach(Auth::guard("admins")->user()->unreadnotifications as $notification){
        if(isset($notification->data['userreview'])){
            $notification->markAsRead();
        }
    }

      return view('admin.reviews.index',array(
      		"users"=>$users,"courses"=>$courses
		));
    }
   
	
	public function reply(Request $request){
		$id=$request->id;
		return view('admin.reviews.create',array(
      		"id"=>$id
		));
	}
	public function createreply(Request $request){
		//echo $request->comment;
		DB::table('comment_raiting')->insert(
			['rating_id' => $request->rating_id, 'comment' => $request->comment, 'type' => 1, 'user_id' => Auth::guard("admins")->user()->id, 'date_create' => date('Y-m-d H:i:s')]
		);
		return view('admin.reviews.create',array(
      		"id"=>$request->rating_id
		));
	}
   
	
	public function getSearchresults(Request $request)
    {
    	$course_id = $request->course_id;
		$created_at = $request->created_at;
		$user_id = $request->user_id;
		$status = $request->status;
		
    	$reviews = CourseRating::join("courses","course_rating.course_id","=","courses.id");
		
		if($status!="")
			$reviews = $reviews->where("course_rating.approved",$status);
		
		if($created_at != ""){
			$created_at =  date("y-m-d",strtotime($created_at));
			$reviews = $reviews->where(DB::raw("DATE(created_at)"),$created_at);
		}
		if($course_id != "0")
			$reviews = $reviews->where('course_rating.course_id',$course_id);
		
		if($user_id != "0"){
			$reviews = $reviews->where('course_rating.user_id',$user_id);
		}
		$reviews = $reviews->get(["course_rating.*"]);
        
		return view('admin.reviews._search_results',	array(
        			'reviews'=>$reviews
		)); 
		
    }
	
   
   public function postDelete($id){
		$review = CourseRating::findOrFail( $id );
		
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete Reviews: ".$review->comment; 
		$adminhistory->save(); 
				
		$review->delete();
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
		
		$courseRating = CourseRating::find($ID);
        $courseRating->$field=$newsate;
        $courseRating->update();
	}

}
