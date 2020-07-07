<?php

namespace App\Http\Controllers\Admin;

use App\Quiz;
use App\StudentCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Runner\Exception;
use Validator;
use App\Http\Controllers\Controller;

use App\Certificate;
use App\CertificateContent;
use App\Course;
use App\CourseTranslation;
use App\CourseType;
use App\CourseQuiz;
use App\QuizTranslation;
use App\Question;
use App\QuestionTranslation;
use App\Answer;

use App\Admin;
use App\User;
use App\Student;
use App\Teacher;
use App\TeacherTranslation;

use App\Book;
use App\BookTranslation;
use App\BookOrder;

use App\StudentQuiz;
use App\StudentQuizAnswer;
use App\VideoExam;
use App\VideoExamTranslation;
use App\StudentVideoExam;

use App\Order;
use App\OrderProduct;
use App\OrderproductStudent;
use App\OrderOnlinepayment;

use DateTime;
use QRcode;
use File;
use DB;

class transdataController extends Controller
{


	public function __construct() {

    }

    public function courses(Request $request){
        $trainingPrograms = DB::table("trainingprograms")->get();
        foreach($trainingPrograms as $trainingProgram){
            $course = Course::find($trainingProgram->id);

            if(empty($course)){
                $course = new Course();
                $course->id = $trainingProgram->id;
                $course->period = $trainingProgram->period;
                if($trainingProgram->experiencelevel!=0)
                    $course->parent_id = $trainingProgram->experiencelevel;

                if($trainingProgram->language_id == 1)
                    $course->language = "arabic";
                else
                    $course->language = "english";
                if (!empty($trainingProgram->path)) {
                    File::copy('../upload/'.$trainingProgram->path, 'uploads/kcfinder/upload/image/courses/' . $trainingProgram->path);
                    $course->image = 'courses/' . $trainingProgram->path;
                }
                if($this->validateDate($trainingProgram->date)){
                    $course->created_at = $trainingProgram->date;
                    $course->updated_at = $trainingProgram->date;
                }

                $course->save();


                $course_trans = new courseTranslation();
                $course_trans->course_id = $course->id;
                $course_trans->lang = "ar";
                $slug = str_replace(" ","-",substr($trainingProgram->nameen,0,10));
                $course_trans->slug = $slug.str_random(2);
                $course_trans->name = $trainingProgram->name;
                $course_trans->content = $trainingProgram->text;
                $course_trans->save();

                $course_trans = new courseTranslation();
                $course_trans->course_id = $course->id;
                $course_trans->lang = "en";
                $course_trans->slug = $slug.str_random(2);
                $course_trans->name = $trainingProgram->nameen;
                $course_trans->save();
                $catIds = array($trainingProgram->category_id);
                $course->categories()->sync((array) $catIds);

                $course_type_online = new CourseType();
                $course_type_online->course_id = $course->id;
                $course_type_online->type = "online";
                $course_type_online->save();

            }else{
                if($this->validateDate($trainingProgram->date)){
                    $course->created_at = $trainingProgram->date;
                    $course->updated_at = $trainingProgram->date;
                }
                $course->save();

            }
        }

    }
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function quizzes(){
       /* $quizzes = Quiz::whereDoesntHave("quiz_transes")->get();
        var_dump($quizzes->toArray());
        die;*/
        $quizData = DB::table("quiz")->get();
        foreach($quizData as $quizRow) {
            $quiz = Quiz::find($quizRow->id);
            if (empty($quiz)) {
                $quiz = new Quiz();
                $quiz->id = $quizRow->id;
                $quiz->is_exam = 0;
                $quiz->duration = $quizRow->duration;
                $quiz->num_questions = $quizRow->question_number;
                if($this->validateDate($quizRow->date)){
                    $quiz->created_at = $quizRow->date;
                    $quiz->updated_at = $quizRow->date;
                }
                $quiz->save();

                $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quizRow->id;
                $quiz_trans->lang = "ar";
                $slug = str_replace(" ","-",substr($quizRow->name,0,5));
                $quiz_trans->slug = str_random(5);
                $quiz_trans->name = $quizRow->name;
                $quiz_trans->short_description = $quizRow->text;
                $quiz_trans->save();

                $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quizRow->id;
                $quiz_trans->lang = "en";
                $quiz_trans->slug = str_random(5);
                $quiz_trans->name = $quizRow->name;
                $quiz_trans->save();

                $course = Course::find($quizRow->trainingprograms_id);
                if(!empty($course)){
                    $courseQuiz = new CourseQuiz();
                    $courseQuiz->course_id = $course->id;
                    $courseQuiz->quiz_id = $quiz->id;
                    $courseQuiz->active = 1;
                    $courseQuiz->save();
                }

            }else{
                if($this->validateDate($quizRow->date)) {
                    $quiz->created_at = $quizRow->date;
                    $quiz->updated_at = $quizRow->date;
                }
                $quiz->save();
            }
        }



        $examData = DB::table("exam")->get();
        foreach($examData as $quizRow) {
            $quiz = Quiz::find($quizRow->id+300);
            if (empty($quiz)) {
                $quiz = new Quiz();
                $quiz->id = $quizRow->id+300;
                $quiz->is_exam = 1;
                $quiz->duration = $quizRow->duration;
                $quiz->num_questions = $quizRow->question_number;
                if($this->validateDate($quizRow->date)){
                    $quiz->created_at = $quizRow->date;
                    $quiz->updated_at = $quizRow->date;
                }
                $quiz->save();

                $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quiz->id;
                $quiz_trans->lang = "ar";
                $slug = str_replace(" ","-",substr($quizRow->name,0,5));
                $quiz_trans->slug =str_random(5);
                $quiz_trans->name = $quizRow->name;
                $quiz_trans->short_description = $quizRow->text;
                $quiz_trans->save();

                $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quiz->id;
                $quiz_trans->lang = "en";
                $quiz_trans->slug = str_random(5);
                $quiz_trans->name = $quizRow->name;
                $quiz_trans->save();

                $course = Course::find($quizRow->trainingprograms_id);
                if(!empty($course)){
                    $courseQuiz = new CourseQuiz();
                    $courseQuiz->course_id = $course->id;
                    $courseQuiz->quiz_id = $quiz->id;
                    $courseQuiz->active = 1;
                    $courseQuiz->save();
                }
            }else{
                if($this->validateDate($quizRow->date)) {
                    $quiz->created_at = $quizRow->date;
                    $quiz->updated_at = $quizRow->date;
                }
                $quiz->save();
            }
        }
    }

