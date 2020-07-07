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

