<?php

namespace App\Http\Controllers;

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

use App\Notifications\UserQuiz;
use App\OrderProduct;

include "assets/I18N/Arabic.php";

use I18N_Arabic;

use Auth;
use DB;
use Session;

class CerifClassroomController extends Controller
{
    //    $studentQuizTmp = StudentQuiz::findOrFail($studentQuiz_id);
    //    
    //     $course = $studentQuizTmp->course;
    //     if (!empty($course)) {
    //         $finalExams = $course->quizzes()->where("active", 1)->where("is_exam", 1)->get();
    //         $countExams = $finalExams->count();
    //         $counter = 0;
    //         foreach ($finalExams as $finalExam) {
    //             $studentExam = $student->student_quizzes()->where("students_quizzes.quiz_id", $finalExam->id)->where("course_id", $course->id)
    //                 ->where("status", "completed")->first();
    //             if (!empty($studentExam) && $studentExam->successfull) {
    //                 $counter++;
    //             }
    //         }
    //         if ($counter == 1)
    //             $isExport = true;
    //     }*
    public function createCertifClass()
    {

        $paidOrder_ids = Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_onlinepayments.payment_status", "paid")
            ->groupBy("orders.id", "orders.total")
            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
            ->pluck("orders.id")->all();



        $certificate = null;
        // $courseTypeVariation_id = $orderProduct->coursetypevariation_id;
        $courseTypeVariation = CourseTypeVariation::find(264);
        $orderProd = OrderProduct::where("course_id", "=", 502)->get();

        if (!empty($courseTypeVariation)) {

            foreach ($orderProd as $orderProduct) {
                foreach ($orderProduct->students as $student) {
                    $certificate = $courseTypeVariation->certificate;
                    if (!empty($certificate)) {

                        $serialNumber = "";
                        $image_name = "";

                        $certificate->export($student, $serialNumber, $image_name, date("Y-m-d"));

                        if ($serialNumber != "") {
                            $studentCertificate = new StudentCertificate();
                            $studentCertificate->student_id = $student->id;
                            $studentCertificate->course_id = $courseTypeVariation->courseType->course_id;
                            $studentCertificate->course_name = $courseTypeVariation->courseType->course->course_trans("ar")->name;

                            $quiz = Quiz::where('id', 302)->first();
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

                            // $mime_boundary = "----MSA Shipping----" . md5(time());
                            // $subject = "Swedish Academy : Certificate";
                            // $headers = "From:Swedish Academy<info@swedish-academy.se> \n";
                            // $headers .= "MIME-Version: 1.0\n";
                            // $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
                            // $message1 = "--$mime_boundary\n";
                            // $message1 .= "Content-Type: text/html; charset=UTF-8\n";
                            // $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
                            // $message1 .= "<html>\n";
                            // $message1 .= "<body>";
                            // $message1 .= "<table width='602'>";
                            // $message1 .= "<tr>";
                            // $message1 .= "<td>";
                            // $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'><br>";
                            // $message1 .= "</td>";
                            // $message1 .= "</tr>";
                            // $message1 .= "<tr>";
                            // $message1 .= "<td align='right'>";
                            // $message1 .= "مرحبا بكم
                            //     تعلمكم الاكاديمية السويدية للتدريب الرياضي أنكم أتممتم الدورة بنجاح و نحن نتمنى لكم الموفقية في حياتكم العملية.
                            //     و تجدون شهادتكم  في حسابكم  في قسم الشهادات من خلال هذا الرابط
                            //     <a href='https://swedish-academy.se/account/certificates'>الشهائد</a>
                            //     <br>
                            //     مع تمنياتنا لكم بالنجاح و التوفيق في قادم الأيام";
                            // $message1 .= "</td>";
                            // $message1 .= "</tr>";
                            // $message1 .= '</table>';
                            // $message1 .= '</body>';
                            // $message1 .= '</html>';
                            // mail($student->user->email, $subject, $message1, $headers);
                        }
                    }
                }
            }
        }
    }
}