    public function questions()
    {
        $questionData = DB::table("quiz_question")->get();
        foreach ($questionData as $questionRow) {
            $question = Question::find($questionRow->id);
            if (empty($question)) {
                $question = new Question();
                $quiz = Quiz::find($questionRow->quiz_id);
                if(!empty($quiz)){
                    $question->id = $questionRow->id;
                    $question->quiz_id = $questionRow->quiz_id;
                    if(!empty($questionRow->path)){   //delete old image
                        File::copy('../upload/'.$questionRow->path,'uploads/kcfinder/upload/image/questions/'. $questionRow->path);
                        $question->image = 'questions/'.$questionRow->path;
                    }
                    if($this->validateDate($questionRow->date)) {
                        $question->created_at = $questionRow->date;
                        $question->updated_at = $questionRow->date;
                    }
                    $question->save();

                    $question_trans = new QuestionTranslation();
                    $question_trans->question_id = $question->id;
                    $question_trans->lang = "ar";
                    $question_trans->question = $questionRow->name;
                    $question_trans->save();

                    $question_trans = new QuestionTranslation();
                    $question_trans->question_id = $question->id;
                    $question_trans->lang = "en";
                    $question_trans->save();

                    for($i=1;$i<=10;$i++){
                        $answerText = 'answer'.$i;
                        $isText = 'is'.$i;
                        if($questionRow->$answerText!=""){
                            $questionAnswer = new Answer();
                            $questionAnswer->question_id = $question->id;
                            $questionAnswer->name_ar = $questionRow->$answerText;
                            if($questionRow->$isText)
                                $questionAnswer->is_correct = 1;
                            else
                                $questionAnswer->is_correct = 0;
                            $questionAnswer->save();
                        }
                    }


                }

            }
        }
    }

