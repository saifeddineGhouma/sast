<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\QuizTranslation;
use App\Course;
use App\CourseQuiz;

use App\AdminHistory;
use File;
use DB;

class quizzesController extends Controller
{
    private $table_name = "quizzes";
    private $record_name = "quiz";

	public function __construct() {

    }
	
    public function index(Request $request){
   	  $quizzes = Quiz::search($request)->get();

        if(!empty(request()->exam)&&request()->exam){
            $this->table_name = "exams";
            $this->record_name = "exam";
        }
      return view('admin.quizzes.index',array(
          "quizzes"=>$quizzes,
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
        $quiz = new Quiz();
        $quiz_trans_en = new QuizTranslation();
        $quiz_trans_ar = new QuizTranslation();
        //$currency->status = 'active';
        if (!empty($request->old())) {
            $quiz->fill($request->old());
            $quiz_trans_en->fillByLang($request->old(),"en");
            $quiz_trans_ar->fillByLang($request->old(),"en");
        }


        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        if(!empty(request()->exam)&&request()->exam){
            $this->record_name = "exam";
            $quiz->is_exam = 1;
            //$courses = Course::notReqisteredVideos()->get();
        }
        $courses = Course::get();
        $from_section= "quiz";
        if($quiz->is_exam)
            $from_section= "exam";

        return view('admin.quizzes.create', [
            'quiz' => $quiz,'quiz_trans_en'=>$quiz_trans_en,'from_section'=>$from_section,
            'quiz_trans_ar'=>$quiz_trans_ar,'courses'=>$courses,
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
                $quiz = new Quiz();

                $rules = $quiz->rules();
                $this->validate($request, $rules);

                $quiz->fill($request->all());
                if(!empty($request->exam)&&$request->exam){
                    $quiz->is_exam = 1;
                    $quiz->num_questions = $request->num_questions;
                }else
                    $quiz->is_exam = 0;
                $quiz->lang = $request->lang;
                $quiz->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Add new quiz"; 
				$adminhistory->save();

                $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quiz->id;
                $quiz_trans->fillByLang($request,"en");
                $quiz_trans->save();

                $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quiz->id;
                $quiz_trans->fillByLang($request,"ar");
                $quiz_trans->save();
                $this->saveCourses($request,$quiz);

                if ($quiz->save()) {
                    $request->session()->flash('alert-success', 'quiz has been Inserted Successfully...');
                }
            }
        });
        if(!empty($request->exam)&&$request->exam)
            return redirect('admin/quizzes/create?exam=1');
        else
            return redirect()->action('Admin\quizzesController@create');
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
        $quiz = Quiz::findOrFail($id);
        $quiz_trans_en = $quiz->quiz_trans("en");
        $quiz_trans_ar = $quiz->quiz_trans("ar");

        if (!empty($request->old())) {
            $quiz->fill($request->old());
            $quiz_trans_en->fillByLang($request->old(),"en");
            $quiz_trans_ar->fillByLang($request->old(),"ar");
        }


        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        if($quiz->is_exam){
            $this->record_name = "exam";
            //$courses = Course::notReqisteredVideos()->get();
        }
        $courses = Course::get();
        $from_section= "quiz";
        if($quiz->is_exam)
            $from_section= "exam";

        return view('admin.quizzes.edit', [
            'quiz' => $quiz,'quiz_trans_en'=>$quiz_trans_en,'from_section'=>$from_section,
            'quiz_trans_ar'=>$quiz_trans_ar,'courses'=>$courses,
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
            $quiz = Quiz::findOrFail($id);

            // save posted data
            if ($request->isMethod('patch')) {
                $rules = $quiz->rules();

                $this->validate($request, $rules);

                // Save quiz
                $quiz->fill($request->all());
                if(!empty($request->exam)&&$request->exam){
                    $quiz->num_questions = $request->num_questions;
                }
                $quiz->lang = $request->lang;
                $quiz->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update quiz"; 
				$adminhistory->save();

                $quiz_trans = $quiz->quiz_trans("en");
                if(empty($quiz_trans))
                    $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quiz->id;
                $quiz_trans->fillByLang($request, "en");
                $quiz_trans->save();

                $quiz_trans = $quiz->quiz_trans("ar");
                if(empty($quiz_trans))
                    $quiz_trans = new QuizTranslation();
                $quiz_trans->quiz_id = $quiz->id;
                $quiz_trans->fillByLang($request, "ar");
                $quiz_trans->save();
                $this->saveCourses($request,$quiz);

                if ($quiz->save()) {
                    $request->session()->flash('alert-success', 'quiz updated successfully...');
                }
            }
        });
        return redirect()->action('Admin\quizzesController@edit',[$id]);
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
                $course_exam->attempts = $request->get("course_attempts_".$course_exam->id);
                $course_exam->update();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current courses exams"; 
				$adminhistory->save();
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
                        $course_exam = new CourseQuiz();
                        $course_exam->quiz_id = $exam->id;
                        $course_exam->course_id = $course["course_id"];
                        if(isset($course["active"])&&$course["active"])
                            $course_exam->active = 1;
                        else
                            $course_exam->active = 0;
                        if(isset($course["attempts"]))
                            $course_exam->attempts = $course["attempts"];
                        $course_exam->save();
				
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new courses exams"; 
				$adminhistory->save();
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
       Quiz::findOrFail($id)->delete();
    }

    public function uniqueName(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'name' => '|unique:quizzes_translations,name,'.$id.',quiz_id',
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}
 	
	public function uniqueSlug(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'slug' => '|unique:quizzes_translations,slug,'.$id.',quiz_id',
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}

}
