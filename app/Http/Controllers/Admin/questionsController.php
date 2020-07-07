<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Question;
use App\QuestionTranslation;
use App\Answer;

use App\AdminHistory;
use File;
use DB;

class questionsController extends Controller
{
    private $table_name = "questions";
    private $record_name = "question";

	public function __construct() {

    }
	
    public function index(Request $request){
        $quiz = Quiz::findOrFail($request->quiz_id);
        $questions = $quiz->questions;

        return view('admin.questions.index',array(
            "questions"=>$questions,"quiz"=>$quiz,
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
        $quiz = Quiz::findOrFail($request->quiz_id);
        $question = new Question();
        $question_trans_en = new QuestionTranslation();
        $question_trans_ar = new QuestionTranslation();
        //$currency->status = 'active';
        if (!empty($request->old())) {
            $question->fill($request->old());
            $question_trans_en->fillByLang($request->old(),"en");
            $question_trans_ar->fillByLang($request->old(),"en");
        }

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.questions.create', [
            'question' => $question,'question_trans_en'=>$question_trans_en,
            'question_trans_ar'=>$question_trans_ar,'quiz'=>$quiz,
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
                $quiz = Quiz::findOrFail($request->quiz_id);
                $question = new Question();
                $question->quiz_id = $quiz->id;

                $rules = $question->rules();
                $this->validate($request, $rules);

                $question->fill($request->all());
                $question->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Add new question"; 
				$adminhistory->save(); 

                $question_trans = new QuestionTranslation();
                $question_trans->question_id = $question->id;
                $question_trans->fillByLang($request,"en");
                $question_trans->save();

                $question_trans = new QuestionTranslation();
                $question_trans->question_id = $question->id;
                $question_trans->fillByLang($request,"ar");
                $question_trans->save();
                $this->saveAnswers($request,$question);

                $request->session()->flash('alert-success', 'question has been Inserted Successfully...');

            }
        });
        return redirect()->action('Admin\questionsController@create',["quiz_id"=>$request->quiz_id]);
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
        $quiz = Quiz::findOrFail($request->quiz_id);
        $question = $quiz->questions()->where("questions.id",$id)->firstOrFail();
        $question_trans_en = $question->question_trans("en");
        $question_trans_ar = $question->question_trans("ar");

        if (!empty($request->old())) {
            $question->fill($request->old());
            $question_trans_en->fillByLang($request->old(),"en");
            $question_trans_ar->fillByLang($request->old(),"ar");
        }

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.questions.edit', [
            'question' => $question,'question_trans_en'=>$question_trans_en,
            'question_trans_ar'=>$question_trans_ar,'quiz'=>$quiz,
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
            $quiz = Quiz::findOrFail($request->quiz_id);

            $question = Question::findOrFail($id);
            $question->quiz_id = $quiz->id;

            // save posted data
            if ($request->isMethod('patch')) {
                $rules = $question->rules();

                $this->validate($request, $rules);

                // Save question
                $question->fill($request->all());
                $question->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update question"; 
				$adminhistory->save(); 

                $question_trans = $question->question_trans("en");
                if(empty($question_trans))
                    $question_trans = new QuestionTranslation();
                $question_trans->question_id = $question->id;
                $question_trans->fillByLang($request, "en");
                $question_trans->save();

                $question_trans = $question->question_trans("ar");
                if(empty($question_trans))
                    $question_trans = new QuestionTranslation();
                $question_trans->question_id = $question->id;
                $question_trans->fillByLang($request, "ar");
                $question_trans->save();

                $this->saveAnswers($request,$question);
                $request->session()->flash('alert-success', 'question updated successfully...');

            }
        });
        return redirect()->action('Admin\questionsController@edit',[$id,"quiz_id"=>$request->quiz_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete($id){
       Question::findOrFail($id)->delete();
    }

    public function saveAnswers($request,$question){

        //*********** update current discounts***********
        foreach($question->answers as $answer){
            if($request->get("answer_name_ar_".$answer->id)){
                $answer->name_ar = $request->get("answer_name_ar_".$answer->id);
                $answer->name_en = $request->get("answer_name_en_".$answer->id);
                if($request->get("answer_is_correct_".$answer->id))
                    $answer->is_correct = 1;
                else
                    $answer->is_correct = 0;
                $answer->update();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update current discounts"; 
				$adminhistory->save(); 
            }else{
                $answer->delete();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Delete discounts"; 
				$adminhistory->save(); 
            }
        }

        //***********Insert new discounts****************
        $answers = $request->get("answers");
        if(!empty($answers)){
            foreach($answers as $answer){
                $questionAnswer = new Answer();
                $questionAnswer->question_id = $question->id;
                $questionAnswer->name_ar = $answer["name_ar"];
                $questionAnswer->name_en = $answer["name_en"];
                if(isset($answer["is_correct"]) && $answer["is_correct"])
                    $questionAnswer->is_correct = 1;
                else
                    $questionAnswer->is_correct = 0;
                $questionAnswer->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new discounts"; 
				$adminhistory->save(); 
            }
        }
    }

}