    public function accounts(Request $request){
//        $accountsData = DB::table("accounts")->where("type",2)->get();
//        foreach ($accountsData as $account) {
//            $admin = Admin::find($account->id);
//            if (empty($admin)) {
//                $admin = new Admin();
//                $admin->id = $account->id;
//                $admin->name = $account->fullnamear;
//                $admin->email = $account->email;
//                $admin->username = $account->username;
//                $admin->image = $account->path;
//                $admin->password = $account->password;
//                $admin->save();
//            }
//        }

        $accountsData = DB::table("accounts")->where("type","!=",2)->get();
        foreach ($accountsData as $account) {
            $user = User::find($account->id);
            if (empty($user)) {
                $user = User::where("email",$account->email)->first();
                if(empty($user)){
                    $user = new User();
                    $user->id = $account->id;
                    $user->full_name_ar = $account->fullnamear;
                    $user->full_name_en = $account->fullnameen;
                    $user->mobile = $account->mobile;
                    $user->email = $account->email;
                    $user->nationality = $account->nationality;
                    $user->address = $account->citycode." ".$account->street;
                    $user->clothing_size = $account->clothingsize;
                    $user->passport = $account->passport;

                    if(!empty($account->path)){
                        File::copy('../upload/'.$account->path,'uploads/kcfinder/upload/image/users/'. $account->path);
                        $user->image = 'users/'.$account->path;
                    }

                    $birthday = date("Y-m-d", strtotime($account->birthsday));
                    $user->date_of_birth = $birthday;
                    $user->username = $account->username;
                    $user->password = $account->password;
                    if($account->confirmed)
                        $user->active = 1;
                    else
                        $user->active = 0;

                    if($this->validateDate($account->date)) {
                        $user->created_at = $account->date;
                        $user->updated_at = $account->date;
                    }
                    $user->save();

                    if($account->type == 1){
                        $teacher = new Teacher();
                        $teacher->id = $user->id;
                        $teacher->active = 1;
                        $teacher->save();

                        $teacher_trans = new TeacherTranslation();
                        $teacher_trans->teacher_id = $teacher->id;
                        $teacher_trans->lang = "ar";
                        $teacher_trans->save();

                    }else if($account->type == 0){
                        $student = new Student();
                        $student->id = $user->id;
                        $student->save();
                    }
                }

            }
        }
    }

    public function books(Request $request)
    {
        $booksData = DB::table("book_data")->get();
        foreach ($booksData as $bookRow) {
            $book = Book::find($bookRow->id);
            if (empty($book)) {
                $book = new Book();
                $book->id = $bookRow->id;
                $book->price = $bookRow->realcost;
                $book->indicative_price = $bookRow->realcost2;
                $book->buy_link = $bookRow->buylink;
                if(!empty($bookRow->path)){
                    File::copy('../upload/'.$bookRow->path,'uploads/kcfinder/upload/image/books/'. $bookRow->path);
                    $book->image = 'users/'.$bookRow->path;
                }
                if(!empty($bookRow->pdfbook)){
                    File::copy('../upload/'.$bookRow->pdfbook,'uploads/kcfinder/upload/file/books/'. $bookRow->pdfbook);
                    $book->pdf_book = 'books/'.$bookRow->pdfbook;
                }
                $book->save();

                $book_trans = $book->book_trans("ar");
                if(empty($book_trans))
                    $book_trans = new BookTranslation();
                $book_trans->book_id = $book->id;
                $book_trans->name = $bookRow->name;
                $book_trans->slug = str_random(5);
                $book_trans->content = $bookRow->text;
                $book_trans->lang = "ar";
                $book_trans->save();

                $book_trans = $book->book_trans("en");
                if(empty($book_trans))
                    $book_trans = new BookTranslation();
                $book_trans->book_id = $book->id;
                $book_trans->name = $bookRow->name;
                $book_trans->slug = str_random(5);
                $book_trans->lang = "en";
                $book_trans->save();
            }
        }
    }



