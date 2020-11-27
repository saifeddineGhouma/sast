<?php

namespace App\Http\Controllers\Admin;

use App\CourseSpecial ;
use App\StudentVideoExam;
use App\StudentQuiz;
use App\Student;
use App\Course;
use App\Book;
use App\BookTranslation;
use App\User;
use App\VideoExam;
use App\Quiz;
use App\CasExamPratique;
use App\UserCasExamPratique;
use App\CourseTypeVariation;
use App\StudentCertificate;
use App\AdminHistory;
use App\StudentStage ;
use App\Admin ;
use App\StudentStudyCase ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

include "assets/I18N/Arabic.php";

use I18N_Arabic;

use File;
use DB;

class CourseSpecialController extends Controller
{
	 private $table_name = "Course Special";
    private $record_name = "Course Special";
	    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $students = Student::orderBy("id", "desc")->get();
        $courses = Course::get();
       


        return view('admin.valid_in_courses_special.index', array(
            "students" => $students, "courses" => $courses,
            "table_name" => $this->table_name, "record_name" => $this->record_name
        ));
    }

     public function listing(Request $request)
    {
        $courses_special = CourseSpecial::search($request)->latest()->get();
        return view('admin.valid_in_courses_special.list',compact('courses_special'));

    }

    public function edit( $courses_special_id)
    {
      $courses_special= CourseSpecial::find($courses_special_id);
        return view('admin.valid_in_courses_special.edit',array(
            "courses_special" => $courses_special,
            "table_name" => $this->table_name, "record_name" => $this->record_name
        ));
    }

    public function Update($courses_special_id,Request $request)
    {


        $course_special = CourseSpecial::find($courses_special_id) ;


            if(!empty($course_special))
            {
                $course_special->status = $request->status ;
                $course_special->update();

                $student = $course_special->student ;
                $course = $course_special->course ;
                $courseTypeVariation = $student->order_products()->where('course_id', $course->id)->first()->coursetype_variation()->first();
                
                 $existCertif     = StudentCertificate::where('student_id', $student->id)->where('course_id', $course->id)->count();
                 
                 if ($course->isCompleteQuizzes($student))  {   
             
                if ($course_special->status == "success") {


                    $courseTypeVariation = $student->order_products()->where('course_id', $course->id)->first()->coursetype_variation()->first();
                   
                    $existCertif         = StudentCertificate::where('student_id', $student->id)->where('course_id', $course->id)->count();

                    $Arabic = new I18N_Arabic('Glyphs');
                    //Create certif 
                    $certificate = $courseTypeVariation->certificate;

                    if (!empty($certificate)) {

                        
                        $serialNumber = "";
                        $image_name = "";
                       
                        if ($existCertif == 0) {
                            $certificate->export($student, $Arabic, $serialNumber, $image_name, date("Y-m-d"));
                        }
                   

                        if ($serialNumber != "") {
                           
                            $studentCertificate = new StudentCertificate();
                            $studentCertificate->student_id = $student->id;
                            // new code 
                            $studentCertificate->course_id = $course->id;
                            // old code 
                           // $studentCertificate->course_id = $courseTypeVariation->courseType->course_id;
                            $studentCertificate->course_name = $courseTypeVariation->courseType->course->course_trans("ar")->name;

                            $quiz = $course->finalExam()->first();
                            if (!empty($quiz)) {
                                $studentCertificate->exam_id = 302;
                                $studentCertificate->exam_name = $quiz->quiz_trans("ar")->name;
                            }
                            $teacherName = "";
                            $teacherName = $courseTypeVariation->teacher->user->full_name_en;
                            $studentCertificate->teacher_name = $teacherName;

                            $studentCertificate->serialnumber = $serialNumber;
                            $studentCertificate->image = $image_name;
                            $studentCertificate->date = date("Y-m-d");
                            $studentCertificate->manual = 0;
                            $studentCertificate->save();

                            $mime_boundary = "----MSA Shipping----" . md5(time());
                            $subject = "Swedish Academy : Certificate";
                            $headers = "From:Swedish Academy<info@swedish-academy.se> \n";
                            $headers .= "MIME-Version: 1.0\n";
                            $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
                            $message1 = "--$mime_boundary\n";
                            $message1 .= "Content-Type: text/html; charset=UTF-8\n";
                            $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
                            $message1 .= "<html>\n";
                            $message1 .= "<body>";
                            $message1 .= "<table width='602'>";
                            $message1 .= "<tr>";
                            $message1 .= "<td>";
                            $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'><br>";
                            $message1 .= "</td>";
                            $message1 .= "</tr>";
                            $message1 .= "<tr>";
                            $message1 .= "<td align='right'>";
                            $message1 .= "مرحبا بكم
                                تعلمكم الاكاديمية السويدية للتدريب الرياضي أنكم أتممتم الدورة بنجاح و نحن نتمنى لكم الموفقية في حياتكم العملية.
                                و تجدون شهادتكم  في حسابكم  في قسم الشهادات من خلال هذا الرابط
                                <a href='https://swedish-academy.se/account/certificates'>الشهائد</a>
                                <br> 
                                و قد أرفقنا لكم الشهادة 
                                <a href='https://swedish-academy.se/uploads/kcfinder/upload/image/" . $studentCertificate->image . "'>انقر هنا</a><br>
                                <br>
                                مع تمنياتنا لكم بالنجاح و التوفيق في قادم الأيام";
                            $message1 .= "</td>";
                            $message1 .= "</tr>";
                            $message1 .= '</table>';
                            $message1 .= '</body>';
                            $message1 .= '</html>';
                            if(!$course->isTotalyPaid())
                               mail($student->user->email, $subject, $message1, $headers);
                        }
                    }
                }
            }



            }
             $request->session()->flash('alert-success', "student in course special has been edit");



       return back() ;

    }
       

       public function delete($id)
       {

          $course_special = CourseSpecial::find($id);
          if(!empty($course_special))
           {
            $course_special->delete();
            return response()->json(['message'=>'success']);
           } 
            return response()->json(['message'=>'failed']);


       }



  }