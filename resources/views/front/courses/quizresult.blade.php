@extends('front/layouts/master')

@section('meta')
<?php
	$course_trans = $course->course_trans(App('lang'));
	if(empty($course_trans))
        $course_trans = $course->course_trans("ar");

$quiz_trans = $quiz->quiz_trans(App('lang'));
if(empty($quiz_trans))
    $quiz_trans = $quiz->quiz_trans("ar");
?>
	<title>{{ $quiz_trans->name }}</title>
	<meta name="keywords" content="{{$course_trans->meta_keyword}}" />
	<meta name="description" content="{{$course_trans->meta_description}}">
@stop

@section('styles')

@stop


@section('content')
<div class="training_purchasing">
	<div class="container training_container">
		<div class="media">
			<img class="align-self-center ml-3" src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" alt="{{ $quiz_trans->name }}">
			<div class="media-body align-self-center">
				<?php
					$courseType = $course->courseTypes()->first();
				?>
				<a href="{{ url(App('urlLang').'courses/'.$courseType->id) }}" class="training_link">{{ $course_trans->name }}</a>
				@foreach($courseType->couseType_variations as $courseTypeVariation)
					<p>المدرب : <span> <a href="#" onclick="return false;"> {{ $courseTypeVariation->teacher->user->{'full_name_'.App("lang")} }}</a></span></p>
				@endforeach
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a title="Go to Home Page" href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						<li class="breadcrumb-item" >
							<a href="{{ url(App('urlLang').'courses/'.$courseType->id) }}">
								{{ $course_trans->name }}
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
						<span>
							{{ $quiz_trans->name }}
						</span>
						</li>
					</ol>
				</nav>
			</div>

		</div>
	</div>
</div>

<div class="quiz_result">
	<div class="container quiz_container">

		<button  onclick="js:window.location.href='{{ url(App("urlLang")."courses/".$courseType->id) }}'" class="btn btn-success" style="margin-right: 45%;margin-bottom: 20px;"> @lang('navbar.rest_test')  </button>

	</div>
	<div class="container quiz_container">
		<div class="row">
			<div class="col-4  course_quiz_result courses_more_info_content">
				<div class="content_header_one">
					<i class="fa fa-bookmark" aria-hidden="true"></i>
					<span class="quiz_text">  @lang('navbar.test_result') </span>

					@if($studentQuiz->successfull)
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						<span class="quiz_result_statues">
						@lang('navbar.succeded')
					</span>
					@else
						<i class="fa fa-times psnt" aria-hidden="true"></i>
						<span class="quiz_result_statues_fl">
						@lang('navbar.notsucceded')
					</span>

					@endif

				</div>
			</div>
			<div class="col-4  course_quiz_result courses_more_info_content">
				<div class="content_header_one two">
					<span class="quiz_result_text">اجابات صحيحة :   </span>
					<span class="quiz_result_number">
						{{ $studentQuiz->result }}/{{ $studentQuiz->final_mark }}
					</span>
				</div>
			</div>
			<div class="col-4  course_quiz_result courses_more_info_content">
				<div class="content_header_one two">
					<span class="quiz_result_text">النسبة : </span>
					<span class="quiz_result_number">
						@if($studentQuiz->final_mark>0)
							{{ round($studentQuiz->result/$studentQuiz->final_mark*100,2) }}%
						@endif
					</span>
				</div>
			</div>
		</div>
		<div class="row result_table">
			<table class="table table_striped_col table-responsive">
				<thead>
				<tr>
					<th scope="col" class="head_col"></th>
					<th scope="col" class="head_col">السؤال</th>
					<th scope="col" class="head_col">الاجابة المعطاه</th>
					<th scope="col" class="head_col">الاجابة الصحيحة</th>
					<th scope="col " class="head_col">الحالة</th>
				</tr>
				</thead>
				<tbody>
				@foreach($studentQuiz->answers as $quizAnswer)
					<tr>
						<td class="row_head">{{ $loop->iteration }}</td>
						<td>{{ $quizAnswer->question }}</td>
						<td>{{ $quizAnswer->given_answer }}</td>
						<td>{{ $quizAnswer->correct_answer }}</td>
						<td class="resule_statues {{ $quizAnswer->correct?'correct':'incorrect' }}">
							@if($quizAnswer->correct)
								<i class="fa fa-check" aria-hidden="true"></i>
							@else
								<i class="fa fa-times" aria-hidden="true"></i>
							@endif
						</td>
					</tr>
				@endforeach

				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- End Quiz -->
<!-- #################### -->
<!-- Start Quiz Resualt -->
<div class="quiz_res">
	<div class="container">
		<div class="row questions_statues">
			<div class="col-4 question_total">
				<i class="fa fa-question-circle" aria-hidden="true"></i>
				<span>{{ $studentQuiz->answers()->count() }}</span>
				<p>اسئلة</p>
			</div>
			<div class="col-4 question_correct">
				<i class="fa fa-check" aria-hidden="true"></i>
				<span>{{ $studentQuiz->answers()->where("studentquiz_answers.correct",1)->count() }}</span>
				<p>صحيحة</p>
			</div>
			<div class="col-4 question_incorrect">
				<i class="fa fa-times" aria-hidden="true"></i>
				<span>{{ $studentQuiz->answers()->where("studentquiz_answers.correct",0)->count() }}</span>
				<p>خاطئة</p>
			</div>
		</div>
	</div>
</div>



@stop

@section('scripts')


@stop
