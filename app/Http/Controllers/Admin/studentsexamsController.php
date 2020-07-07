<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

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

include "assets/I18N/Arabic.php";

use I18N_Arabic;

use File;
use DB;

class studentsexamsController extends Controller
{
    private $table_name = "students-exams";
    private $record_name = "student_exam";

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $students = Student::orderBy("id", "desc")->get();
        $courses = Course::get();
        //        $studentsVideos = StudentVideoExam::select("student_id","videoexam_id as exam_id");
        //        $studentQuizzes = StudentQuiz::select("student_id","quiz_id as exam_id")->union($studentsVideos)->get();


        return view('admin.students-exams.index', array(
            "students" => $students, "courses" => $courses,
            "table_name" => $this->table_name, "record_name" => $this->record_name
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
        $columns = array("", "", "", "", "", "status", "created_at", "");
        $recordsTotal = StudentVideoExam::count() + StudentQuiz::count();

        $studentsVideos = StudentVideoExam::search($request);
        $studentExams = StudentQuiz::search($request);
        $recordsFiltered = $studentExams->count() + $studentsVideos->count();

        $studentExams = $studentExams->union($studentsVideos)
            ->skip($request->start)->take($request->length);

        $order = $request->get("order");
        $column1 = $columns[$order[0]['column']];
        if ($column1 != "")
            $studentExams = $studentExams->orderBy($columns[$order[0]['column']], $order[0]['dir']);
        $studentExams = $studentExams->get();

        $data = array();
        foreach ($studentExams as $key => $item) {
            $user = User::find($item->student_id);
            $course = Course::find($item->course_id);
            $course_name = $item->course_name;
            if (!empty($course))
                $course_name = $course->course_trans('ar')->name;
            $exam_name = $item->exam_name;
            if ($item->type == "video") {
                $exam = VideoExam::find($item->exam_id);
                if (!empty($exam))
                    $exam_name = $exam->videoexam_trans('ar')->name;
            } else {
                $exam = Quiz::find($item->exam_id);
                if (!empty($exam))
                    $exam_name = $exam->quiz_trans('ar')->name;
            }
            $status = "";
            if ($item->status == "pending" || $item->status == "processing")
                $status = '<span class="label label-sm label-info">' . $item->status . '</span>';
            elseif ($item->status == "completed")
                $status = '<span class="label label-sm label-success">' . $item->status . '</span>';
            else
                $status = '<span class="label label-sm label-danger">' . $item->status . '</span>';


            $row = array(
                $user->username,
                $user->full_name_ar,
                $course_name,
                $exam_name,
                $item->type,
                $status,
                date("Y-m-d", strtotime($item->created_at)),
                '<a href="' . url("admin/students-exams/" . $item->id . "/edit?type=" . $item->type) . '">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit student exam"></i>
					</a>
					<a data-toggle="modal" class="deleterecord" elementId="' . $item->id . '" data-type="' . $item->type . '">
						<i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete student exam"></i>
					</a>
                    '
            );
            array_push($data, $row);
        }
        $result = array("recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => array_values($data));
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
        $statusData = array("pending" => "Pending", "processing" => "Processing", "completed" => "Completed", "not_completed" => "Not Completed");

        // foreach (Auth::guard("admins")->user()->unreadnotifications as $notification) {
        //     // if (isset($notification->data['exams']) && $notification->data['exams']['exam_id'] == $id) {
        //     // $notification->markAsRead();
        //     // }
        // }

        if ($request->type == "video") {
            $studentVideo = StudentVideoExam::with("student.user")->findOrFail($id);
            if (!empty($request->old())) {
                $studentVideo->fill($request->old());
            }
            $exam_name = $studentVideo->video_exam_name;


            if (!empty($studentVideo->videoexam))
                $exam_name = $studentVideo->videoexam->videoexam_trans('ar')->name;
            if (in_array($studentVideo->course_id, [496, 502, 17, 532])) {
                $userCasExam  = UserCasExamPratique::where('user_id', '=', $studentVideo->student_id)->first();
                $casExamPratique = CasExamPratique::where('id', '=', $userCasExam['cas_exam_pratique_id'])->first();

                return view('admin.students-exams.edit-video', [
                    'studentVideo' => $studentVideo, 'exam_name' => $exam_name,
                    'statusData' => $statusData,
                    "userCasExam" => $userCasExam, "casExamPratique" => $casExamPratique,
                    "table_name" => $this->table_name, "record_name" => $this->record_name
                ]);
            } else {
                return view('admin.students-exams.edit-video', [
                    'studentVideo' => $studentVideo, 'exam_name' => $exam_name,
                    'statusData' => $statusData,
                    "table_name" => $this->table_name, "record_name" => $this->record_name
                ]);
            }
        } else {
            $studentQuiz = StudentQuiz::with("student.user")->findOrFail($id);
            if (!empty($request->old())) {
                $studentQuiz->fill($request->old());
            }
            $title = "Quiz";
            if ($studentQuiz->is_exam)
                $title = "Exam";
            $exam_name = $studentQuiz->quiz_name;
            if (!empty($studentQuiz->quiz))
                $exam_name = $studentQuiz->quiz->quiz_trans('ar')->name;

            return view('admin.students-exams.edit-quiz', [
                'studentQuiz' => $studentQuiz, 'exam_name' => $exam_name, 'title' => $title,
                'statusData' => $statusData,
                "table_name" => $this->table_name, "record_name" => $this->record_name
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
        if ($request->type == "video") {
            $studentVideo = StudentVideoExam::findOrFail($id);
            $studentVideo->fill($request->all());
            if ($request->successfull)
                $studentVideo->successfull = 1;
            else
                $studentVideo->successfull = 0;
            $studentVideo->save();

            //course liya9a 23 juin

            if ($studentVideo->course_id == 532) {
                if ($studentVideo->successfull == 1) {
                    $student = $studentVideo->student;

                    $courseTypeVariation = CourseTypeVariation::find(298);
                    $existCertif = StudentCertificate::where('student_id', $student->id)->where('course_id', 532)->count();

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
                            mail($student->user->email, $subject, $message1, $headers);
                        }
                    }
                }
            }


            //Course liya9a 
            if ($studentVideo->course_id == 17) {
                if ($studentVideo->successfull == 1) {
                    $student = $studentVideo->student;

                    $courseTypeVariation = CourseTypeVariation::find(26);
                    $existCertif = StudentCertificate::where('student_id', $student->id)->where('course_id', 17)->count();

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
                            mail($student->user->email, $subject, $message1, $headers);
                        }
                    }
                }
            }

            $message = "Video Exam has been Saved Successfully...";
        } else {
            $studentQuiz = StudentQuiz::findOrFail($id);
            $studentQuiz->status = $request->status;
            if ($request->successfull)
                $studentQuiz->successfull = 1;
            else
                $studentQuiz->successfull = 0;
            $studentQuiz->save();

            $adminhistory = new AdminHistory;
            $adminhistory->admin_id = Auth::guard("admins")->user()->id;
            $adminhistory->entree = date('Y-m-d H:i:s');
            $adminhistory->description = "Update " . ucfirst($request->type) . ": " . $studentQuiz->quiz_name . " (id:" . $studentQuiz->id . ")";
            $adminhistory->save();

            $message = ucfirst($request->type) . " has been Saved Successfully...";
        }
        $request->session()->flash('alert-success', $message);
        return redirect()->action('Admin\studentsexamsController@edit', [$id, "type" => $request->type]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete(Request $request, $id)
    {
        if ($request->type == "video") {
            StudentVideoExam::findOrFail($id)->delete();
        } else {
            StudentQuiz::findOrFail($id)->delete();
        }
    }
}
