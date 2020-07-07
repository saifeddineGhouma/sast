<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\CourseQuestion;
use App\User;
use App\Student;
use App\Course;

use App\AdminHistory;
use DB;

class forumController extends Controller
{
	public function __construct() {
		
    }
	
    public function getIndex(){
	  $users = User::orderBy("created_at","desc")->get();
	  $courses = Course::get();

      return view('admin.forum.index',array(
      		"users"=>$users,"courses"=>$courses
		));
    }
   
	
	public function getSearchresults(Request $request)
    {
		$created_at = $request->created_at;
		$user_id = $request->user_id;
		$course_id = $request->course_id;

    	$courseQuestions = CourseQuestion::whereNull("parent_id");

		if($course_id != "0"){
            $courseQuestions = $courseQuestions->where('course_id',$course_id);
		}
        if($user_id != "0")
            $courseQuestions = $courseQuestions->where('user_id',$user_id);
		if($created_at != ""){
			$created_at =  date("y-m-d",strtotime($created_at));
            $courseQuestions = $courseQuestions->where(DB::raw("DATE(created_at)"),$created_at);
		}
        $courseQuestions = $courseQuestions->distinct()->get(["course_questions.*"]);
		
        
		$view =  view('admin.forum._search_results',	array(
        			'courseQuestions'=>$courseQuestions
		));
		
		$result = array();
		$result[0] = str_replace('"', '\"', $view);
		
		return json_encode($result);
		
    }
   
   public function getEdit($id){
        $courseQuestion = CourseQuestion::findOrFail($id);
		foreach(Auth::guard("admins")->user()->unreadnotifications as $notification){
           if(isset($notification->data['userforum'])&&$notification->data['userforum']['id']==$id){
               $notification->markAsRead();
           }
		}

	    return view("admin.forum.edit",array(
	    	'courseQuestion'=>$courseQuestion
		));
		
   }
   public function postEdit(Request $request,$id){
       $courseQuestion = CourseQuestion::find($id);
       $courseQuestion->discussion = $request->discussion;
       if($request->active)
           $courseQuestion->active = 1;
       else
           $courseQuestion->active = 0;
       $courseQuestion->save();
       $this->saveReplies($request,$courseQuestion);
	   
		
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Update Forum: ".$courseQuestion->discussion; 
		$adminhistory->save(); 

		Session::flash('alert-success', 'Forum has been updated succussfully ..');
		return redirect("admin/forum/edit/".$id);
   }

    public function saveReplies($request,$courseQuestion){

        //*********** update current replies***********
        foreach($courseQuestion->replies as $reply){
            if($request->get("reply_discussion_".$reply->id)){
                $reply->discussion = $request->get("reply_discussion_".$reply->id);
                if($request->get("reply_active_".$reply->id))
                    $reply->active = 1;
                else
                    $reply->active = 0;
                $reply->update();
            }else{
                $reply->delete();
            }
        }

        //***********Insert new replies****************
        $replies = $request->get("replies");
        if(!empty($replies)){
            foreach($replies as $reply){
                $courseQuestionTmp = new CourseQuestion();
                $courseQuestionTmp->course_id = $courseQuestion->course_id;
                $courseQuestionTmp->parent_id = $courseQuestion->id;
                $courseQuestionTmp->discussion = $reply["discussion"];
                $courseQuestionTmp->admin_id = $reply["client_id"];
                if($reply["active"])
                    $courseQuestionTmp->active = 1;
                else
                    $courseQuestionTmp->active = 0;
                $courseQuestionTmp->save();
            }
        }
    }

   
   public function postDelete($id){
       $courseQuestion = CourseQuestion::findOrFail( $id );
       $courseQuestion->delete();
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

        $courseQuestion = CourseQuestion::find($ID);
        $courseQuestion->$field=$newsate;
        $courseQuestion->update();
    }
	
	


}
