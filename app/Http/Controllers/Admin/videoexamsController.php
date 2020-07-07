<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\VideoExam;
use App\VideoExamTranslation;
use App\Course;
use App\CourseVideoExam;

use App\AdminHistory;
use File;
use DB;

class videoexamsController extends Controller
{
    private $table_name = "videoexams";
    private $record_name = "videoExam";

	public function __construct() {

    }
	
    public function index(Request $request){
   	  $videoexams = VideoExam::search($request)->get();
	  
      return view('admin.videoexams.index',array(
          "videoexams"=>$videoexams,
          "table_name"=>$this->table_name,"record_name"=>$this->record_name
      ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $videoExam = new VideoExam();
        $videoExam_trans_en = new VideoExamTranslation();
        $videoExam_trans_ar = new VideoExamTranslation();
        //$currency->status = 'active';
        if (!empty($request->old())) {
            $videoExam->fill($request->old());
            $videoExam_trans_en->fillByLang($request->old(),"en");
            $videoExam_trans_ar->fillByLang($request->old(),"en");
        }
        $courses = Course::get();

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        $from_section= "video";

        return view('admin.videoexams.create', [
            'videoExam' => $videoExam,'videoExam_trans_en'=>$videoExam_trans_en,
            'videoExam_trans_ar'=>$videoExam_trans_ar,'courses'=>$courses,'from_section'=>$from_section,
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
                $videoExam = new VideoExam();

                $rules = $videoExam->rules();
                $this->validate($request, $rules);

                //$videoExam->fill($request->all());
                $videoExam->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new video Exam"; 
				$adminhistory->save(); 

                $videoExam_trans = new VideoExamTranslation();
                $videoExam_trans->videoExam_id = $videoExam->id;
                $videoExam_trans->fillByLang($request,"en");
                $videoExam_trans->save();

                $videoExam_trans = new VideoExamTranslation();
                $videoExam_trans->videoExam_id = $videoExam->id;
                $videoExam_trans->fillByLang($request,"ar");
                $videoExam_trans->save();
                $this->saveCourses($request,$videoExam);

                if ($videoExam->save()) {
                    $request->session()->flash('alert-success', 'videoExam has been Inserted Successfully...');
                }
            }
        });
        return redirect()->action('Admin\videoexamsController@create');
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
        $videoExam = VideoExam::findOrFail($id);
        $videoExam_trans_en = $videoExam->videoExam_trans("en");
        $videoExam_trans_ar = $videoExam->videoExam_trans("ar");

        if (!empty($request->old())) {
            $videoExam->fill($request->old());
            $videoExam_trans_en->fillByLang($request->old(),"en");
            $videoExam_trans_ar->fillByLang($request->old(),"ar");
        }

        $courses = Course::get();

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;
        $from_section= "video";

        return view('admin.videoexams.edit', [
            'videoExam' => $videoExam,'videoExam_trans_en'=>$videoExam_trans_en,
            'videoExam_trans_ar'=>$videoExam_trans_ar,'courses'=>$courses,'from_section'=>$from_section,
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
            $videoExam = VideoExam::findOrFail($id);

            // save posted data
            if ($request->isMethod('patch')) {
                $rules = $videoExam->rules();

                $this->validate($request, $rules);

                // Save videoExam
                //$videoExam->fill($request->all());
                $videoExam->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update video Exam"; 
				$adminhistory->save(); 

                $videoExam_trans = $videoExam->videoExam_trans("en");
                if(empty($videoExam_trans))
                    $videoExam_trans = new VideoExamTranslation();
                $videoExam_trans->videoExam_id = $videoExam->id;
                $videoExam_trans->fillByLang($request, "en");
                $videoExam_trans->save();

                $videoExam_trans = $videoExam->videoExam_trans("ar");
                if(empty($videoExam_trans))
                    $videoExam_trans = new VideoExamTranslation();
                $videoExam_trans->videoExam_id = $videoExam->id;
                $videoExam_trans->fillByLang($request, "ar");
                $videoExam_trans->save();
                $this->saveCourses($request,$videoExam);

                if ($videoExam->save()) {
                    $request->session()->flash('alert-success', 'videoExam updated successfully...');
                }
            }
        });
        return redirect()->action('Admin\videoexamsController@edit',[$id]);
    }

    public function saveCourses($request,$exam){

        //*********** update current courses exams***********
        foreach($exam->courses_exams as $course_exam){
            if($request->get("course_course_id_".$course_exam->id)){
                $course_exam->course_id = $request->get("course_course_id_".$course_exam->id);
                if($request->get("course_active_".$course_exam->id))
                    $course_exam->active = 1;
                else
                    $course_exam->active = 0;
                $course_exam->update();
            }else{
                $course_exam->delete();
            }
        }

        //***********Insert new courses exams****************
        $courses = $request->get("courses");
        if(!empty($courses)){
            foreach($courses as $course){
                if(isset($course["course_id"])){
                    if($exam->courses_exams()->where("course_id",$course["course_id"])->count()==0){
                        $course_exam = new CourseVideoExam();
                        $course_exam->videoexam_id = $exam->id;
                        $course_exam->course_id = $course["course_id"];
                        if(isset($course["active"])&&$course["active"])
                            $course_exam->active = 1;
                        else
                            $course_exam->active = 0;

                        $course_exam->save();
                    }
                }

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete($id){
       VideoExam::findOrFail($id)->delete();
    }
   

	public function uniqueSlug(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'slug' => '|unique:videoexams_translations,slug,'.$id.',videoexam_id',
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}

}
