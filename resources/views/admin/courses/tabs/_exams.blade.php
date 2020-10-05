<div class="form-group">
    <label class="col-md-2 control-label">Exam Period</label>
    <div class="col-md-10">
        <input type="text" name="exam_period" class="form-control touchspin_2" value="{{$course->exam_period or 0}}">
        <span class="help-inline">allowed time to make an exam after expired student will pay for exam</span>
    </div>
</div>

<h3 class="form-section">Quizzes</h3>
@php
    $course_quizzes = $course->courses_quizzes()
            ->join("quizzes","quizzes.id","=","courses_quizzes.quiz_id")
            ->where("quizzes.is_exam",0)->get(["courses_quizzes.*"]);
@endphp

@include("admin.courses._exams_table",[
    'course_quizzes'=>$course_quizzes,'from_section'=>'quiz',
    'examData'=>$quizzes
])

<h3 class="form-section">Video Exams</h3>
@php
    $course_videos = $course->courses_videoexams;
@endphp

@include("admin.courses._exams_table",[
    'course_quizzes'=>$course_videos,'from_section'=>'video',
    'examData'=>null
])

<h3 class="form-section">Final Exams</h3>
@php
    $course_exams = $course->courses_quizzes()
            ->join("quizzes","quizzes.id","=","courses_quizzes.quiz_id")
            ->where("quizzes.is_exam",1)->get(["courses_quizzes.*"]);
@endphp

@include("admin.courses._exams_table",[
    'course_quizzes'=>$course_exams,'from_section'=>'exam',
    'examData'=>$exams
])

@php 
if(isset($course))
	
{
	$studycase= App\CourseStudyCase::where('course_id',$course->id)->first();
	
	
	if(isset($studycase) && $studycase->active)
		$checked_study_case="checked";
	else
		$checked_study_case="";
		
}
else{
	$checked_study_case="";
}

@endphp
@php 

if(isset($course))
{
	$coursestage= App\CourseStage::where('course_id',$course->id)->first();
	
	if(isset($coursestage) && $coursestage->active)
		$checked_Stage="checked";
	else
		$checked_Stage="";
		
}
else{
	$checked_Stage="";
}

@endphp

<h3 class="form-section">Stage</h3>
<div class="form-check">
    <input type="checkbox" name="stage_active" class="form-check-input" value="1"id="exampleCheck1" {{ $checked_Stage }} >
    <label class="form-check-label" for="exampleCheck1">Active</label>
  </div>

<h3 class="form-section">Study Case</h3>

<div class="form-check">
    <input type="checkbox" class="form-check-input" name="study_case_active" value="1" id="exampleCheck2" {{ $checked_study_case }}>
    <label class="form-check-label" for="exampleCheck1">Active</label>
  </div>


<h3 class="form-section">Multi-lang </h3>
	@php 

	 if(isset($course))
	 {
		if($course->is_lang)
		  $checked_islangue="checked" ;
		else
		$checked_islangue="" ;

	 }else{
	  $checked_islangue="" ;
	}


	@endphp

<div class="form-check">
    <input type="checkbox" name="is_lang" value="1" class="form-check-input" id="is_lang" {{ $checked_islangue}}>
    <label class="form-check-label" for="is_Lang">Multi-lang  </label>
  </div>