    public function exams(Request $request)
    {
        $examsData = DB::table("accounts_exam")->get();
        foreach ($examsData as $examRow) {
            $studentQuiz = StudentQuiz::where("student_id",$examRow->accounts_id)
                    ->where("quiz_id",$examRow->exam_id)->where("course_id",$examRow->trainingprograms_id)->first();
            if (empty($studentQuiz)) {
                $student = Student::find($examRow->accounts_id);

                if(!empty($student)){
                    $studentQuiz = new StudentQuiz();
                    $studentQuiz->student_id = $student->id;
                    $quiz = Quiz::find($examRow->exam_id);
                    if(!empty($quiz)){
                        $studentQuiz->quiz_id = $quiz->id;
                        $studentQuiz->quiz_name = $quiz->quiz_trans("ar")->name;
                    }
                    $course = Course::find($examRow->trainingprograms_id);
                    if(!empty($course)){
                        $studentQuiz->course_id = $course->id;
                        $studentQuiz->course_name = $course->course_trans("ar")->name;
                    }
                    $studentQuiz->is_exam = 1;
                    if($examRow->statuss){
                        $studentQuiz->status="completed";
                    }else{
                        $studentQuiz->status="not_completed";
                    }
                    if($this->validateDate($examRow->startime)&&
                        $this->validateDate($examRow->stoptime)){
                        $studentQuiz->startime = $examRow->startime;
                        $studentQuiz->stoptime = $examRow->stoptime;
                    }
                    $final_sum_result = $examRow->finalsum;
                    if($final_sum_result!=""){
                        $results = explode("&#92;",$final_sum_result);
                        $studentQuiz->result = $results[0];
                        $studentQuiz->final_mark = $results[1];
                    }

                    $studentQuiz->successfull = $examRow->successfulorfail;
                    if($this->validateDate($examRow->date)){
                        $studentQuiz->created_at = $examRow->date;
                        $studentQuiz->updated_at = $examRow->date;
                    }
                    $studentQuiz->save();

                    $answersData = DB::table("accounts_exam_answer")->where("accounts_exam_id",$examRow->id)->get();
                    foreach($answersData as $answerRow){
                        $question = DB::table("quiz_question")->where("id",$answerRow->quiz_question_id)->first();
                        if(!empty($question)){
                            $correctAnswer = "";
                            for($i=1;$i<=5;$i++){
                                $is = "is".$i;
                                if($question->$is){
                                    $answerTmp = "answer".$i;
                                    $correctAnswer = $question->$answerTmp;
                                }
                            }
                            $studentQuizAnswer = new StudentQuizAnswer();
                            $studentQuizAnswer->studentquiz_id = $studentQuiz->id;
                            $studentQuizAnswer->question = $question->name;
                            $studentQuizAnswer->given_answer = $answerRow->answer_text;
                            $studentQuizAnswer->correct_answer = $correctAnswer;
                            $studentQuizAnswer->correct = $answerRow->answer_isright;
                            $studentQuizAnswer->save();
                        }

                    }
                }

            }else{

                $studentQuiz->is_exam = 1;
                $studentQuiz->save();

            }
        }
    }
    public function videos(Request $request)
    {
        $examsData = DB::table("accounts_exam_vedio")->get();
        foreach ($examsData as $examRow) {
            $studentExam = StudentVideoExam::find($examRow->id);
            if (empty($studentExam)) {
                $student = Student::find($examRow->accounts_id);

                if (!empty($student)) {
                    $studentExam = new StudentVideoExam();
                    $studentExam->id = $examRow->id;
                    $studentExam->student_id = $student->id;
                    $videoExam = VideoExam::find($examRow->exam_vedio_id);
                    if (!empty($videoExam)) {
                        $studentExam->videoexam_id = $videoExam->id;
                        $studentExam->video_exam_name = $videoExam->videoexam_trans("ar")->name;
                    }
                    $course = Course::find($examRow->trainingprograms_id);
                    if (!empty($course)) {
                        $studentExam->course_id = $course->id;
                        $studentExam->course_name = $course->course_trans("ar")->name;
                    }
                    if ($examRow->statuss) {
                        $studentExam->status = "completed";
                    } else {
                        $studentExam->status = "not_completed";
                    }
                    $studentExam->video = $examRow->path;
                    $studentExam->manager_message = $examRow->managermessage;
                    $studentExam->user_message = $examRow->accountsmessage;
                    $studentExam->website_message = $examRow->adminmessage;
                    $studentExam->successfull = $examRow->successfulorfail;
                    if($this->validateDate($examRow->date)){
                        $studentExam->created_at = $examRow->date;
                        $studentExam->updated_at = $examRow->date;
                    }
                    $studentExam->save();
                }
            }
        }
    }

