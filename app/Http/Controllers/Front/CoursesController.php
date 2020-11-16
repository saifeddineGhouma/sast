<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Notifications\SuccessExam;
use Illuminate\Http\Request;

use App\Course;
use App\CourseType;
use App\CourseTypeVariation;
use App\CourseView;
use App\CourseRating;
use App\CourseStudy;
use App\CourseQuestion;
use App\Quiz;
use App\StudentQuiz;
use App\Question;
use App\StudentQuizAnswer;
use App\StudentVideoExam;
use App\StudentCertificate;
use App\VideoExam;
use App\Order;
use App\Comment;
use App\CasExamPratique;
use App\UserCasExamPratique;
use App\Notifications\UserForum;
use App\Notifications\UserReview;
use App\Notifications\ExamFinished;
use Notification;
use App\Log;
use App\Sujet;
use App\StudentStudyCase;

use App\Notifications\UserQuiz;

include "assets/I18N/Arabic.php";

use I18N_Arabic;

use Auth;
use DB;
use Session;

class CoursesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => array(
            "postSaveReply", "quizAttemp", "postSubmitQuiz", "videoExam",
            "postSaveCourseReview", "quizResult", "postSubmitVideo"
        )]);
    }

    public function getView($courseType_id)
    {
		$courseType = CourseType::findOrFail($courseType_id);

        $sujetsUse = StudentStudyCase::where('courses_id', $courseType->course->id)->pluck('sujets_id');

        $sujet = Sujet::orderByRaw("RAND()")->first();
        
        $courseType = CourseType::findOrFail($courseType_id);
        $course     = $courseType->course;
            $passed = 0;
            $lang   = 'Ar' ;
		
        if (Auth::check()) {
            $student = Auth::user()->student;
            $lang    = $course->is_lang ? Auth::user()->lang() : 'Ar';
            $passed = StudentStudyCase::where('courses_id', $course->id)->where('students_id', Auth::id())->where('document','!=','')->count();
            $sujet = Sujet::orderByRaw("RAND()")->where('lang',Auth::user()->lang())->first();

        } 
		
		
       
        $topCourseTypes = CourseType::join("courses", "courses.id", "=", "course_types.course_id")
            ->join("order_products", "order_products.course_id", "=", "courses.id")
            ->join("orders", "orders.id", "=", "order_products.order_id")
            ->where("courses.active", 1)
            ->where(function ($query) {
                $query->whereHas('couseType_variations', function ($query1) {
                    $query1->where('course_types.type', '=', 'online');
                })->orWhereHas('couseType_variations', function ($query1) {
                    $now = date("Y-m-d");
                    $query1->where('course_types.type', '=', 'classroom')
                        ->where('coursetype_variations.date_from', '>=', $now);
                });
            })->select(
                DB::raw('sum(orders.id) as countOrders'),
                "course_types.id",
                "course_types.course_id",
                "course_types.type",
                "course_types.online_exam_period",
                "course_types.points"
            )
            ->groupBy(
                "course_types.id",
                "course_types.course_id",
                "course_types.type",
                "course_types.online_exam_period",
                "course_types.points"
            )->orderBy("countOrders", "desc")
            ->take(4)->get(["course_types.*"]);


        $courseQuestions = CourseQuestion::whereNull("parent_id")
            ->where("course_id", $courseType->course_id)->where("active", 1)->get();
        
        $quizzes = 
        $exams=($course->is_lang) ? $course->quizzes()->Langue($lang)->where("is_exam", 0)->where("active", 1)->get() : $course->quizzes()->where("is_exam", 0)->where("active", 1)->get();
        $exams   = $course->quizzes()->Langue($lang)->where("is_exam", 1)->where("active", 1)->get();
        $videoExams = $course->videoexams()->where("active", 1)->get();
        $user    = Auth::user();

  
        //classroom id 292

        $courseTT = CourseType::whereIn('id', [292, 298,328])->get();
		
        foreach ($courseTT as $courseT) {
            $courseTest = $courseT->course;
			/// liste quiz arbie 
           // $quizzesTest = $courseTest->quizzes()->whereIn('quizzes.id', [312, 366, 367, 368, 369, 370])->where("is_exam", 0)->where("active", 1)->get();
			// liste quiz francais 
         //   $quizzesTestFr = $courseTest->quizzes()->whereIn('quizzes.id', [328, 329, 330, 331, 332])->where("is_exam", 0)->where("active", 1)->get();
			
			
            $examsTest = $courseTest->quizzes()->where("is_exam", 1)->where("active", 1)->get();
        }

        $isRegistered = $course->isRegistered();

        //$this->views($courseType->course->id);
          if(Auth::check())
          {
            $isStudy=StudentStudyCase::where('students_id',Auth::id())->where('courses_id',$course->id)->get();
            if(!empty($course->courses_study_case->active) && empty($isStudy))
            {
                        
                  $studentstudycase= new StudentStudyCase();
                  $studentstudycase->students_id=Auth::id();
                  $studentstudycase->sujets_id=$sujet->id ;
                  $studentstudycase->courses_id = $course->id ;
                  $studentstudycase->save();  
                  $sujet=Sujet::where('id',$studentstudycase->sujets_id)->first();
            } 
            else
            {
				if(!empty($user->studycase))
				{
					$sujet_id= $user->studycase()->where('courses_id',$course->id)->pluck('sujets_id')->first() ;
                  $sujet=Sujet::where('id', $sujet_id)->first();
				}
            }

            
          }
           

        $comment = Comment::get();
		
        return view("front.courses.view", array(
            "courseType" => $courseType, "topCourseTypes" => $topCourseTypes,
            "course" => $courseType->course, "courseQuestions" => $courseQuestions,
            "quizzes" => $quizzes, "exams" => $exams, "videoExams" => $videoExams,
            "user" => $user, "isRegistered" => $isRegistered, "comment" => $comment, 
            "examsTest" => $examsTest, 
			"sujet" => $sujet, "passed" => $passed
        ));
    }
    public function submitgetsujet(Request $request)
    {
        $student = Auth::user()->student;
        $studentstudycase = new StudentStudyCase();
        $studentstudycase->sujets_id = $request->sujets_id;
        $studentstudycase->courses_id = $request->courses_id;

        $studentstudycase->students_id = $student->id;

        $studentstudycase->save();

        $sujet = Sujet::where('id', $studentstudycase->sujets_id)->first();
        return  $sujet->description;
    }
    private function uploadFile($fichie, $name)
    {
        $file = $fichie;

        $destinationPath = 'uploads/kcfinder/upload/image/studyCase';

        $file->move($destinationPath, $name . '_' . $file->getClientOriginalName());
        return  $file->getClientOriginalName();
    }
    public function postStudyCase(Request $request)
    {
        $this->validate($request, [
            'document' => 'required'
        ]);
        $student = Auth::user()->student;
        if ($student->id != null) {
                         
            $studentstudycase =  StudentStudyCase::where('students_id', Auth::id())->where('courses_id', $request->courses_id)->first();
                 
            $studentstudycase->user_message = $request->user_message;

            $name = Auth::user()->username;

            $document =  $this->uploadFile($request->file('document'), $name . '_' . $request->courses_id);

            $studentstudycase->document = $name . '_' . $request->courses_id . '_' . $document;
           
            $studentstudycase->save();

            $user = Auth::user();
            $admins = \App\Admin::get();

            Session::flash('message', 'تم إنشاء الإختبار بنجاح...');
            return back();
            
        } else {
            abort(404);
        }
    }
    public function quizAttempt(Request $request)
    {

		
        $this->middleware("auth");
        if (Auth::guest()) {
			
            abort(404);
			
        }
        $ip = $_SERVER['REMOTE_ADDR'];

        /*if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }*/


        $courseType = CourseType::findOrFail($request->coursetype_id);
        $course = $courseType->course;



        $quiz = $course->quizzes()->where("active", 1)
            ->where("quizzes.id", $request->quiz_id)->firstOrFail();
        $type = "quiz";
        if ($quiz->is_exam)
            $type = "exam";
        /*if($courseType->type=="classroom"&&$type=="exam"){
            abort(404);
        }*/

        $messageValid = "";
    
        $validQuiz = $course->validateQuiz($type, $messageValid);
			
   
        $validAttempts = true;
        if ($type == "exam")
            $validAttempts = $course->validQuizAttempts($quiz);

        $student = Auth::user()->student;
        $user = Auth::user();
        if (empty($student)) {
			
            abort(404);
        }
        $finished = false;
        $expired = $quiz->isExpired($course);
        $countFinal = $student->student_quizzes()->where("course_id", $course->id)
            ->where("is_exam", 1)->where("successfull", 1)->groupBy("quiz_id")->count();
        if ($countFinal >= $course->quizzes()->where("is_exam", 1)->where("active", 1)->count()) {
            $finished = true;
        }
        if ($expired && !$finished) {
            session()->flash("alert-danger", "لا يمكن أداء هذا الاختبار بسبب انتهاء المدة المسموح بها لأداء الاختبار");
            return redirect()->back();
        }
        if (!$validAttempts) {
            session()->flash("alert-danger", "لا يمكن أداء هذا الاختبار بسبب تجاوز العدد المسموح لأداء الاختبار");
            return redirect()->back();
        }
        if ($quiz->is_exam) {
            $lang    = $course->is_lang ? Auth::user()->lang() : 'Ar';
            $questions = Question::whereHas("quiz.courses_exams", function ($query) use ($course) {
                $query->where('courses_quizzes.course_id', $course->id);
            })->whereHas('quiz', function ($query1) use ($lang) {$query1->where('quizzes.lang', $lang);})->inRandomOrder()->take($quiz->num_questions)->get();
        } else
            $questions = $quiz->questions()->inRandomOrder()->take($quiz->num_questions)->get();

        $finalMark = 0;
        foreach ($questions as $question) {
            $finalMark += $question->points;
        }

        if ($validQuiz && !empty($student)) {

            $startTime = date("Y-m-d H:i:s");
            $stopTime = date("Y-m-d H:i:s", strtotime("+" . $quiz->duration . " minutes"));
            $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)->where("course_id", $course->id)
                ->where("startime", "<=", $startTime)->where("stoptime", ">", $startTime)
                ->where("status", "pending")->first();
            if (!empty($studentQuiz)) {
                if (!empty($studentQuiz->ip) && $studentQuiz->ip != $ip) {
                    session()->flash("alert-danger", "لا يمكن أداء هذا الاختبار لدخول الاختبار من أكثر من جهاز");
                    return redirect()->back();
                }
                $startTime = $studentQuiz->startime;
                $stopTime = $studentQuiz->stoptime;
            } else {
                $studentQuiz = $student->student_quizzes()->where("token", $request->token)->first();
                if(empty($studentQuiz)){
                    $studentQuiz = new StudentQuiz();
                    $studentQuiz->student_id = $student->id;
                    $studentQuiz->quiz_id = $quiz->id;
                    $studentQuiz->course_id = $course->id;
                    $studentQuiz->quiz_name = $quiz->quiz_trans("ar")->name;
                    $studentQuiz->course_name = $course->course_trans("ar")->name;
                    $studentQuiz->ip = $ip;
                    $studentQuiz->is_exam = $quiz->is_exam;
                    $studentQuiz->status = "pending";
                    $studentQuiz->startime = $startTime;
                    $studentQuiz->stoptime = $stopTime;
                    $studentQuiz->final_mark = $finalMark;
                    $studentQuiz->successfull = 0;
    				$studentQuiz->token    = $request->token;
                    $studentQuiz->save();
                }else{
                    session()->flash("alert-danger", "لقد قمت بالإجابة على الأسئلة سابقا");
                    return redirect()->back();
                }
            }
            $studentquiz_answers = $studentQuiz->answers;
            $seconds = Quiz::datediff('s', date("Y-m-d H:i:s"), $stopTime, false);

            //echo $seconds."<br>";

            //echo $stopTime;



            return view("front.courses.quiz", [
                "quiz" => $quiz, "course" => $course, "seconds" => $seconds,
                "questions" => $questions, "studentquiz_answers" => $studentquiz_answers,
                "studentQuiz" => $studentQuiz
            ]);
        }
	
        abort(404);
    }

    public function postSubmitQuiz($studentQuiz_id, Request $request)
    {

        $data = array();
        $data["message"] = "";
        $data["solved"] = "";
        $data["rest"] = "";
        $student = Auth::user()->student;
        $studentQuizTmp = StudentQuiz::findOrFail($studentQuiz_id);
        $questions = $request->get("questions");

        if (!empty($student)) {

            if($studentQuizTmp->status == 'completed' or $studentQuizTmp->status == 'not_completed'){
                session()->flash("alert-danger", "لقد قمت بالإجابة على الأسئلة سابقا");
                return redirect(App('urlLang') . 'courses/quiz-result?studentQuiz_id=' . $studentQuizTmp->id);
            }

            $currentTime = date("Y-m-d H:i:s", strtotime("-5 seconds"));

            $studentQuiz = $student->student_quizzes()->where("token", $request->token)->first();
            $studentQuiz = $student->student_quizzes()->where("students_quizzes.id", $studentQuiz_id)
                ->where("startime", "<=", $currentTime)->where("stoptime", ">", $currentTime)
                ->where("status", "!=", "not_completed")->first();

            if (!empty($studentQuiz)) {

                $totalPoints = 0;
                if (!empty($questions)) {

                    foreach ($questions as $key => $answerQuestion) {
                        $question = Question::findOrFail($key);
                        $answer = null;

                        if ($answerQuestion != "")
                            $answer = $question->answers()->where("answers.id", $answerQuestion)->first();
                        $correctAnswer = $question->answers()->where("is_correct", 1)->firstOrFail();
                        $studentQuizAnswer = $studentQuiz->answers()->where("question", "=", $question->question_trans('ar')->question)
                            ->first();
                        if (empty($studentQuizAnswer))
                            $studentQuizAnswer = new StudentQuizAnswer();
                        $studentQuizAnswer->studentquiz_id = $studentQuiz->id;
                        $studentQuizAnswer->question = $question->question_trans('ar')->question;

                        if (!empty($answer))
                            $studentQuizAnswer->given_answer = $answer->name_ar;
                        $studentQuizAnswer->correct_answer = $correctAnswer->name_ar;
                        if ($studentQuizAnswer->given_answer == $studentQuizAnswer->correct_answer) {
                            $totalPoints += $question->points;
                            $studentQuizAnswer->correct = 1;
                        } else {
                            $studentQuizAnswer->correct = 0;
                        }
                        $studentQuizAnswer->save();
                    }
                }

                $studentQuiz->result = $totalPoints;
                if ($studentQuiz->quiz->pass_mark <= $totalPoints) {
                    $studentQuiz->status = "completed";
                    $studentQuiz->successfull = 1;
                } else {
                    $studentQuiz->successfull = 0;
                    $studentQuiz->status = "not_completed";
                }

                if (!$request->ajax()) {
                    $studentQuiz->stoptime = date("Y-m-d H:i:s");
                }

                $studentQuiz->save();

                $user = Auth::user();
                $admins = \App\Admin::get();
                //Notification::send($admins, new ExamFinished($user->username,$studentQuiz->id,"quiz",$studentQuiz->quiz_name));
                if ($studentQuiz->successfull)
                {
                   // $user->notify(new SuccessExam($user->username, $studentQuiz->quiz_name));
                }
            } else {

                $currentTime = date("Y-m-d H:i:s");
                //echo $currentTime;
                $studentQuiz = $student->student_quizzes()->where("students_quizzes.id", $studentQuiz_id)->first();

                //print_r($studentQuiz);
                //die();

                $totalPoints = 0;
                if (!empty($questions)) {

                    foreach ($questions as $key => $answerQuestion) {
                        $question = Question::findOrFail($key);
                        $answer = null;

                        if ($answerQuestion != "")
                            $answer = $question->answers()->where("answers.id", $answerQuestion)->first();
                        $correctAnswer = $question->answers()->where("is_correct", 1)->firstOrFail();
                        $studentQuizAnswer = $studentQuiz->answers()->where("question", "=", $question->question_trans('ar')->question)
                            ->first();
                        if (empty($studentQuizAnswer))
                            $studentQuizAnswer = new StudentQuizAnswer();
                        $studentQuizAnswer->studentquiz_id = $studentQuiz->id;
                        $studentQuizAnswer->question = $question->question_trans('ar')->question;

                        if (!empty($answer))
                            $studentQuizAnswer->given_answer = $answer->name_ar;
                        $studentQuizAnswer->correct_answer = $correctAnswer->name_ar;
                        if ($studentQuizAnswer->given_answer == $studentQuizAnswer->correct_answer) {
                            $totalPoints += $question->points;
                            $studentQuizAnswer->correct = 1;
                        } else {
                            $studentQuizAnswer->correct = 0;
                        }
                        $studentQuizAnswer->save();
                    }
                }

                $studentQuiz->result = $totalPoints;
                if ($studentQuiz->quiz->pass_mark <= $totalPoints) {
                    $studentQuiz->status = "completed";
                    $studentQuiz->successfull = 1;
                } else {
                    $studentQuiz->successfull = 0;
                    $studentQuiz->status = "not_completed";
                }

                if (!$request->ajax()) {
                    $studentQuiz->stoptime = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                }

                $studentQuiz->save();

                $user = Auth::user();
                $admins = \App\Admin::get();
                //Notification::send($admins, new ExamFinished($user->username,$studentQuiz->id,"quiz",$studentQuiz->quiz_name));
                if ($studentQuiz->successfull)
                    //$user->notify(new SuccessExam($user->username, $studentQuiz->quiz_name));
                $data["message"] = "expired";
            }

        } else {
            abort(404);
        }

        $data["solved"] = $studentQuizTmp->answers()->count();
        $data["rest"] = $studentQuizTmp->quiz->num_questions - $data["solved"];


        if ($request->ajax()) {
             
            return json_encode($data);
        } else {
            $isExport = false;
            $course = $studentQuizTmp->course;
            if (!empty($course)) {
                $finalExams = $course->quizzes()->where("active", 1)->where("is_exam", 1)->get();
                $countExams = $finalExams->count();
                $counter = 0;
                foreach ($finalExams as $finalExam) {
                    $studentExam = $student->student_quizzes()->where("students_quizzes.quiz_id", $finalExam->id)->where("course_id", $course->id)
                        ->where("status", "completed")->first();

                    /* new code */
                    if (!empty($studentExam) && $studentExam->successfull) {
                        $counter++;
                    }
                }

                if ($counter == 1)
                    $isExport = true;
            }



            $countCertificates = $student->students_certificates()->where("course_id", $course->id)->count();

            if ($isExport && $countCertificates == 0) {
                $paidOrder_ids = Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                    ->where("order_onlinepayments.payment_status", "paid")
                    ->groupBy("orders.id", "orders.total")
                    ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
                    ->pluck("orders.id")->all();

                $orderProduct = $course->order_products()
                    ->whereHas('orderproducts_students', function ($query) {
                        $query->where("student_id", Auth::user()->id);
                    })->join("orders", "order_products.order_id", "=", "orders.id")
                    ->whereIn("order_products.order_id", $paidOrder_ids)
                    ->orderBy("order_products.order_id", "desc")->first();
                $certificate = null;
                if (!empty($orderProduct)) {
                    $courseTypeVariation_id = $orderProduct->coursetypevariation_id;
                    $courseTypeVariation = CourseTypeVariation::find($courseTypeVariation_id);

                    if (!empty($courseTypeVariation)) {




                        //add le 05 02 2020



                        $student = Auth::user()->student;
                        /// valid quiz 
                       
                        if ($course->isCompleteQuizzes()) {
                            //
                           

                                        $certificate = $courseTypeVariation->certificate;
                                        if (!empty($certificate)) {
                                            $Arabic = new I18N_Arabic('Glyphs');
                                            $serialNumber = "";
                                            $image_name = "";

                                            $certificate->export($student, $Arabic, $serialNumber, $image_name, date("Y-m-d"));

                                            if ($serialNumber != "") {

                                                $studentCertificate = new StudentCertificate();
                                                $studentCertificate->student_id = $student->id;
                                                $studentCertificate->course_id = $courseTypeVariation->courseType->course_id;
                                                $studentCertificate->course_name = $courseTypeVariation->courseType->course->course_trans("ar")->name;

                                                $quiz = $studentQuizTmp->quiz;
                                                if (!empty($quiz)) {
                                                    $studentCertificate->exam_id = $quiz->id;
                                                    $studentCertificate->exam_name = $quiz->quiz_trans("ar")->name;
                                                }
                                                $teacherName = "";
                                                $teacherName = $courseTypeVariation->teacher->user->full_name_en;
                                                $studentCertificate->teacher_name = $teacherName;
                                                $studentCertificate->manual = 0;
                                                if(!$course->isTotalyPaid())
                                                   {
                                                    $studentCertificate->active = 0;
                                                    $studentCertificate->manual = 1;
                                                   } 
                                                $studentCertificate->serialnumber = $serialNumber;
                                                $studentCertificate->image = $image_name;
                                                $studentCertificate->date = date("Y-m-d");
                                                
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




                //w
                if ($orderProduct == "") {

                    $orderProductt = DB::table('order_products')
                        ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                        ->join("orders", "order_products.order_id", "=", "orders.id")
                        ->join("packs", "order_products.pack_id", "=", "packs.id")
                        ->where("packs.cours_id1", $course->id)
                        ->where("orderproducts_students.student_id", $user->id)
                        ->whereIn("order_products.order_id", $paidOrder_ids)
                        ->orderBy("order_products.order_id", "desc")->first();

                        //  test 

                         $orderProduct = $course->order_products()
                                ->whereHas('orderproducts_students', function ($query) {
                                    $query->where("student_id", Auth::user()->id);
                                })->join("orders", "order_products.order_id", "=", "orders.id")
                                ->whereIn("order_products.order_id", $paidOrder_ids)
                                ->orderBy("order_products.order_id", "desc")->first();





                    $certificate = null;
                    if (!empty($orderProductt)) {

                        $courseType = CourseType::where("course_id", $orderProductt->cours_id1)->first();
                        //echo $courseType->id;
                        /*$courseTypeVariation_id = $orderProduct->coursetypevariation_id;*/
                        /*$courseTypeVariation = CourseTypeVariation::find($courseTypeVariation_id);*/
                        $courseTypeVariation = courseTypeVariation::where("coursetype_id", $courseType->id)->first();
                        if (!empty($courseTypeVariation) && $course->isCompleteQuizzes()) {
                            $certificate = $courseTypeVariation->certificate;
                            if (!empty($certificate)) {
                                $Arabic = new I18N_Arabic('Glyphs');
                                $serialNumber = "";
                                $image_name = "";

                                $certificate->export($student, $Arabic, $serialNumber, $image_name, date("Y-m-d"));

                                if ($serialNumber != "") {
                                    $studentCertificate = new StudentCertificate();
                                    $studentCertificate->student_id = $student->id;
                                    $studentCertificate->course_id = $courseTypeVariation->courseType->course_id;
                                    $studentCertificate->course_name = $courseTypeVariation->courseType->course->course_trans("ar")->name;

                                    $quiz = $studentQuizTmp->quiz;
                                    if (!empty($quiz)) {
                                        $studentCertificate->exam_id = $quiz->id;
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
                                    mail($student->user->email, $subject, $message1, $headers);
                                }
                            }
                        }
                    } else {
                        //echo $course->id;
                        $orderProducttt = DB::table('order_products')
                            ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                            ->join("orders", "order_products.order_id", "=", "orders.id")
                            ->join("packs", "order_products.pack_id", "=", "packs.id")
                            ->where("packs.cours_id2", $course->id)
                            ->where("orderproducts_students.student_id", $user->id)
                            ->whereIn("order_products.order_id", $paidOrder_ids)
                            ->orderBy("order_products.order_id", "desc")->first();

                        $certificate = null;
                        if (!empty($orderProducttt)) {

                            $courseType = CourseType::where("course_id", $orderProducttt->cours_id2)->first();
                            //echo $courseType->id;
                            /*$courseTypeVariation_id = $orderProduct->coursetypevariation_id;*/
                            /*$courseTypeVariation = CourseTypeVariation::find($courseTypeVariation_id);*/
                            $courseTypeVariation = courseTypeVariation::where("coursetype_id", $courseType->id)->first();
                            if (!empty($courseTypeVariation) && $course->isCompleteQuizzes()) {
                                $certificate = $courseTypeVariation->certificate;
                                if (!empty($certificate)) {
                                    $Arabic = new I18N_Arabic('Glyphs');
                                    $serialNumber = "";
                                    $image_name = "";

                                    $certificate->export($student, $Arabic, $serialNumber, $image_name, date("Y-m-d"));

                                    if ($serialNumber != "") {
                                        $studentCertificate = new StudentCertificate();
                                        $studentCertificate->student_id = $student->id;
                                        $studentCertificate->course_id = $courseTypeVariation->courseType->course_id;
                                        $studentCertificate->course_name = $courseTypeVariation->courseType->course->course_trans("ar")->name;

                                        $quiz = $studentQuizTmp->quiz;
                                        if (!empty($quiz)) {
                                            $studentCertificate->exam_id = $quiz->id;
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
                                                        مع تمنياتنا لكم بالنجاح و التوفيق في قادم الأيام
                                                        <br> 
                                                        و قد أرفقنا لكم الشهادة 
                                                        <a href='https://swedish-academy.se/uploads/kcfinder/upload/image/" . $studentCertificate->image . "'>انقر هنا</a><br>
                                                        <br>
                                                        مع تمنياتنا لكم بالنجاح و التوفيق في قادم الأيام
                                                       ";
                                        $message1 .= "</td>";
                                        $message1 .= "</tr>";
                                        $message1 .= '</table>';
                                        $message1 .= '</body>';
                                        $message1 .= '</html>';
                                        mail($student->user->email, $subject, $message1, $headers);
                                    }
                                }
                            }
                        }
                    }
                }
                //print_r($paidOrder_ids);

            }

            $admins = \App\Admin::get();
            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->action = "User performed quiz";
            $log->save();
            Notification::send($admins, new UserQuiz($user->id, $user->username));

            return redirect(App('urlLang') . 'courses/quiz-result?studentQuiz_id=' . $studentQuizTmp->id);
        }
    }

    public function VVV(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        $videoExam = $course->videoexams()->where("active", 1)
            ->where("video_exams.id", $request->videoexam_id)->firstOrFail();
             $type = "video";

        $validQuiz = $course->validateQuiz($type, $messageValid);
         $student = Auth::user()->student;
         $casExam = ($course->is_lang) ? CasExamPratique::where("lang", "=",Auth::user()->lang() )->inRandomOrder()->take(1)->first(): CasExamPratique::where("lang", "=",'Ar' )->inRandomOrder()->take(1)->first();
          if (!$student->user_cas_exam()->exists()) {
                $userCas = new UserCasExamPratique;
                $userCas->user_id = $student->id;
                $userCas->cas_exam_pratique_id = $casExamAr->id;
                $userCas->save();
            }
            $userCasExam  = UserCasExamPratique::where('user_id', '=', $student->id)->first();
            $casExamPratique = CasExamPratique::where('id', '=', $userCasExam->cas_exam_pratique_id)->first();
            $studentVideo = $student->student_videoexams()->where("videoexam_id", $videoExam->id)->where("course_id", $course->id)
                    ->where("status", "completed")->where("successfull", 1)->first();
                if (!empty($studentVideo)) {
                    session()->flash("alert-danger", "لقد تجاوزت هذا الاختبار بنجاح لا يمكنك إعادة الاختبار");
                    return redirect()->back();
                }
                return view("front.courses.videoexam", [
                    "videoExam" => $videoExam, "course" => $course,
                    "userCasExam" => $userCasExam, "casExamPratique" => $casExamPratique,
                ]);


    }

    public function videoExam(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        $videoExam = $course->videoexams()->where("active", 1)
            ->where("video_exams.id", $request->videoexam_id)->firstOrFail();

        $type = "video";
        $messageValid = "";
        $validQuiz = $course->validateQuiz($type, $messageValid);
        $student = Auth::user()->student;
        if ($request->course_id == 17) {
            $casExamAr = CasExamPratique::where("lang", "=", "ar")->inRandomOrder()->take(1)->first();
            if (!$student->user_cas_exam()->exists()) {
                $userCas = new UserCasExamPratique;
                $userCas->user_id = $student->id;
                $userCas->cas_exam_pratique_id = $casExamAr->id;
                $userCas->save();
            }
            $userCasExam  = UserCasExamPratique::where('user_id', '=', $student->id)->first();
            $casExamPratique = CasExamPratique::where('id', '=', $userCasExam->cas_exam_pratique_id)->first();
            if ($validQuiz && !empty($student)) {
                $studentVideo = $student->student_videoexams()->where("videoexam_id", $videoExam->id)->where("course_id", $course->id)
                    ->where("status", "completed")->where("successfull", 1)->first();
                if (!empty($studentVideo)) {
                    session()->flash("alert-danger", "لقد تجاوزت هذا الاختبار بنجاح لا يمكنك إعادة الاختبار");
                    return redirect()->back();
                }
                return view("front.courses.videoexam", [
                    "videoExam" => $videoExam, "course" => $course,
                    "userCasExam" => $userCasExam, "casExamPratique" => $casExamPratique,
                ]);
            }
        } elseif (true) {
            //lehna l code student saave ........... 
            $casExamAr = CasExamPratique::where("lang", "=", "ar")->inRandomOrder()->take(1)->first();
            $casExamFr = CasExamPratique::where("lang", "=", "fr")->inRandomOrder()->take(1)->first();

            if (!$student->user_cas_exam()->exists()) {
                
                $userCas = new UserCasExamPratique;
                $userCas->user_id = $student->id;
				if (isset($student->user->user_lang) && $student->user->user_lang->lang_stud == "fr") {
                    $userCas->cas_exam_pratique_id = $casExamFr->id;
				} else {
					$userCas->cas_exam_pratique_id = $casExamAr->id;
				}
                $userCas->save();
            }
            $userCasExam  = UserCasExamPratique::where('user_id', '=', $student->id)->first();
            $casExamPratique = CasExamPratique::where('id', '=', $userCasExam->cas_exam_pratique_id)->first();
            if ($validQuiz && !empty($student)) {
                $studentVideo = $student->student_videoexams()->where("videoexam_id", $videoExam->id)->where("course_id", $course->id)
                    ->where("status", "completed")->where("successfull", 1)->first();
                if (!empty($studentVideo)) {
                    session()->flash("alert-danger", "لقد تجاوزت هذا الاختبار بنجاح لا يمكنك إعادة الاختبار");
                    return redirect()->back();
                }
                return view("front.courses.videoexam", [
                    "videoExam" => $videoExam, "course" => $course,
                    "userCasExam" => $userCasExam, "casExamPratique" => $casExamPratique,
                ]);
            }
        } else {
            if ($validQuiz && !empty($student)) {
                $studentVideo = $student->student_videoexams()->where("videoexam_id", $videoExam->id)->where("course_id", $course->id)
                    ->where("status", "completed")->where("successfull", 1)->first();
                if (!empty($studentVideo)) {
                    session()->flash("alert-danger", "لقد تجاوزت هذا الاختبار بنجاح لا يمكنك إعادة الاختبار");
                    return redirect()->back();
                }
                return view("front.courses.videoexam", [
                    "videoExam" => $videoExam, "course" => $course,

                ]);
            }
        }

        //return $userCasExam;


    }

    public function postSubmitVideo(Request $request)
    {


        $course = Course::findOrFail($request->course_id);
        $videoExam = $course->videoexams()->where("active", 1)
            ->where("video_exams.id", $request->videoExam_id)->firstOrFail();
        $student = Auth::user()->student;
        if ($student->id != null) {

            $studentVideoExam = new StudentVideoExam();
            $studentVideoExam->student_id   = $student->id;
            $studentVideoExam->subject      = $request->subject;
            $studentVideoExam->videoexam_id = $request->videoExam_id;
            $studentVideoExam->course_id    = $course->id;
            $studentVideoExam->video_exam_name = $videoExam->videoexam_trans("ar")->name;
            $studentVideoExam->course_name  = $course->course_trans("ar")->name;
            $studentVideoExam->video        = $videoExam->live == 0 ? $request->video : '';
            $studentVideoExam->user_message = $request->user_message;
            $studentVideoExam->status       = "pending";
            $studentVideoExam->save();


            $user = Auth::user();
            $admins = \App\Admin::get();
            Notification::send($admins, new ExamFinished($user->username, $studentVideoExam->id, "video", $studentVideoExam->video_exam_name));

            Session::flash('alert-success', 'تم إنشاء الإختبار بنجاح...');
            session()->flash('message', 'لقد تم رفع الفيديو بنجاح  ') ;
            return redirect(App('urlLang') . 'account');
        } else {
            abort(404);
        }
    }

    public function postUpdateVideo($studentVideoExam_id, Request $request){
        $student_video_exam = studentVideoExam::findOrFail($studentVideoExam_id);
        $student_video_exam->video = $request->video;
        $student_video_exam->save();
        Session::flash('alert-success', '  تم تحيين الاختبار بنجاح ');
        session()->flash('message', '  تم تحيين الاختبار بنجاح   ') ;
        return redirect(App('urlLang') . 'account');
    }   

    public function quizResult(Request $request)
    {

        $student = Auth::user()->student;
        $currentTime = date("Y-m-d H:i:s");
        if (empty($student))
            abort(404);

        if ($request->type == "video") {
            $studentVideoExam = $student->student_videoexams()->where("students_videoexams.id", $request->studentQuiz_id)
                ->where("status", "!=", "not_completed")->firstOrFail();

            $course = $studentVideoExam->course;
            // cas
            if (in_array($course->id, [496, 502, 17, 532])) {

                $userCasExam  = UserCasExamPratique::where('user_id', '=', $student->id)->first();
                $casExamPratique = CasExamPratique::where('id', '=', $userCasExam->cas_exam_pratique_id)->first();
                $videoExam = $studentVideoExam->videoexam;

                return view("front.courses.videoresult", [
                    "studentVideoExam" => $studentVideoExam, "course" => $course, "videoExam" => $videoExam,
                    "casExamPratique" => $casExamPratique
                ]);
                // end cas
            } else {
                $videoExam = $studentVideoExam->videoexam;
                if (empty($course) || empty($videoExam))
                    abort(404);
                return view("front.courses.videoresult", [
                    "studentVideoExam" => $studentVideoExam, "course" => $course, "videoExam" => $videoExam
                ]);
            }
        } else {
            $studentQuiz = $student->student_quizzes()->where("students_quizzes.id", $request->studentQuiz_id)
                ->firstOrFail();
                $querys = $student->student_quizzes()->where("course_id",532)->where('is_exam',1)
                ->get();
               
            $course = $studentQuiz->course;
            $quiz = $studentQuiz->quiz;
            if (empty($course) || empty($quiz))
                abort(404);
            return view("front.courses.quizresult", [
                "studentQuiz" => $studentQuiz, "course" => $course, "quiz" => $quiz,'querys'=>$querys
            ]);
        }
    }

    public function postSaveReply($courseQuestion_id, Request $request)
    {
        if (Auth::check()) {
            if ($request->exists("quistionType")) {
                $course = Course::findOrFail($courseQuestion_id);
            } else {
                $courseQuestion = CourseQuestion::findOrFail($courseQuestion_id);
            }

            if (Auth::user()->questions()->where("active", 0)->count() > 0) {
                return '<div class="alert alert-danger">لا يمكن إضافة رد آخر حتى يتم الموافقة على ردك السابق</div>';
            }
            $reply = new CourseQuestion();
            if (!empty($courseQuestion)) {
                $reply->course_id = $courseQuestion->course_id;
                $reply->parent_id = $courseQuestion->id;
            } else {
                $reply->course_id = $course->id;
            }
            $reply->user_id = Auth::user()->id;
            $reply->discussion = $request->discussion;
            $reply->active = 1;
            $reply->save();
            $user = Auth::user();
            $admins = \App\Admin::get();
            Notification::send($admins, new UserForum($user->username, $reply->id));
            return '<div class="alert alert-success">لقد تم إضافة ردك بنجاح الرجاء الإنتظار حتى يتم الموافقة عليه</div>';
        }
    }

    public function getStudies(Request $request)
    {
        $courseStudy_id = $request->courseStudy_id;
        $courseStudy = CourseStudy::findOrFail($courseStudy_id);
        $course = $courseStudy->course;
        if ($courseStudy->type == "html" || $courseStudy->type == "pdf") {
            if ($courseStudy->only_registered && Auth::guest()) {
                $this->middleware('auth');
                return redirect(App('urlLang') . 'login');
            }
            return view("front.courses.course_study", array(
                "courseStudy" => $courseStudy, "course" => $course
            ));
        } else {
            abort(404);
        }
    }

    public function views($courseId)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }

        $ipmodel = CourseView::where('course_id', $courseId)->where('ip', $ip)
            ->where(DB::raw("Date(created_at)"), "=", date('Y-m-d'))->first();
        if (empty($ipmodel)) {
            $courseView = new CourseView();
            $courseView->course_id = $courseId;
            $courseView->ip = $ip;
            $courseView->save();
        }
    }

    public function postSaveCourseReview($course_id, Request $request)
    {
        if ($request->value_subject > 0 && $request->value_price > 0 && $request->value_teacher > 0 && $request->value_exam > 0) {
            $courseRating = CourseRating::where("user_id", Auth::user()->id)->where("course_id", $course_id)->first();
            if (empty($courseRating))
                $courseRating = new CourseRating();
            $courseRating->course_id = $course_id;
            $courseRating->user_id = Auth::user()->id;
            $courseRating->value_subject = $request->value_subject;
            $courseRating->value_price = $request->value_price;
            $courseRating->value_teacher = $request->value_teacher;
            $courseRating->value_exam = $request->value_exam;

            $courseRating->value = ((int) $request->value_subject + (int) $request->value_price + (int) $request->value_teacher + (int) $request->value_exam) / 4;

            $courseRating->comment = $request->comment;
            $courseRating->approved = 1;
            $courseRating->save();
            $course = Course::findOrFail($course_id);
            $user = Auth::user();
            $admins = \App\Admin::get();
            Notification::send($admins, new UserReview($user->username, $request->comment, $course->course_trans("ar")->name));

            Session::flash('Review_Updated', trans('home.success_review_updated'));
        }

        return redirect()->back();
    }
    
}
