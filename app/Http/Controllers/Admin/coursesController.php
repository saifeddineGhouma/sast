<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\CourseQuestion;
use App\OrderProduct;
use App\StudentCertificate;
use App\StudentQuiz;
use App\StudentVideoExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Course;
use App\CourseTranslation;
use App\Category;
use App\CourseType;
use App\Teacher;
use App\Country;
use App\Government;
use App\CourseTypeVariation;
use App\CourseTypeDevise;
use App\CourseDiscount;
use App\CourseStudy;
use App\VideoExam;
use App\Quiz;
use App\CourseQuiz;
use App\CourseVideoExam;
use App\Certificate;
use App\User;
use App\Student;
use App\OrderproductStudent;
use App\Order;
use App\OrderOnlinepayment;
use App\UserPoint;
use App\Notifications\OrderCreated;
use App\CourseStudyCase ;
use App\CourseStage ;
use Notification;
use Carbon\Carbon;
use App\AdminHistory;
use DB;
use Excel;

class coursesController extends Controller
{
    private $table_name = "courses";
    private $record_name = "course";

    public function __construct() {

    }
    
    public function index(Request $request){
        $courses = Course::search($request)->get();
        $categories = Category::get();
		
        foreach ($courses as $key=> $course) {
            $id = $course->id;
            $StudentByCourses = OrderProduct::whereHas('orderproducts_students', function ($query) use ($id)
            {
            $query->where("course_id", $id);
            })->count();
            $courses[$key]->StudentByCourses = $StudentByCourses;

            $StudentCertifacated = StudentCertificate::where("course_id", $id)->count();
            
            $courses[$key]->StudentCertifacated = $StudentCertifacated;
          
        }
      return view('admin.courses.index',[
          "courses"=>$courses,"categories"=>$categories,
          "table_name"=>$this->table_name,"record_name"=>$this->record_name
      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing(Request $request)
    {
        $courses = Course::search($request)->get();
        foreach ($courses as $key=> $course) {
            $id = $course->id;
            $StudentByCourses = OrderProduct::whereHas('orderproducts_students', function ($query) use ($id)
            {
            $query->where("course_id", $id);
            })->count();
            $courses[$key]->StudentByCourses = $StudentByCourses;

            $StudentCertifacated = StudentCertificate::where("course_id", $id)->count();
            
            $courses[$key]->StudentCertifacated = $StudentCertifacated;
          
        }
        
        $deleted = false;
        if($request->trashed){
            $deleted = true;
        }

        return view('admin.courses._list', [
            'courses' => $courses,"deleted"=>$deleted
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $course = new Course();
        $course->active = 1;

        $course_trans_en = new CourseTranslation();
        $course_trans_ar = new CourseTranslation();

        $course_type_online = new CourseType();
        $course_type_presence = new CourseType();

        //$currency->status = 'active';
        if (!empty($request->old())) {
            $course->fill($request->old());
            $course_trans_en->fillByLang($request->old(),"en");
            $course_trans_ar->fillByLang($request->old(),"en");
        }
        $categories = Category::get();
        $experiencedCourses = Course::where("id","!=",$course->id)->get();
        $countries = Country::get();
        $governments = Government::take(50)->get();

        $teachers = Teacher::get();
        $quizzes = Quiz::where("is_exam",0)->get();
        $exams = Quiz::where("is_exam",1)->get();
        $videoExams = VideoExam::get();
        $certificates = Certificate::get();

        session_start();//to enable kcfinder for authenticated users
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.courses.create', [
            'course' => $course,'course_trans_en'=>$course_trans_en,
            'course_trans_ar'=>$course_trans_ar,'categories'=>$categories,
            'experiencedCourses'=>$experiencedCourses,'exams'=>$exams,
            'videoExams'=>$videoExams,'quizzes'=>$quizzes,'certificates'=>$certificates,
            'course_type_online'=>$course_type_online,'course_type_presence'=>$course_type_presence,
            'countries'=>$countries,'governments'=>$governments,'teachers'=>$teachers,
            "table_name"=>$this->table_name,"record_name"=>$this->record_name
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		

        DB::transaction(function() use($request){

            // save posted data
            if ($request->isMethod('post')) {
                $course = new Course();

                $rules = $course->rules();
                $this->validate($request, $rules);

                $course->fill($request->all());
                if( $request->has('needsExperience') ){
                    $course->needsExperience = true;
                }else{
                    $course->needsExperience = false;
                }
                
                if($request->active)
                    $course->active = 1;
                else
                    $course->active = 0;
                $course->parent_id2 = $request->parent_id2;


               //is langue
                 if($request->is_lang)
                    $course->is_lang = 1;
                else
                    $course->is_lang = 0;

                /*is workshop*/
                if($request->is_workshop)
                    $course->is_workshop = 1;
                else
                    $course->is_workshop = 0;
				
                // description 
                $course->description_all_exam = $request->description_all_exam;
                $course->description_quiz = $request->description_quiz;
                $course->desciption_exam = $request->desciption_exam;
                $course->description_exam_video = $request->description_exam_video;
                $course->description_stage = $request->description_stage;				
				$course->description_study_case = $request->description_study_case;
                /*description en anglais*/
                $course->description_all_exam_en = $request->description_all_exam_en;
                $course->description_quiz_en = $request->description_quiz_en;
                $course->desciption_exam_en = $request->desciption_exam_en;
                $course->description_exam_video_en = $request->description_exam_video_en;
                $course->description_stage_en = $request->description_stage_en;               
                $course->description_study_case_en = $request->description_study_case_en;


                $course->save();
				
				$coursestudycase = new CourseStudyCase();
				if($request->study_case_active)
				{
					$coursestudycase->active =1 ;
				}
					$coursestudycase->course_id= $course->id ;
					
					$coursestudycase->save() ;
					
				// course stage
				
				$coursestage= new CourseStage(); 
				
				if($request->stage_active)
				{
					$coursestage->active =1 ;
				}
					$coursestage->course_id= $course->id ;
					
					$coursestage->save() ;
           				

                $course_trans = new courseTranslation();
                $course_trans->course_id = $course->id;
                $course_trans->fillByLang($request,"en");
                $course_trans->save();

                $course_trans = new courseTranslation();
                $course_trans->course_id = $course->id;
                $course_trans->fillByLang($request,"ar");
                $course_trans->save();

                $course->categories()->sync((array) $request->category_ids);
                if($request->online){
                    $course_type_online = new CourseType();
                    $course_type_online->course_id = $course->id;
                    $course_type_online->type = "online";
                    $course_type_online->points = $request->points;
                    $course_type_online->save();
                    $this->saveVariations($request,$course_type_online);
                }
                if($request->presence){
                    $course_type_presence = new CourseType();
                    $course_type_presence->course_id = $course->id;
                    $course_type_presence->type = "classroom";
                    $course_type_presence->points = $request->presence_points;
                    $course_type_presence->save();
                    $this->saveVariations($request,$course_type_presence);
                }
                $this->saveDiscounts($request,$course);
                $this->saveStudies($request,$course);
                $this->saveExams($request,$course);
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Add new course: ".$request->ar_name; 
				$adminhistory->save(); 
				
                if ($course->save()) {
                    $request->session()->flash('alert-success', 'course has been Inserted Successfully...');
                } 
            }
        });
        return redirect()->action('Admin\coursesController@create');
    }

    public function saveExams($request,$course){

        //*********** update current video exams***********
        $course_videos = $course->courses_videoexams;

        foreach($course_videos as $course_quiz){
            if($request->get("video_videoexam_id_".$course_quiz->id)){
                $course_quiz->videoexam_id = $request->get("video_videoexam_id_".$course_quiz->id);
                if($request->get("video_active_".$course_quiz->id))
                    $course_quiz->active = 1;
                else
                    $course_quiz->active = 0;
				$course_quiz->update();
				
				$course_trans_ar = $course->course_trans("ar");
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current video exams: ".$course_trans_ar->name; 
				$adminhistory->save(); 
				
            }else{
                $course_quiz->delete();
				
				$course_trans_ar = $course->course_trans("ar");
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete video exams: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }
        }

        //***********Insert new video exams****************
        $courses = $request->get("videos");
        if(!empty($courses)){
            foreach($courses as $courseQ){
                if(isset($courseQ["videoexam_id"])){
                    if($course->videoexams()->where("video_exams.id",$courseQ["videoexam_id"])->count()==0){
                        $course_quiz = new CourseVideoExam();
                        $course_quiz->course_id = $course->id;
                        $course_quiz->videoexam_id = $courseQ["videoexam_id"];
                        if(isset($courseQ["active"])&&$courseQ["active"])
                            $course_quiz->active = 1;
                        else
                            $course_quiz->active = 0;
                        $course_quiz->save();
				
						$course_trans_ar = $course->course_trans("ar");
						$adminhistory = new AdminHistory; 
						$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
						$adminhistory->entree=date('Y-m-d H:i:s'); 
						$adminhistory->description="Insert new video exams: ".$course_trans_ar->name; 
						$adminhistory->save(); 
				
                    }
                }

            }
        }



        //*********** update current courses exams***********
        $course_quizzes = $course->courses_quizzes;
        foreach($course_quizzes as $course_quiz){
            if(!empty($request->get("course_quiz_id_".$course_quiz->id))){
                $course_quiz->quiz_id = $request->get("course_quiz_id_".$course_quiz->id);
                if($request->get("course_active_".$course_quiz->id))
                    $course_quiz->active = 1;
                else
                    $course_quiz->active = 0;
                $course_quiz->attempts = $request->get("course_attempts_".$course_quiz->id);
                if($request->get("course_date_start_".$course_quiz->id))
                    $course_quiz->date_start = $request->get("course_date_start_".$course_quiz->id);
                else
                   $course_quiz->date_start = null ;  
               
                $course_quiz->update();
				
				$course_trans_ar = $course->course_trans("ar");
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current courses exams: ".$course_trans_ar->name; 
				$adminhistory->save(); 
				
            }else{
                $course_quiz->delete();
				
				$course_trans_ar = $course->course_trans("ar");
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete courses exams: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }
        }

        //***********Insert new courses exams****************
        $courses = $request->get("courses");
        if(!empty($courses)){
            foreach($courses as $courseQ){
                if(isset($courseQ["quiz_id"])){
                    if($course->quizzes()->where("quizzes.id",$courseQ["quiz_id"])->count()==0){
                        $course_quiz = new CourseQuiz();
                        $course_quiz->course_id = $course->id;
                        $course_quiz->quiz_id = $courseQ["quiz_id"];
                        if(isset($courseQ["active"])&&$courseQ["active"])
                            $course_quiz->active = 1;
                        else
                            $course_quiz->active = 0;
                        if(isset($courseQ["attempts"]))
                            $course_quiz->attempts = $courseQ["attempts"];
                        if(isset($courseQ["date_start"]))
                            $course_quiz->date_start = $courseQ["date_start"];


                        
                        $course_quiz->save();
				
						$course_trans_ar = $course->course_trans("ar");
						$adminhistory = new AdminHistory; 
						$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
						$adminhistory->entree=date('Y-m-d H:i:s'); 
						$adminhistory->description="Insert new courses exams: ".$course_trans_ar->name; 
						$adminhistory->save(); 
                    }
                }

            }
        }
    }



    public function saveVariations($request,$course_type){

        //*********** update current variations***********
        foreach($course_type->couseType_variations as $courseTypeVariation){
            if($request->get("variation".$course_type->type."_teacher_id_".$courseTypeVariation->id)){
                $courseTypeVariation->teacher_id = $request->get("variation".$course_type->type."_teacher_id_".$courseTypeVariation->id);
                if($course_type->type == "classroom"){
                    $courseTypeVariation->govern_id = $request->get("variation".$course_type->type."_govern_id_".$courseTypeVariation->id);
                    $courseTypeVariation->date_from = $request->get("variation".$course_type->type."_date_from_".$courseTypeVariation->id);
                    $courseTypeVariation->date_to = $request->get("variation".$course_type->type."_date_to_".$courseTypeVariation->id);
                }
                $courseTypeVariation->price = $request->get("variation".$course_type->type."_price_".$courseTypeVariation->id);
                $courseTypeVariation->pricesale = $request->get("variation".$course_type->type."_pricesale_".$courseTypeVariation->id);
                $courseTypeVariation->certificate_id = $request->get("variation".$course_type->type."_certificate_id_".$courseTypeVariation->id);
                /*2eme certif*/
                $courseTypeVariation->certificate_id_2 = $request->get("variation".$course_type->type."_certificate_id_2".$courseTypeVariation->id);

                $courseTypeVariation->priceautre = $request->get("variation".$course_type->type."_priceautre_".$courseTypeVariation->id);
                $courseTypeVariation->devise = $request->get("variation".$course_type->type."_pricedevise_".$courseTypeVariation->id);
                $courseTypeVariation->update();
				
				$course = Course::findOrFail($course_type->course_id);
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current variations: ".$course_trans_ar->name; 
				$adminhistory->save(); 
				
            }else{
                $courseTypeVariation->delete();
				
				$course = Course::findOrFail($course_type->course_id);
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete variations: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }
        }

        //***********Insert new variations****************
        $variations = $request->get("variations".$course_type->type);
        if(!empty($variations)){
            foreach($variations as $variation){
                $coursetype_variation = new CourseTypeVariation();
                $coursetype_variation->coursetype_id = $course_type->id;
                $coursetype_variation->teacher_id = $variation["teacher_id"];
                if($course_type->type == "classroom"){
                    $coursetype_variation->govern_id = $variation["govern_id"];
                    $coursetype_variation->date_from = $variation["date_from"];
                    $coursetype_variation->date_to = $variation["date_to"];
                }
                $coursetype_variation->price = $variation["price"];
                /*$courseTypeVariation->pricesale = $variation["pricesale"];*/
                $coursetype_variation->certificate_id = $variation["certificate_id"];
                $coursetype_variation->priceautre = $variation["priceautre"];
                $coursetype_variation->devise = $variation["pricedevise"];
                $coursetype_variation->save();
				
				$course = Course::findOrFail($course_type->course_id);
				$course_trans_ar = $course->course_trans("ar");
				

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new variations: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }
        }
    }

    public function saveDiscounts($request,$course){

        //*********** update current discounts***********
        foreach($course->courseDiscounts as $courseDiscount){
            if($request->get("discount_num_students_".$courseDiscount->id)||$request->get("discount_discount_".$courseDiscount->id)){
                $courseDiscount->num_students = $request->get("discount_num_students_".$courseDiscount->id);
                $courseDiscount->discount = $request->get("discount_discount_".$courseDiscount->id);
                $types = implode(",",(array)$request->get("discount_type_".$courseDiscount->id));
                $courseDiscount->type = $types;
                $courseDiscount->update();
				
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current discounts: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }else{
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete current discounts: ".$course_trans_ar->name; 
				$adminhistory->save(); 
				
                $courseDiscount->delete();
            }
        }

        //***********Insert new discounts****************
        $discounts = $request->get("discounts");
        if(!empty($discounts)){
            foreach($discounts as $discount){
                $courseDiscount = new CourseDiscount();
                $courseDiscount->course_id = $course->id;
                $courseDiscount->num_students = $discount["num_students"];
                $courseDiscount->discount = $discount["discount"];
                $types = implode(",",(array)$discount["type"]);
                $courseDiscount->type = $types;
                $courseDiscount->save();
				
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new discounts: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }
        }
    }

    public function saveStudies($request,$course){

        //*********** update current studies***********
        foreach($course->courseStudies as $courseStudy){
            if($request->get("study_name_ar_".$courseStudy->id)){
                $courseStudy->name_ar = $request->get("study_name_ar_".$courseStudy->id);
                $courseStudy->name_en = $request->get("study_name_en_".$courseStudy->id);
                $courseStudy->type = $request->get("study_type_".$courseStudy->id);
                $courseStudy->lang = $request->get("study_lang_".$courseStudy->id);
                if($request->get("study_type_".$courseStudy->id)=="pdf"){
                    $courseStudy->url = $request->get("study_pdf_".$courseStudy->id);
                }elseif($request->get("study_type_".$courseStudy->id)=="video"){
                    $courseStudy->url = $request->get("study_url_".$courseStudy->id);
                }else{
                    $courseStudy->content = $request->get("study_content_".$courseStudy->id);
                }
                if(!empty($request->get("study_duration_".$courseStudy->id)))
                    $courseStudy->duration = $request->get("study_duration_".$courseStudy->id);
                else
                    $courseStudy->duration = 0;
                if($request->get("study_only_registered_".$courseStudy->id))
                    $courseStudy->only_registered = 1;
                else
                    $courseStudy->only_registered = 0;
                $courseStudy->update();
				
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current studies: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }else{
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete current studies: ".$course_trans_ar->name; 
				$adminhistory->save(); 
				
                $courseStudy->delete();
            }
        }

        //***********Insert new studies****************
        $studies = $request->get("studies");

        if(!empty($studies)){
            foreach($studies as $study){
                $courseStudy = new CourseStudy();
                $courseStudy->course_id = $course->id;
                $courseStudy->name_ar = $study["name_ar"];
                $courseStudy->name_en = $study["name_en"];
                $courseStudy->type = $study["type"];
                $courseStudy->lang = $study["lang"];
                if($study["type"]=="pdf"){
                    $courseStudy->url = $study["pdf"];
                }else if($study["type"]=="video"){
                    $courseStudy->url = $study["url"];
                }else{
                    $courseStudy->content = $study["content"];
                }
                if(!empty($study["duration"]))
                    $courseStudy->duration = $study["duration"];
                else
                    $courseStudy->duration = 0;
                if(!empty($study["only_registered"])&&$study["only_registered"])
                    $courseStudy->only_registered = 1;
                else
                    $courseStudy->only_registered = 0;
                $courseStudy->save();
				
				$course_trans_ar = $course->course_trans("ar");

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new studies: ".$course_trans_ar->name; 
				$adminhistory->save(); 
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $course = Course::findOrFail($id);
        $course_trans_en = $course->course_trans("en");
        $course_trans_ar = $course->course_trans("ar");

        $course_type_online = $course->courseTypes()->where("type","online")->first();
        if(empty($course_type_online)){
            $course_type_online = new CourseType();
        }
        $course_type_presence = $course->courseTypes()->where("type","classroom")->first();
        if(empty($course_type_presence)){
            $course_type_presence = new CourseType();
        }


        if (!empty($request->old())) {
            $course->fill($request->old());
            $course_trans_en->fillByLang($request->old(),"en");
            $course_trans_ar->fillByLang($request->old(),"ar");
        }
        $categories = Category::get();
        $experiencedCourses = Course::where("id","!=",$course->id)->get();
        $countries = Country::get();
        $governments = Government::take(50)->get();
        $teachers = Teacher::get();
        $quizzes = Quiz::where("is_exam",0)->get();
        $exams = Quiz::where("is_exam",1)->get();
        $videoExams = VideoExam::get();
        $certificates = Certificate::get();
        $courses = Course::where("id","!=",$course->id)->get();

        session_start();//to enable kcfinder for authenticated users
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.courses.edit', [
            'course' => $course,'course_trans_en'=>$course_trans_en,
            'course_trans_ar'=>$course_trans_ar,'categories'=>$categories,
            'experiencedCourses'=>$experiencedCourses,'exams'=>$exams,
            'videoExams'=>$videoExams,'quizzes'=>$quizzes,'certificates'=>$certificates,
            'course_type_online'=>$course_type_online,'course_type_presence'=>$course_type_presence,
            'countries'=>$countries,'governments'=>$governments,'teachers'=>$teachers,"courses"=>$courses,
            "table_name"=>$this->table_name,"record_name"=>$this->record_name
        ]);
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
        DB::transaction(function() use($request,$id) {
            $course = course::findOrFail($id);

            // save posted data
            if ($request->isMethod('patch')) {
                $rules = $course->rules();

                $this->validate($request, $rules);

                // Save course 
                $course->fill($request->all());
                if($request->active)
                    $course->active = 1;
                else
                    $course->active = 0;

                if( $request->has('needsExperience') ){
                    $course->needsExperience = true;
                }else{
                    $course->needsExperience = false;
                }
                $course->parent_id2 = $request->parent_id2;
                
				//is langue

                 if($request->is_lang)
                   
                    $course->is_lang = 1;
                 
                else
                 {
                    $course->is_lang = 0;
				  
                 }
                 //is workshop

                 if($request->is_workshop)
                   
                    $course->is_workshop = 1;
                 
                else
                 {
                    $course->is_workshop = 0;
                  
                 }
                // description
                $course->description_all_exam = $request->description_all_exam;
                $course->description_quiz = $request->description_quiz;
                $course->desciption_exam = $request->desciption_exam;
                $course->description_exam_video = $request->description_exam_video;
                $course->description_stage = $request->description_stage;                
				$course->description_study_case = $request->description_study_case;
                 /*description en anglais*/
                $course->description_all_exam_en = $request->description_all_exam_en;
                $course->description_quiz_en = $request->description_quiz_en;
                $course->desciption_exam_en = $request->desciption_exam_en;
                $course->description_exam_video_en = $request->description_exam_video_en;
                $course->description_stage_en = $request->description_stage_en;               
                $course->description_study_case_en = $request->description_study_case_en;
                $course->save();

//study case 
              $coursestudycase =  CourseStudyCase::where('course_id',$id)->first();
			  
            if(empty($coursestudycase))
			{
				 $coursestudycase = new   CourseStudyCase();
				
			}
				if($request->study_case_active)
				{
					$coursestudycase->active =1 ;
				}else{
					$coursestudycase->active=0 ;
					
				}
					$coursestudycase->course_id= $id ;
					
					$coursestudycase->save() ;
					
					
					
// course stage
				
				$coursestage=  CourseStage::where('course_id',$id)->first();
				 if(empty($coursestage))
			{
				 $coursestage = new   CourseStage();
				
			}
				
				if($request->stage_active)
				{
					$coursestage->active =1 ;
				}else{
					$coursestage->active=0 ;
					
				}
					$coursestage->course_id= $id ;
					
					$coursestage->save() ;


                     
                $course_trans = $course->course_trans("en");
                if(empty($course_trans))
                    $course_trans = new courseTranslation();
                $course_trans->course_id = $course->id;
                $course_trans->fillByLang($request, "en");
                $course_trans->save();

                $course_trans = $course->course_trans("ar");
                if(empty($course_trans))
                    $course_trans = new courseTranslation();
                $course_trans->course_id = $course->id;
                $course_trans->fillByLang($request, "ar");
                $course_trans->save();

                $course->categories()->sync((array) $request->category_ids);
                $course_type_online = $course->courseTypes()->where("type","online")->first();
                if($request->online){
                    if(empty($course_type_online))
                        $course_type_online = new CourseType();
                    $course_type_online->course_id = $course->id;
                    $course_type_online->type = "online";
                    $course_type_online->points = $request->points;
                    $course_type_online->save();
                    $this->saveVariations($request,$course_type_online);
                }else{
                    if(!empty($course_type_online)){
                        $course_type_online->delete();
                    }
                }

                $course_type_presence = $course->courseTypes()->where("type","classroom")->first();
                if($request->presence){
                    if(empty($course_type_presence))
                        $course_type_presence = new CourseType();
                    $course_type_presence->course_id = $course->id;
                    $course_type_presence->type = "classroom";
                    $course_type_presence->points = $request->presence_points;
                    $course_type_presence->save();
                    $this->saveVariations($request,$course_type_presence);
                }else{
                    if(!empty($course_type_presence)){
                        $course_type_presence->delete();
                    }
                }
                $this->saveDiscounts($request,$course);
                $this->saveStudies($request,$course);
                $this->saveExams($request,$course);

                if ($course->save()) {
                    $request->session()->flash('alert-success', 'course updated successfully...');
                }
            }
        });
        return redirect()->action('Admin\coursesController@edit',[$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete($id){
       Course::findOrFail($id)->forcedelete();
    }
    
    public function uniqueSlug(Request $request){
        $id =  $request->id;
        $validator=Validator::make($request->toArray(),
                     array(
                        'slug' => '|unique:course_translations,slug,'.$id.',course_id',
                    ));     

        // Finally, return a JSON
        echo json_encode(array(
            'valid' => !$validator->fails(),
        ));
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

        $course = Course::find($ID);
        $course->$field=$newsate;
        $course->update();
    }

    public function governments(Request $request){
        $countryId = $request->get("countryId");

        $governments = Government::with("country");
        if($countryId!=0)
            $governments = $governments->where('country_id',$countryId);
        $governments = $governments->get();

//        echo '<option value="0">choose... </option>';

        if(!$governments->isEmpty()){
            foreach($governments as $government){
                echo '<option value="'.$government->id.'">'.$government->government_trans("en")->name.'</option>';
            }
        }
    }

    public function postMerge(Request $request){
        DB::transaction(function() use($request) {
            $course_ids = (array)$request->course_ids;
            $id = $request->course_id;
            $course = Course::findOrFail($id);
            if (count($course_ids) > 0) {
                foreach ($course_ids as $course_id) {
                    $coursesCategories = \App\CourseCategory::where("course_id", $course_id)
                        ->get();
                    foreach ($coursesCategories as $courseCategory) {
                        if ($course->categories()->where("categories.id", $courseCategory->category_id)->count() == 0) {
                            $courseCategory->course_id = $course->id;
                            $courseCategory->save();
                        }
                    }
                    $coursesQuizzes = CourseQuiz::where("course_id", $course_id)
                        ->get();
                    foreach ($coursesQuizzes as $coursesQuiz) {
                        if ($course->courses_quizzes()->where("courses_quizzes.quiz_id", $coursesQuiz->quiz_id)->count() == 0) {
                            $coursesQuiz->course_id = $course->id;
                            $coursesQuiz->save();
                        }
                    }

                    $coursesVideos = CourseVideoExam::where("course_id", $course_id)
                        ->get();
                    foreach ($coursesVideos as $courseVideo) {
                        if ($course->courses_videoexams()->where("courses_videoexams.videoexam_id", $courseVideo->videoexam_id)->count() == 0) {
                            $courseVideo->course_id = $course->id;
                            $courseVideo->save();
                        }
                    }

                    $courseTypes = CourseType::where("course_id",$course_id)->get();
                    foreach ($courseTypes as $courseType) {
                        if ($course->courseTypes()->where("course_types.type", $courseType->type)->count() == 0) {
                            $courseType->course_id = $course->id;
                            $courseType->save();
                        }else{
                            $courseTypeVariations = CourseTypeVariation::where("coursetype_id",$courseType->id)->get();
                            foreach($courseTypeVariations as $courseTypeVariation){
                                $coursetypetmp = $course->courseTypes()->where("course_types.type", $courseType->type)->first();

                                $courseTypeVariation->coursetype_id = $coursetypetmp->id;
                                $courseTypeVariation->save();
                            }
                        }
                    }

                    $coursesQuestions = CourseQuestion::where("course_id", $course_id)->get();
                    foreach ($coursesQuestions as $coursesQuestion) {
                        $coursesQuestion->course_id = $course->id;
                        $coursesQuestion->save();
                    }

                    $orderProducts = OrderProduct::where("course_id", $course_id)->get();
                    foreach ($orderProducts as $orderProduct) {
                        $orderProduct->course_id = $course->id;
                        $orderProduct->save();
                    }

                    $studentCertificates = StudentCertificate::where("course_id", $course_id)->get();
                    foreach ($studentCertificates as $studentCertificate) {
                        $studentCertificate->course_id = $course->id;
                        $studentCertificate->save();
                    }

                    $studentQuizzes = StudentQuiz::where("course_id", $course_id)->get();
                    foreach ($studentQuizzes as $studentQuiz) {
                        $studentQuiz->course_id = $course->id;
                        $studentQuiz->save();
                    }

                    $studentVideos = StudentVideoExam::where("course_id", $course_id)->get();
                    foreach ($studentVideos as $studentVideo) {
                        $studentVideo->course_id = $course->id;
                        $studentVideo->save();
                    }

                    Course::find($course_id)->forcedelete();

                }
                $request->session()->flash('alert-success', 'Courses Merged Successfully...');
            } else {
                $request->session()->flash('alert-danger', 'no thing to merge...');
            }
        });
        return redirect()->action('Admin\coursesController@edit',[$request->course_id]);
    }
    public function postImport(Request $request)
    {
        DB::transaction(function () use ($request) {
            if(Input::hasFile('file')){
                $file= $request->file('file');
                $fileName=$file->getClientOriginalName();
                $coursetypeVariation_ids = (array)$request->coursetypeVariation_ids;
                if (count($coursetypeVariation_ids) > 0) {
                    foreach ($coursetypeVariation_ids as $coursetypeVariation_id) {
                        $courseTypeVariation = CourseTypeVariation::find($coursetypeVariation_id);
                        if(!empty($courseTypeVariation)){
                            Excel::load($file, function($reader) use($request,$courseTypeVariation) {

                                $reader->each(function($row) use($request,$courseTypeVariation) {
                                    if(!empty(trim($row->full_name_ar)) && !empty(trim($row->email))){
                                        $user = User::where("email",trim($row->email))->first();
                                        if(empty($user)){
                                            $user = new User();
                                            $user->fill($row->toArray());
                                            $tempUserCount = User::where("username",$row->username)->count();
                                            if($tempUserCount>0){
                                                $user->username = $row->username.str_random(2);
                                            }
                                            if(trim($row->username)==""){
                                                $user->username = str_random(5);
                                            }
                                            if(trim($row->password)!="")
                                                $user->password = bcrypt(trim($request->password));
                                            else{
                                                $user->password = bcrypt(str_random(7));
                                            }
                                            $user->auth_key = str_random(40);
                                            $user->auth_mobile_key = rand(1111,9999);
                                            $user->save();
                                        }else{
                                            $username = $user->username;
                                            $user->fill($row->toArray());
                                            if(trim($row->username)==""){
                                                $user->username = $username;
                                            }
                                            $user->save();
                                        }
                                        $student=$user->student;
                                        if(empty($student)){
                                            $student = new Student();
                                            $student->id = $user->id;
                                            $student->save();
                                        }
                                        $agent = Agent::where('email',trim($row->agent_email))->first();
                                        $order = new Order();
                                        $order->user_id = $user->id;
                                        if(!empty($agent))
                                            $order->payment_method = "agent";
                                        else
                                            $order->payment_method = "cash";
                                        $total = $courseTypeVariation->price;
                                        $setting = App('setting');
                                        $order->vat = $setting->vat*$total/100;
                                        $order->total = $total + $setting->vat*$total/100;
                                        $order->save();

                                        $orderPayment = new OrderOnlinepayment();
                                        $orderPayment->order_id = $order->id;
                                        $orderPayment->payment_status = "paid";
                                        $orderPayment->payment_method = $order->payment_method;
                                        if(!empty($agent))
                                            $orderPayment->agent_id = $agent->id;

                                        $orderPayment->total = $order->total;
                                        $orderPayment->save();

                                        $orderProduct = new OrderProduct();
                                        $orderProduct->order_id=$order->id;
                                        $promoPoints = 0;
                                        $courseType = $courseTypeVariation->courseType;
                                        $orderProduct->coursetypevariation_id=$courseTypeVariation->id;
                                        $orderProduct->course_id=$courseType->course_id;
                                        $orderProduct->num_students=1;
                                        $orderProduct->price=$courseTypeVariation->price;
                                        $orderProduct->total=$courseTypeVariation->price;
                                        $orderProduct->save();

                                        $orderProductStudent = new OrderproductStudent();
                                        $orderProductStudent->orderproduct_id = $orderProduct->id;
                                        $orderProductStudent->student_id = $student->id;
                                        $orderProductStudent->save();

                                        if($courseType->points>0){
                                            $userpoint = new UserPoint();
                                            $userpoint->user_id=$user->id;
                                            $userpoint->orderproduct_id=$orderProduct->id;
                                            $userpoint->points=$courseType->points;
                                            $userpoint->save();
                                        }


                                        $admins = \App\Admin::get();
                                        //Notification::send($admins, new OrderCreated($order->id,$order->total,$user->username,$order));
                                        //$user->notify(new OrderCreated($order->id,$order->total,$user->username,$order));

                                    }
                                });

                            })->get();
                        }
                    }
                }

            }
        });
        $request->session()->flash('alert-success', 'Users has been Imported successfully...');
        return redirect()->back();
    }



   public function activeFreeCourses()
   {
        $course_type_variation_ids = courseTypeVariation::where('price',0.00)->pluck('coursetype_id');
        $course_ids = CourseType::whereIn('id',$course_type_variation_ids)->pluck('course_id') ;
        $courses = Course::whereIn('id',$course_ids)->get();
        foreach ($courses  as $key => $course) {
              $today = Carbon::now();
              $course_date = $course->updated_at ;
              $difference = $course_date->diffInMonths($today,false);
               if($difference >= 1 && $course->active ==1)
                 {
                     $course->active = 0 ;
                     $course->update();
                     if(!empty( $courses[$key+1]))
                     {
                        $courses[$key+1]->active = 1 ;
                        $courses[$key+1]->update() ;
                     }else{
                        $courses[0]->active = 1 ;
                        $courses[0]->update() ;
                     }
                 }
        }
   }
	public function script(Request $request){
		$course_ids = array(1 => 15, 2 => 265, 3 => 267, 4 => 272, 5 => 277, 6 => 283, 7 => 284, 7 => 288, 7 => 293, 7 => 297, 7 => 300, 7 => 302, 7 => 303, 7 => 324);
		
		$courseTypeVariation = CourseTypeVariation::find(106);
		foreach($course_ids as $course_id){
			$course = Course::find($course_id);
			$certificates_sql  = StudentCertificate::where('course_id',$course_id)->toSql(); 
			$certificates  = StudentCertificate::where('course_id',$course_id)->get(); 
			print_r($certificates_sql.' '.$course_id.' '.$certificates->count().'<br>');
			foreach($certificates as $certificate){
				$user = $certificate->student->user;
				print_r($user->full_name_ar.' '.$user->id.'<br>');
                $order = new Order();
                $order->user_id = $user->id;
                $order->payment_method = "cash";
                $total = $courseTypeVariation->price;
                $setting = App('setting');
                $order->vat = $setting->vat*$total/100;
                $order->total = $total + $setting->vat*$total/100;
                $order->save();

                $orderPayment = new OrderOnlinepayment();
                $orderPayment->order_id = $order->id;
                $orderPayment->payment_status = "paid";
                $orderPayment->payment_method = $order->payment_method;

                $orderPayment->total = $order->total;
                $orderPayment->save();

                $orderProduct = new OrderProduct();
                $orderProduct->order_id=$order->id;
                $promoPoints = 0;
                $courseType = $courseTypeVariation->courseType;
                $orderProduct->coursetypevariation_id=$courseTypeVariation->id;
                $orderProduct->course_id=$courseType->course_id;
                $orderProduct->num_students=1;
                $orderProduct->price=$courseTypeVariation->price;
                $orderProduct->total=$courseTypeVariation->price;
                $orderProduct->save();

                $orderProductStudent = new OrderproductStudent();
                $orderProductStudent->orderproduct_id = $orderProduct->id;
                $orderProductStudent->student_id = $user->student->id;
                $orderProductStudent->save();

				try {
					$user->notify(new EmailNotif($user,$course,$order));
				}catch (\Exception $e) {
					print_r($user->full_name_ar.' email not supported error <br>');
				}
			}
		}

    }

}