    public function orders(Request $request)
    {
        $ordersData = DB::table("accounts_trainingprograms_buyment")->get();
        foreach ($ordersData as $ordersRow) {
            $order = Order::find($ordersRow->id);
            if (empty($order)) {
                $order = new Order();
                $order->id = $ordersRow->id;
                $user = User::find($ordersRow->accounts_id);
                if(!empty($user))
                    $order->user_id = $ordersRow->accounts_id;

                $order->invoice = $ordersRow->invoice;
                $order->copymoneyorder = $ordersRow->copymoneyorder;
                if($ordersRow->buymethod=="CreditCard")
                    $order->payment_method = "creditcard";
                elseif($ordersRow->buymethod=="PayPal")
                    $order->payment_method = "paypal";
                elseif($ordersRow->buymethod=="cashtodealers")
                    $order->payment_method = "cash";
                else
                    $order->payment_method = $ordersRow->buymethod;
                if($this->validateDate($ordersRow->date)) {
                    $order->created_at = $ordersRow->date;
                    $order->updated_at = $ordersRow->date;
                }
                if (!empty($ordersRow->invoice)) {
                    $name1 = substr($ordersRow->invoice,8);
                    File::copy('../'.$ordersRow->invoice, 'uploads/kcfinder/upload/image/invoices/' . $name1);
                    $order->invoice = 'invoices/' . $name1;
                }

                if (!empty($ordersRow->copymoneyorder)) {
                    File::copy('../upload/'.$ordersRow->copymoneyorder, 'uploads/kcfinder/upload/image/bank_transfers/' . $ordersRow->copymoneyorder);
                    $order->copymoneyorder = 'bank_transfers/' . $ordersRow->copymoneyorder;
                }
                $order->save();

                $course = Course::find($ordersRow->trainingprograms_id);
                if(!empty($course)){
                    $orderProduct = new OrderProduct();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->course_id = $course->id;
                    $orderProduct->num_students = 1;
                    $orderProduct->save();

                    $student = Student::find($ordersRow->accounts_id);
                    if(!empty($student)){
                        $orderproductStudent = new OrderproductStudent();
                        $orderproductStudent->orderproduct_id = $orderProduct->id;
                        $orderproductStudent->student_id = $student->id;
                        $orderproductStudent->save();
                    }
                }



            }
        }
    }

    public function books_orders(Request $request)
    {
        $bookordersData = DB::table("books_buyment")->get();
        foreach ($bookordersData as $bookorderRaw) {
            $order = Order::find($bookorderRaw->id+2100);
            if (empty($order)) {
                $order = new Order();
                $order->id = $bookorderRaw->id+2100;
                $user = User::where("email",$bookorderRaw->email)->first();
                if(!empty($user)){
                    $order->user_id = $user->id;
                    if($bookorderRaw->buymethod=="CreditCard")
                        $order->payment_method = "creditcard";
                    elseif($bookorderRaw->buymethod=="PayPal")
                        $order->payment_method = "paypal";
                    elseif($bookorderRaw->buymethod=="cashtodealers")
                        $order->payment_method = "cash";
                    else
                        $order->payment_method = $bookorderRaw->buymethod;
                    if($this->validateDate($bookorderRaw->date)) {
                        $order->created_at = $bookorderRaw->date;
                        $order->updated_at = $bookorderRaw->date;
                    }
                    if (!empty($bookorderRaw->invoice)) {
                        $name1 = substr($bookorderRaw->invoice,8);
                        File::copy('../'.$bookorderRaw->invoice, 'uploads/kcfinder/upload/image/invoices/' . $name1);
                        $order->invoice = 'invoices/' . $name1;
                    }

                    if (!empty($bookorderRaw->copymoneyorder)) {
                        File::copy('../upload/'.$bookorderRaw->copymoneyorder, 'uploads/kcfinder/upload/image/bank_transfers/' . $bookorderRaw->copymoneyorder);
                        $order->copymoneyorder = 'bank_transfers/' . $bookorderRaw->copymoneyorder;
                    }
                    $order->save();

                    $book = Book::find($bookorderRaw->books_id);
                    if(!empty($book)){
                        $orderProduct = new OrderProduct();
                        $orderProduct->order_id = $order->id;
                        $orderProduct->book_id = $book->id;
                        $orderProduct->num_students = 1;
                        $orderProduct->save();

                        $student = Student::find($user->id);
                        if(!empty($student)){
                            $orderStudent = new OrderStudent();
                            $orderStudent->order_id = $orderProduct->id;
                            $orderStudent->student_id = $student->id;
                            $orderStudent->save();
                        }
                    }
                }
            }
        }
    }

