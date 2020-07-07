<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Teacher;
use App\CourseTypeVariation;

use File;
use DB;
use SoapClient;

class coursesController extends Controller
{

   public function index(){
	   	$teacher = Auth::guard("teachers")->user()->teacher;
	   	$courseTypeVariations = CourseTypeVariation::where("teacher_id",$teacher->id)->get();
		
	    return view("teachers.courses.index",compact('teacher','courseTypeVariations'));
   }

   public function view($id){
       $teacher = Auth::guard("teachers")->user()->teacher;

       $courseTypeVariation = CourseTypeVariation::where("teacher_id",$teacher->id)->where("id",$id)->firstOrFail();
       $course = $courseTypeVariation->courseType->course;
       return view("teachers.courses.view",compact('teacher','courseTypeVariation','course'));
   }

}
