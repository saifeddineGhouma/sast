<?php

namespace App\Http\Controllers\Teacher;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Teacher;
use App\StudentCertificate;

use File;
use DB;

class studentscertificatesController extends Controller
{
    private $table_name = "students-certificates";
    private $record_name = "student_certificate";

	public function __construct() {

    }
	
    public function index(Request $request){
      return view('teachers.students-certificates.index',array(
          "table_name"=>$this->table_name,"record_name"=>$this->record_name
      ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listingAjax(Request $request)
    {
        $teacher = Auth::guard("teachers")->user()->teacher;
        $student_ids = $teacher->students_ids();
        $course_ids = $teacher->courses_ids();

        $parts = parse_url($request->extra);
        parse_str($parts['path'], $request1);

        $recordsTotal = StudentCertificate::whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids)
            ->where("manual",$request1['manual'])->count();

        $studentsCertificates = StudentCertificate::search($request)->where("manual",$request1['manual'])
                ->whereIn("student_id",$student_ids)->whereIn("course_id",$course_ids);
        $recordsFiltered = $studentsCertificates->count();

        $studentsCertificates = $studentsCertificates->skip($request->start)
                    ->take($request->length)->get();

        $data =array();
        foreach($studentsCertificates as $key=>$item){
            $course_name = $item->course_name;
            if(!is_null($item->course))
                $course_name = $item->course->course_trans('ar')->name;
            $exam_name = $item->exam_name;
            if(!is_null($item->exam))
                $exam_name = $item->exam->quiz_trans('ar')->name;
            $student_name = '';
            if(!is_null($item->student))
                $student_name = $item->student->user->full_name_ar;

            $image = '<a href="'. asset('uploads/kcfinder/upload/image/'.$item->image) .'" target="_blank">
                        <img src="'.asset('uploads/kcfinder/upload/image/'.$item->image).'" alt="no image" width="70px"/></a>';
            if($request1['manual']){
                $row = array(
                    '<input type="checkbox" class="checkbox" data-id="'.$item->id.'">',
                    $image,
                    $student_name,
                    $course_name,
                    $item->serialnumber,
                    $item->getStatus($item->active,$item->id) ,
                    date("Y-m-d",strtotime($item->created_at))
                );
            }else{
                $row = array(
                    '<input type="checkbox" class="checkbox" data-id="'.$item->id.'">',
                    $image,
                    $student_name,
                    $course_name,
                    $exam_name,
                    $item->serialnumber,
                    date("Y-m-d",strtotime($item->created_at))
                );
            }
            array_push($data,$row);
        }
        $result = array("recordsTotal"=>$recordsTotal,"recordsFiltered"=>$recordsFiltered,"data"=>array_values($data));
        return json_encode($result);
    }


}