    public function certificates(Request $request)
    {
        $certificateData = DB::table("certificate")->get();
        foreach ($certificateData as $certificateRow) {
            $certificate = Certificate::find($certificateRow->id);
            if (empty($certificate)) {
                $certificate = new Certificate();
                $certificate->id = $certificateRow->id;
                $certificate->name_ar = $certificateRow->name;
                $certificate->name_en = $certificateRow->nameen;
                $certificate->lecturer_ar = $certificateRow->lecturer;
                $certificate->lecturer_en = $certificateRow->lectureren;
                $certificate->description_ar = $certificateRow->text;
                $certificate->qrcodex = $certificateRow->qrcodex;
                $certificate->qrcodey = $certificateRow->qrcodey;
                $certificate->confirmed = $certificateRow->confirmed;
                if($this->validateDate($certificateRow->date)) {
                    $certificate->created_at = $certificateRow->date;
                    $certificate->updated_at = $certificateRow->date;
                }
                if (!empty($certificateRow->path)) {
                    $name1 = substr($certificateRow->path,20);
                    File::copy('../'.$certificateRow->path,'uploads/kcfinder/upload/image/certificates/'. $name1);
                    $certificate->image = 'certificates/'.$name1;
                }
                $certificate->save();

                $contentData = DB::table("certificate_content1")->where("certificate_id",$certificate->id)->get();
                foreach($contentData as $contentRow){
                    $certificateContent = new CertificateContent();
                    $certificateContent->certificate_id = $certificate->id;
                    $certificateContent->fieldcolumn = $contentRow->fieldcolumn;
                    $certificateContent->fontsize = $contentRow->fontsize;
                    $certificateContent->fontcolors = $contentRow->fontcolors;
                    $certificateContent->xposition = $contentRow->xposition;
                    $certificateContent->xalign = $contentRow->xalign;
                    $certificateContent->yposition = $contentRow->yposition;
                    $certificateContent->showoncertificate = $contentRow->showoncertificate;
                    $certificateContent->save();
                }
            }
        }
    }

    public function studentCertificates(Request $request)
    {
        $account_certificateData = DB::table("accounts_certificate")->get();
        foreach ($account_certificateData as $acc_certificateRow) {
            $studentCertificate = StudentCertificate::find($acc_certificateRow->id);
            if (empty($studentCertificate)) {
                $studentCertificate = new StudentCertificate();
                $studentCertificate->id = $acc_certificateRow->id;

                $student = Student::find($acc_certificateRow->accounts_id);
                if (!empty($student)){
                    $studentCertificate->student_id = $student->id;
                    $course = Course::find($acc_certificateRow->trainingprograms_id);
                    if (!empty($course)) {
                        $studentCertificate->course_id = $course->id;
                        $studentCertificate->course_name = $course->course_trans("ar")->name;
                    }
                    $exam = Quiz::find($acc_certificateRow->exam_id);
                    if (!empty($exam)) {
                        $studentCertificate->exam_id = $exam->id;
                        $studentCertificate->exam_name = $exam->quiz_trans("ar")->name;
                        $studentCertificate->manual = 0;
                    } else {
                        $studentCertificate->manual = 1;
                    }
                    $studentCertificate->serialnumber = $acc_certificateRow->serialnumber;
                    if ($this->validateDate($acc_certificateRow->date)) {
                        $studentCertificate->created_at = $acc_certificateRow->date;
                        $studentCertificate->updated_at = $acc_certificateRow->date;
                    }
                    $studentCertificate->active = 1;					$studentCertificate->date = date("Y-m-d");
                    $studentCertificate->serialnumber = $acc_certificateRow->serialnumber;
                    if (!empty($acc_certificateRow->path)) {
                        $src = '../accountscertificate/';
                        $name1 = $acc_certificateRow->path;
                        if ($acc_certificateRow->manuel == 1) {
                            $src = '../';
                            $name1 = substr($acc_certificateRow->path, 20);
                        }
                        if (file_exists($src . $acc_certificateRow->path)) {
                            File::copy($src . $acc_certificateRow->path, 'uploads/kcfinder/upload/image/students certificates/' . $name1);
                            $studentCertificate->image = 'students certificates/' . $name1;
                        }
                    }
                    $studentCertificate->save();
                }
            }
        }
    }

    public function barcodes(){
        /*$studentCertificates = StudentCertificate::get();
        foreach($studentCertificates as $studentCertificate){
            $dir = 'construction/accountscertificate/';
            $file_temp = $_SERVER['DOCUMENT_ROOT']."/".$dir.$studentCertificate->serialnumber."-QR.jpg";
            if(file_exists($file_temp)){
                imagepng(imagecreatefromstring(file_get_contents('../accountscertificate/'.$studentCertificate->serialnumber."-QR.jpg")), 'uploads/kcfinder/upload/image/barcodes/' . $studentCertificate->serialnumber."-code.png");
            }
        }*/
        include_once "assets/phpqrcode/qrlib.php";
        $studentCertificates = StudentCertificate::get();
        foreach($studentCertificates as $studentCertificate){
            $dir = 'uploads/kcfinder/upload/image/barcodes/';
            $file_temp = $_SERVER['DOCUMENT_ROOT']."/".$dir. $studentCertificate->serialnumber."-code.png";
            if(!file_exists($file_temp)){
                $barcodeImg = $dir.$studentCertificate->serialnumber."-code.png";
                $test = QRcode::png($studentCertificate->serialnumber,$barcodeImg, QR_ECLEVEL_L,4,2);
                $QRcode = imagecreatefrompng($barcodeImg);
            }
        }
    }

