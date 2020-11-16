<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\MetaData;
use App\NewsletterSubscriber;
use App\User;
use App\Teacher;
use App\Page;
use App\Course;
use App\Student;
use App\Book;
use App\Setting;
use App\CourseType;
use App\Category;
use App\Country;
use App\CourseRating;
use App\StudentCertificate;
use App\Faq;


use App;
use DB;
use Auth;
use Validator;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getIndex(Request $request)
    {


        $setting = Setting::find(1);
        $sliderImages = $setting->sliderimages()->where("active", 1)
            ->where("lang", session()->get('locale'))->orderBy("sort_order", "asc")->get();
        $setting_trans = $setting->settings_trans(session()->get('locale'));

        if (empty($setting_trans))
            $setting_trans = $setting->settings_trans('ar');

        $categories = Category::get();
        $countries = Country::join("governments", "governments.country_id", "=", "countries.id")
            ->join("coursetype_variations", "coursetype_variations.govern_id", "=", "governments.id")
            ->distinct()->get(["countries.*"]);

        $countTeacher = Teacher::count();
        $countCourses = Course::count();
        $countBooks = Book::count();
        $countStudents = Student::count();


        $courseTypes = CourseType::join('courses', 'courses.id', '=', 'course_types.course_id')
            ->select('courses.*', 'course_types.*')
            ->where('courses.active', '=', 1)
            ->where('course_types.type', '=', 'online')
            ->orWhereHas('couseType_variations', function ($query) {
                $now = date("Y-m-d");
                $query->where('course_types.type', '=', 'presence')
                    ->where('coursetype_variations.date_from', '>=', $now);
            })->take(9)->get();
        // return $courseTypes;


        $books = Book::take(4)->get();
        $teachers = Teacher::where("show_in_home", 1)->get();
        $testimonials = CourseRating::where("approved", 1)->get();
         
        return view("front.home.index", array(
            "setting" => $setting, "sliderImages" => $sliderImages,
            "categories" => $categories, "countries" => $countries,
            "setting_trans" => $setting_trans, "countTeacher" => $countTeacher,
            "countCourses" => $countCourses, "countBooks" => $countBooks, "countStudents" => $countStudents, "courseTypes" => $courseTypes,
            "books" => $books, "teachers" => $teachers, "testimonials" => $testimonials
        ));
    }

    public function promo($id)
    {
        if (Auth::guest() || Auth::user()->id != $id) {
            $promoUser = User::findOrFail($id);
            session()->put('promo', $id);
            $setting = Setting::find(1);
            $setting_trans = $setting->settings_trans(session()->get('locale'));
            if (empty($setting_trans))
                $setting_trans = $setting->settings_trans('en');

            return view("front.site.promo", array(
                "setting" => $setting, "setting_trans" => $setting_trans,
                "promoUser" => $promoUser
            ));
        } else {
            return redirect(App('urlLang'));
        }
    }

    public function getContact()
    {

        $setting = App('setting');
        $metaData = MetaData::where("lang", session()->get('locale'))->where("page", "contact")->first();
        return view("front.site.contact", array(
            "setting" => $setting, "metaData" => $metaData
        ));
    }

    public function postContact(Request $request)
    {

        $name     = $request->get("full_name");
        $email    = $request->get("email");
        $subject  = $request->get("subject");
        $message1 = $request->get("message");
        $status   = 0;
        try {
            $status = Mail::send('emails.contact', ['name' => $name, 'message1' => $message1, 'email' => $email, 'subject' => $subject, 'mobile' => $request->mobilefull], function ($message) use ($subject, $email, $name) {
                $message->to(App('setting')->email)->subject($subject)->replyTo($email, $name);;
            });

            echo "<div class='alert alert-success' >" . trans('home.message_sent') . "</div>";
        } catch (\Exception $e) {
            echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }

    public function getFaq()
    {
        $faqs = Faq::orderBy("sort_order")->get();
        $metaData = MetaData::where("lang", session()->get('locale'))->where("page", "faq")->first();
        return view("front.site.faq", array(
            "faqs" => $faqs, "metaData" => $metaData
        ));
    }


    public function getPage($slug)
    {
        $page = Page::join("pages_translations", "pages_translations.page_id", "=", "pages.id")
            ->where("pages_translations.slug", $slug)->first(["pages.*"]);
            
        if (!empty($page)) {
            $page_trans = $page->page_trans(session()->get('locale'));
            if ($page_trans->slug != $slug)
                return redirect(App('urlLang') . 'pages/' . $page_trans->slug, 301);
            else {
                return view('front.site.page', array("page" => $page));
            }
        } else {
            abort(404);
        }
    }

    public function getGraduates(Request $request)
    {

        $listStudent = Student::join("users", "students.id", "=", "users.id")->where('students.blocked', 0)->get();

        //  $listcertificate = StudentCertificate::get();
        /*****students******/
        $students = Student::NotBlocked()->pluck('id');
        $listcertificate = StudentCertificate::whereIn('student_id', $students)->get();

        $currentYear = date("Y");
        if ($request->has("year") && !$request->has("course_id")) {
            $year = $request->year;
            $courses = Course::whereHas("students_certificates", function ($query) use ($year) {
                $query->where(DB::raw("Year(students_certificates.created_at)"), "=", $year)
                    ->where("students_certificates.active", 1);
            })->get();

            return view('front.site.graduates_courses', [
                "year" => $year, "courses" => $courses,
                "listStudent" => $listStudent,
                "listcertificate" => $listcertificate
            ]);
        }

        if ($request->has("code")) {
            $code = $request->code;
            $studentCertificates = StudentCertificate::where('serialnumber', $code)->get();
            if ($studentCertificates->count() == 0) {
                $query = "select SC.* from students_certificates SC, students S, users U where SC.student_id = S.id and S.id=U.id and U.full_name_en like '%" . $code . "%'";
                $studentCertificates = DB::select($query);
            }

            return view('front.site.graduates_final', [
                "year" => 'all years', "course_id" => 0, "code" => $code,
                "course" => null, "studentCertificate" => $studentCertificates,
                "listStudent" => $listStudent,
                "listcertificate" => $listcertificate
            ]);
        }

        if ($request->has("year") && $request->has("course_id")) {
            $year = $request->year;
            $course_id = $request->course_id;
            $course = Course::find($course_id);
            $studentCertificate = $course->students_certificates->first();
            return view('front.site.graduates_final', [
                "year" => $year, "course_id" => $course_id, "code" => null,
                "course" => $course, "studentCertificate" => $studentCertificate,
                "listStudent" => $listStudent,
                "listcertificate" => $listcertificate
            ]);
        }
        return view('front.site.graduates', [
            "currentYear" => $currentYear,
            "listStudent" => $listStudent,
            "listcertificate" => $listcertificate
        ]);
    }

    public function loadGraduates(Request $request)
    {
        $year = $request->year;
        $course_id = $request->course_id;
        $code = $request->code;

        $students = Student::NotBlocked()->pluck('id');

        $studentCertificates = StudentCertificate::whereIn('student_id', $students)->where(DB::raw("Year(created_at)"), $year)
            ->where("active", 1);
        if ($course_id != 0) {
            $studentCertificates = $studentCertificates->where("course_id", $course_id);
        }
        $studentCertificates = $studentCertificates->skip($request->start)->take($request->length)
            ->orderBy("created_at", "desc")->get();
        $current = $request->start;


        if (!is_null($code)) {
            $studentCertificates = StudentCertificate::whereIn('student_id', $students)->where('serialnumber', $code)->get();
            if ($studentCertificates->count() == 0) {
                $query = "select U.id from users U where U.full_name_en like '%" . $code . "%'";
                $users_r = DB::select($query);
                $users = [];
                foreach ($users_r as $user) {
                    array_push($users, $user->id);
                }
                $studentCertificates = StudentCertificate::whereIn('student_id', $students)->whereIn('student_id', $users)->get();
            }
        }

        $recordsTotal = $studentCertificates->count();
        $numPages = ceil($recordsTotal);


        $view = view('front.site._graduates', [
            "studentCertificates" => $studentCertificates, "numPages" => $numPages,
            "current" => $current, "nbrs" => $recordsTotal
        ]);
        $result = array();
        $result[0] = str_replace('"', '\"', $view);

        return json_encode($result);
    }

    /*public function getGraduates(){

        $currentYear = date("Y");
        $courses = Course::whereHas("students_certificates",function($query) use($currentYear){
            $query->where(DB::raw("Year(created_at)"),$currentYear);
        })->get();
        return view('front.site.graduates',[
            "currentYear"=>$currentYear,"courses"=>$courses
        ]);
    }

    public function loadCourses(Request $request){
        $result = array();
        $year = $request->year;
        $courses = Course::whereHas("students_certificates",function($query) use($year){
            $query->where(DB::raw("Year(students_certificates.created_at)"),"=",$year);
        })->get();
        $result["courses"] = '<option value="">اختر الدورة</option>';

        if(!$courses->isEmpty()){
            foreach($courses as $course){
                if(isset($course->course_trans(App("lang"))->name))
                    $name = $course->course_trans(App("lang"))->name;
                else {
                    $name = $course->course_trans("ar")->name;
                }
                $result["courses"] .= '<option value="'.$course->id.'">'.$name.'</option>';
            }
        }
        return $result;
    }

    */

    public function certificates($serialNumber)
    {
        $students = Student::NotBlocked()->pluck('id');

        $studentCertificate = StudentCertificate::whereIn('student_id', $students)->where("serialnumber", $serialNumber)->firstOrFail();
        if ($studentCertificate->count() == 0) {
            echo "sorry";
        }
        $course_name = $studentCertificate->course_name;
        if (!is_null($studentCertificate->course))
            $course_name = $studentCertificate->course->course_trans(session()->get('locale'))->name;
        $exam_name = $studentCertificate->exam_name;
        if (!is_null($studentCertificate->exam))
            $exam_name = $studentCertificate->exam->quiz_trans(session()->get('locale'))->name;
        $student_name = '';
        if (!is_null($studentCertificate->student))
            $student_name = $studentCertificate->student->user->full_name_en;

        return view('front.site.certificate', [
            "studentCertificate" => $studentCertificate, "course_name" => $course_name,
            "exam_name" => $exam_name, "student_name" => $student_name
        ]);
    }

    /*public function getGallery(){
		$galleries = Gallery::where('active',1)->orderBy("sort_order")->get();
		
		return view('front.site.gallery',array("galleries"=>$galleries));
		
	}*/

    public function getNewsletterVerification(Request $request)
    {
        $subscriber = NewsletterSubscriber::where("email", $request->email)->where('auth_key', $request->mail)->first();
        if (!empty($subscriber)) {
            $oldActive = $subscriber->active;
            $subscriber->active = 1;
            $subscriber->save();


            return view("front.site.newsletter_verification", array(
                "subscriber" => $subscriber, "oldActive" => $oldActive
            ));
        } else {
            abort(404);
        }
    }

    public function getUserVerification(Request $request)
    {
        $user = User::where("email", $request->email)->where('auth_key', $request->mail)->first();
        if (!empty($user)) {
            $user->email_verified = 1;
            $user->save();
            return redirect(App('urlLang') . 'account');
        } else {
            session()->flash("alert-danger", "كود التفعيل خاطئ");
            return redirect()->back();
        }
    }

    public function getMobileVerification(Request $request)
    {

        $user = User::where("mobile", $request->mobile)->where('auth_mobile_key', $request->mail)->first();

        if (!empty($user)) {
            $user->mobile_verified = 1;
            $user->save();
            return redirect(App('urlLang') . 'account');
        } else {
            session()->flash("alert-danger", "كود التفعيل خاطئ");
            return redirect()->back();
        }
    }



    public function getSearch(Request $request)
    {

        $country_id = $request->country_id;
        $category_id = $request->category_id;
        $type = $request->type;
        $searchtxt = "";

        $courseTypes = CourseType::join("courses", "courses.id", "=", "course_types.course_id")
            ->leftJoin("courses_categories", "courses_categories.course_id", "=", "courses.id")
            ->where("courses.active", 1);
        if (!empty($category_id)) {
            $category = Category::find($category_id);
            if (!empty($category))
                $searchtxt .= $category->category_trans(App("lang"))->name . ",";
            $courseTypes = $courseTypes->where("courses_categories.category_id", $category_id);
        }
        if (!empty($country_id)) {
            $country = Country::find($country_id);
            if (!empty($country))
                $searchtxt .= $country->country_trans('en')->name . ",";
            $courseTypes = $courseTypes->join("coursetype_variations", "course_types.id", "=", "coursetype_variations.coursetype_id")
                ->join("governments", "governments.id", "=", "coursetype_variations.govern_id")
                ->where("governments.country_id", $country_id);
        }
        if (!empty(trim($type))) {
            $searchtxt .= $type;
            if ($type = "online") {
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query1) {
                    $query1->where('course_types.type', '=', 'online');
                });
            } else {
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query1) {
                    $now = date("Y-m-d");
                    $query1->where('course_types.type', '=', 'presence')
                        ->where('coursetype_variations.date_from', '>=', $now);
                });
            }
        } else {
            $courseTypes = $courseTypes->where(function ($query) {
                $query->whereHas('couseType_variations', function ($query1) {
                    $query1->where('course_types.type', '=', 'online');
                })->orWhereHas('couseType_variations', function ($query1) {
                    $now = date("Y-m-d");
                    $query1->where('course_types.type', '=', 'presence')
                        ->where('coursetype_variations.date_from', '>=', $now);
                });
            });
        }

        $courseTypes = $courseTypes->get(["course_types.*"]);


        return view("front.site.search", array(
            "searchtxt" => $searchtxt, "courseTypes" => $courseTypes
        ));
    }

    public function partnership()
    {
        $monthsArr = array(
            1 => "يناير",
            2 => "فبراير",
            3 => "مارس",
            4 => "إبريل",
            5 => "مايو",
            6 => "يونيو",
            7 => "يوليو",
            8 => "أغسطس",
            9 => "سبتمبر",
            10 => "أكتوبر",
            11 => "نوفمبر",
            12 => "ديسمبر",
        );
        $monthsArrAng = array(
            1 => "January",
            2 => "February",
            3 => "March",
            4 => "April",
            5 => "May",
            6 => "June",
            7 => "July",
            8 => "August",
            9 => "September",
            10 => "October",
            11 => "November",
            12 => "December",
        );

        return view('front.site.partnership', compact('monthsArr', 'monthsArrAng'));
    }

    public function postPartnerShip(Request $request)
    {


        if ($request->months != 0 && $request->years != 0) {
            $date1 = $request->months . "/" . $request->days . "/" . $request->years;
            if (!checkdate($request->months, $request->days, $request->years)) {
                if ($request->days == 0)
                    $date1 = $request->months . "/" . "1" . "/" . $request->years;
                else {
                    $date1 = $request->months . "/" . "28" . "/" . $request->years;
                }
            }
            $birthday = date("Y-m-d", strtotime($date1));
        }

        $data = array(
            'category'     => $request->category,
            'name_academy'     => $request->name_academy,
            'full_name'     => $request->full_name,
            'date_birth'    => $birthday,
            'gender'     => $request->gender,
            'country'     => $request->country,
            'city'     => $request->city,
            'email'     => $request->email,
            'phone' => $request->phone,
            'cover_lettre' => $request->cover_lettre,
            'namefirstp' => $request->namefirstp,
            'emailfirstp' => $request->emailfirstp,
            'phonefirstp' => $request->phonefirstp,
            'occufirstp' => $request->occufirstp,
            'namesecondp' => $request->namesecondp,
            'occusecondp' => $request->occusecondp,
            'emailsecondp' => $request->emailsecondp,
            'phonesecondp' => $request->phonesecondp,
            'course_choice' => $request->course_choice,
            'question4' => $request->question4,
            'question5' => $request->question5,
        );


        //
        Mail::send('emails.partnership', $data, function ($message) use ($request) {
            $message->from($request->email);
            $message->to('coordinator@gcss.se')->subject('Partnership');

            //cv
            if (isset($request->resume)) {
                $message->attach(
                    $request['resume']->getRealPath(),
                    array(
                        'as' => $request['resume']->getClientOriginalName() . $request['resume']->getClientOriginalExtension(),
                        'mime' => $request['resume']->getMimeType()
                    )
                );
            }
            //Certificates
            if (isset($request->certificates)) {
                foreach ($request->certificates as $certif) {
                    $message->attach(
                        $certif->getRealPath(),
                        array(
                            'as' => $certif->getClientOriginalName()  . $certif->getClientOriginalExtension(),
                            'mime' => $certif->getMimeType()
                        )
                    );
                }
            }
            //First_person
            if (isset($request->first_person)) {
                $message->attach(
                    $request['first_person']->getRealPath(),
                    array(
                        'as' => $request['first_person']->getClientOriginalName() . $request['first_person']->getClientOriginalExtension(),
                        'mime' => $request['first_person']->getMimeType()
                    )
                );
            }
            //Second person
            if (isset($request->second_person)) {
                $message->attach(
                    $request['second_person']->getRealPath(),
                    array(
                        'as' => $request['second_person']->getClientOriginalName() . $request['second_person']->getClientOriginalExtension(),
                        'mime' => $request['second_person']->getMimeType()
                    )
                );
            }
            //sample_form
            if (isset($request->sample_form)) {
                $message->attach(
                    $request['sample_form']->getRealPath(),
                    array(
                        'as' => $request['sample_form']->getClientOriginalName() . $request['sample_form']->getClientOriginalExtension(),
                        'mime' => $request['sample_form']->getMimeType()
                    )
                );
            }
        });

        return back()->with('message_success', 'Thanks !');
    }
}
