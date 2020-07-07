<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Teacher;
use App\StudentVideoExam;
use App\StudentQuiz;
use App\Student;
use App\Course;
use App\Book;
use App\BookTranslation;
use App\User;
use App\VideoExam;
use App\Quiz;


use File;
use DB;

class studentsexamsController extends Controller
{
    private $table_name = "students-exams";
    private $record_name = "student_exam";

	public function __construct() {

    }
	
    public function index(Request $request){
        $teacher = Auth::guard("teachers")->user()->teacher;

        $student_ids = $teacher->students_ids();
        $students = Student::whereIn("id",$student_ids)->get();

        $course_ids = $teacher->courses_ids();
        $courses = \App\Course::whereIn("id",$course_ids)->get();

      return view('teachers.students-exams.index',array(
          "students"=>$students,"courses"=>$courses,
          "table_name"=>$this->table_name,"record_name"=>$this->record_name
      ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing(Request $request)
    {
        $studentsVideos = StudentVideoExam::search($request);
        $studentExams = StudentQuiz::search($request)
                ->union($studentsVideos)->get();

        return view('admin.students-exams._list', [
            'studentExams' => $studentExams
        ]);
    }

    public function listingAjax(Request $request)
    {
        //for order the table
        $columns = array("","","","","","status","created_at","");
        $teacher = Auth::guard("teachers")->user()->teacher;
        $student_ids = $teacher->students_ids();
        $course_ids = $teacher->courses_ids();

        $recordsTotal = StudentVideoExam::whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids)->count() +
            StudentQuiz::whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids)->count();

        $studentsVideos = StudentVideoExam::search($request)->whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids);
        $studentExams = StudentQuiz::search($request)->whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids);
        $recordsFiltered = $studentExams->count() + $studentsVideos->count();

        $studentExams = $studentExams->union($studentsVideos)
            ->skip($request->start)->take($request->length);

        $order = $request->get("order");
        $column1 = $columns[$order[0]['column']];
        if($column1 !="")
            $studentExams = $studentExams->orderBy($columns[$order[0]['column']],$order[0]['dir']);
        $studentExams = $studentExams->get();

        $data =array();
        foreach($studentExams as $key=>$item){
            $user = User::find($item->student_id);
            $course = Course::find($item->course_id);
            $course_name = $item->course_name;
            if(!empty($course))
                $course_name = $course->course_trans('ar')->name;
            $exam_name = $item->exam_name;
            if($item->type=="video"){
                $exam = VideoExam::find($item->exam_id);
                if(!empty($exam))
                    $exam_name = $exam->videoexam_trans('ar')->name;
            }else{
                $exam = Quiz::find($item->exam_id);
                if(!empty($exam))
                    $exam_name = $exam->quiz_trans('ar')->name;
            }
            $status="";
            if($item->status == "pending" || $item->status == "processing")
                $status='<span class="label label-sm label-info">'.$item->status.'</span>';
            elseif($item->status == "completed")
                $status='<span class="label label-sm label-success">'.$item->status.'</span>';
            else
                $status='<span class="label label-sm label-danger">'.$item->status.'</span>';


            $row = array(
                    $user->username,
                    $user->full_name_ar,
                    $course_name,
                    $exam_name,
                    $item->type,
                    $status,
                    date("Y-m-d",strtotime($item->created_at)),
                    '<a href="'.url("teachers/students-exams/".$item->id."/edit?type=".$item->type).'">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit student exam"></i>
					</a>
                    '
                );
            array_push($data,$row);
        }
        $result = array("recordsTotal"=>$recordsTotal,"recordsFiltered"=>$recordsFiltered,"data"=>array_values($data));
        return json_encode($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $teacher = Auth::guard("teachers")->user()->teacher;
        $student_ids = $teacher->students_ids();
        $course_ids = $teacher->courses_ids();

        $statusData = array("pending"=>"Pending","processing"=>"Processing","completed"=>"Completed","not_completed"=>"Not Completed");

        foreach(Auth::guard("teachers")->user()->unreadnotifications as $notification){
            if(isset($notification->data['exams'])&&$notification->data['exams']['exam_id']==$id){
                $notification->markAsRead();
            }
        }

        if($request->type=="video"){
            $studentVideo = StudentVideoExam::with("student.user")
                ->whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids)
                ->where("id",$id)->firstOrFail();
            if (!empty($request->old())) {
                $studentVideo->fill($request->old());
            }
            $exam_name = $studentVideo->video_exam_name;
            if(!empty($studentVideo->videoexam))
                $exam_name = $studentVideo->videoexam->videoexam_trans('ar')->name;

            return view('teachers.students-exams.edit-video', [
                'studentVideo' => $studentVideo,'exam_name'=>$exam_name,
                'statusData'=>$statusData,
                "table_name"=>$this->table_name,"record_name"=>$this->record_name
            ]);
        }else{
            $studentQuiz = StudentQuiz::with("student.user")
                ->whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids)
                ->where("id",$id)->firstOrFail();
            if (!empty($request->old())) {
                $studentQuiz->fill($request->old());
            }
            $title = "Quiz";
            if($studentQuiz->is_exam)
                $title = "Exam";
            $exam_name = $studentQuiz->quiz_name;
            if(!empty($studentQuiz->quiz))
                $exam_name = $studentQuiz->quiz->quiz_trans('ar')->name;

            return view('teachers.students-exams.edit-quiz', [
                'studentQuiz' => $studentQuiz,'exam_name'=>$exam_name,'title'=>$title,
                'statusData'=>$statusData,
                "table_name"=>$this->table_name,"record_name"=>$this->record_name
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = "";
        if($request->type=="video"){
            $studentVideo = StudentVideoExam::findOrFail($id);
            $studentVideo->fill($request->all());
            if($request->successfull)
                $studentVideo->successfull = 1;
            else
                $studentVideo->successfull = 0;
            $studentVideo->save();
            $message = "Video Exam has been Saved Successfully...";
        }else{
            $studentQuiz = StudentQuiz::findOrFail($id);
            $studentQuiz->status = $request->status;
            if($request->successfull)
                $studentQuiz->successfull = 1;
            else
                $studentQuiz->successfull = 0;
            $studentQuiz->save();
            $message = ucfirst( $request->type )." has been Saved Successfully...";
        }
        $request->session()->flash('alert-success', $message);

        return redirect()->action('Teacher\studentsexamsController@edit',[$id,"type"=>$request->type]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete(Request $request,$id){
        if($request->type=="video"){
            StudentVideoExam::findOrFail($id)->delete();
        }else{
            StudentQuiz::findOrFail($id)->delete();
        }
    }
   


}