    public function usersEdit(){
//        $usersData = DB::table("users_temp")->get();
//        foreach ($usersData as $usersRow) {
//            $user = User::find($usersRow->id);
//            if (!empty($user)) {
//                $user->full_name_ar = $usersRow->full_name_ar;
//                if(substr($user->email, -1)=="1"){
//                    $user->email = substr($user->email, 0, -1);
//                }
//                $user->save();
//            }
//        }
//        $users = User::get();
//        foreach($users as $user){
//            $user->auth_key = str_random(40);
//            $user->auth_mobile_key = rand(1111,9999);
//            $user->save();
//        }
//        $orders = Order::get();
//        foreach($orders as $order){
//            foreach($order->orderproducts as $orderProduct){
//                $course = $orderProduct->course;
//                if(!empty($course)&&empty($orderProduct->coursetypevariation_id)){
//                    $courseType = $course->courseTypes()->whereHas("couseType_variations")->first();
//                    if(!empty($courseType)){
//                        $courseTypeVariation = $courseType->couseType_variations()->first();
//                        if(!empty($courseTypeVariation)){
//                            $orderProduct->coursetypevariation_id = $courseTypeVariation->id;
//                            $orderProduct->save();
//                        }
//                    }
//                }
//            }
//        }

        $newsData = DB::table("news1")->get();
        foreach ($newsData as $newsRow) {
            $current_news = \App\News::find($newsRow->id);
            if (empty($current_news)) {
                $current_news = new \App\News();
                if(!empty($current_news)) {
                    $current_news->id = $newsRow->id;
                    if (!empty($newsRow->path)) {   //delete old image
                        File::copy('../upload/' . $newsRow->path, 'uploads/kcfinder/upload/image/news/' . $newsRow->path);
                        $current_news->image = 'news/' . $newsRow->path;
                    }
                    if ($this->validateDate($newsRow->date)) {
                        $current_news->created_at = $newsRow->date;
                        $current_news->updated_at = $newsRow->date;
                    }
                    $current_news->save();

                    $news_trans = new \App\NewsTranslation();
                    $news_trans->news_id = $current_news->id;
                    $news_trans->lang = "ar";
                    $news_trans->title = $newsRow->name;
                    $slug = str_replace(" ","-",substr($newsRow->name,0,10));
                    $news_trans->slug = $slug.str_random(2);
                    $news_trans->content = $newsRow->text;
                    $news_trans->save();

                    $news_trans = new \App\NewsTranslation();
                    $news_trans->news_id = $current_news->id;
                    $news_trans->lang = "en";
                    $news_trans->title = $newsRow->name;
                    $slug = str_replace(" ","-",substr($newsRow->name,0,10));
                    $news_trans->slug = $slug.str_random(2);
                    $news_trans->save();
                }
            }else{
                echo $newsRow->date."<br/>";
                $current_news->created_at = date("Y-m-d",strtotime($newsRow->date));
                $current_news->updated_at = date("Y-m-d",strtotime($newsRow->date));
                $current_news->save();
            }
        }
        die;



    }


    public function coursesImages(Request $request){
        $courses = Course::take(2)->get();
        foreach($courses as $course){
            if(!empty($course->image)){   //delete old image
                File::copy('upload/'.$course->image,'uploads/kcfinder/upload/image/courses/'. $course->image);
                $course->image = 'courses/'.$course->image;
                $course->save();
            }
        }
    }
    public function questionImages(Request $request){
        $questions = Question::get();
        foreach($questions as $question){
            if(!empty($question->image)){   //delete old image
                File::copy('upload/'.$question->image,'uploads/kcfinder/upload/image/questions/'. $question->image);
                $question->image = 'questions/'.$question->image;
                $question->save();
            }
        }
    }
    public function accountImages(Request $request){
        $admins = Admin::get();
        foreach($admins as $admin){
            if(!empty($admin->image)){
                File::copy('upload/'.$admin->image,'uploads/kcfinder/upload/image/admins/'. $admin->image);
                $admin->image = 'admins/'.$admin->image;
                $admin->save();
            }
        }

        $users = User::get();
        foreach($users as $user){
            if(!empty($user->image)){
                File::copy('upload/'.$user->image,'uploads/kcfinder/upload/image/users/'. $user->image);
                $user->image = 'users/'.$user->image;
                $user->save();
            }
        }
    }
    public function bookImages(Request $request){
        $books = Book::get();
        foreach($books as $book){
            if(!empty($book->image)){
                File::copy('upload/'.$book->image,'uploads/kcfinder/upload/image/books/'. $book->image);
                $book->image = 'books/'.$book->image;
                $book->save();
            }

            if(!empty($book->pdf_book)){
                File::copy('upload/'.$book->pdf_book,'uploads/kcfinder/upload/file/books/'. $book->pdf_book);
                $book->pdf_book = 'books/'.$book->pdf_book;
                $book->save();
            }
        }

        $bookOrders = BookOrder::get();
        foreach($bookOrders as $bookOrder) {
            if (!empty($bookOrder->banktransfer_image)) {
                $name1 = substr($bookOrder->banktransfer_image,8);
                File::copy($bookOrder->banktransfer_image, 'uploads/kcfinder/upload/image/bank_transfers/' . $name1);
                $bookOrder->banktransfer_image = 'bank_transfers/' . $name1;
                $bookOrder->save();
            }
        }
    }
    public function orderImages(Request $request){

        $orders = Order::get();
        foreach($orders as $order) {
            if (!empty($order->invoice)) {
                $name1 = substr($order->invoice,8);
                File::copy($order->invoice, 'uploads/kcfinder/upload/image/invoices/' . $name1);
                $order->invoice = 'invoices/' . $name1;
                $order->save();
            }

            if (!empty($order->copymoneyorder)) {
                File::copy('upload/'.$order->copymoneyorder, 'uploads/kcfinder/upload/image/bank_transfers/' . $order->copymoneyorder);
                $order->copymoneyorder = 'bank_transfers/' . $order->copymoneyorder;
                $order->save();
            }
        }
    }

    public function videoImages(Request $request){
        $studentVideos = StudentVideoExam::get();
        foreach($studentVideos as $studentVideo){
            if(!empty($studentVideo->video)){
                if (strpos($studentVideo->video, 'videos/') === false) {
                    File::copy('../video/'.$studentVideo->video,'uploads/kcfinder/upload/file/videos/'. $studentVideo->video);
                    $studentVideo->video = 'videos/'.$studentVideo->video;
                    $studentVideo->save();
                }
            }
        }
    }

    public function certificateImages(Request $request){
        $certificates = Certificate::get();
        foreach($certificates as $certificate){
            if(!empty($certificate->image)){
                $name1 = substr($certificate->image,20);
                File::copy('../'.$certificate->image,'uploads/kcfinder/upload/image/certificates/'. $name1);
                $certificate->image = 'certificates/'.$name1;
                $certificate->save();
            }
        }
    }

    public function studentcertificateImages(Request $request){
        $studentCertificates = StudentCertificate::where("manual",0)->get();
        foreach($studentCertificates as $studentCertificate){
            if(!empty($studentCertificate->image)){
                $name1 = substr($studentCertificate->image,20);
                if(file_exists('../'.$studentCertificate->image)){
                    File::copy('../'.$studentCertificate->image,'uploads/kcfinder/upload/image/students certificates/'. $name1);
                    $studentCertificate->image = 'students certificates/'.$name1;
                    $studentCertificate->save();
                }

            }
        }
    }
    public function studentcertificate1Images(Request $request){
        $studentCertificates = StudentCertificate::where("manual",1)->get();
        foreach($studentCertificates as $studentCertificate){
            if(!empty($studentCertificate->image)){
                if(file_exists('../accountscertificate/'.$studentCertificate->image)){
                    File::copy('../accountscertificate/'.$studentCertificate->image,'uploads/kcfinder/upload/image/students certificates/'. $studentCertificate->image);
                    $studentCertificate->image = 'students certificates/'.$studentCertificate->image;
                    $studentCertificate->save();
                }

            }
        }
    }

    public function test(){

        echo substr('accountscertificate/58d3fffedff77.jpg',20);

    }


}
