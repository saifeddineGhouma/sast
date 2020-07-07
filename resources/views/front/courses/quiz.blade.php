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
	<link rel="stylesheet" href="{{asset('assets/front/css/style_courses.css')}}">
	<style>
		.display-none{
			display: none;
		}
	</style>
	@include("front.courses.js.quiz_js")
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

<div class="quiz">
	<div class="container quiz_container">
		<div class="row">
			<div class="col-12  course_quiz courses_more_info_content">
				<form method="post" id="form-quiz" name="formquiz" action='{{url(App("urlLang")."courses/submit-quiz/".$studentQuiz->id)}}'>
					{!! csrf_field() !!}
					<div id="accordion">
						@foreach($questions as $question)
							<div id="question_{{  $loop->iteration }}" data-id="{{ $loop->iteration }}" class="{{ !$loop->first?'display-none':null }} question_div">
								<div class="content_header_one">
									<i class="fa fa-question-circle" aria-hidden="true"></i>
									<span class="quiz_text">السؤال </span>
									<span class="quiz_number">{{ $loop->iteration }}</span>
								</div>
								<div class="card course_quiz_card card_deactive">
									<div class="card-header" id="headingTen">
										<h5 class="mb-0">
											<p class="btn btn-link ">
												{{ $question->question_trans(App('lang'))->question }}
											</p>
										</h5>
									</div>
									<div id="collapseTen" class="collapse show" aria-labelledby="headingTen" data-parent="#accordion">
										<div class="card-body">
											@foreach($question->answers as $answer)
												<?php
												$studentQuizAnswer = $studentQuiz->answers()->where("question","=",$question->question_trans('ar')->question)
													->first();
												?>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="questions[{{$question->id}}]" value="{{ $answer->id }}"
															{{ !empty($studentQuizAnswer)&&$studentQuizAnswer->given_answer==$answer->name_ar?'checked':null }}>
													<label class="form-check-label" for="exampleRadios1"> {{ $answer->{'name_'.App('lang')} }} </label>
												</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						@endforeach
						<button type="button" class="quiz_question previous" onclick="show_prev(this)" style="display: none;">
							<i class="fa fa-angle-right" aria-hidden="true"></i>
							السؤال السابق
						</button>
						<button type="button" class="quiz_question next" onclick="show_next(this)">
							السؤال التالي
							<i class="fa fa-angle-left" aria-hidden="true"></i>
						</button>
						<p class="timer">لديك
							<span id='timer' class="count_down">
								<script type="text/javascript">window.onload = CreateTimer("timer", <?php echo $seconds;?>);</script>
							</span>
							للاجابة علي جميع الاسئلة</p>
						<button type="submit" class="quiz_question_end">انهاء الاختبار الأن </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End Quiz -->
<!-- #################### -->
<!-- Start Quiz Resualt -->
<div class="quiz_res">
	<div class="container">
		<div class="row questions_statues">
			<div class="col-3 question_total">
				<i class="fa fa-question-circle" aria-hidden="true"></i>
				<span>{{ $questions->count() }}</span>
				<p>اسئلة</p>
			</div>
			<div class="col-3 question_correct">
				<i class="fa fa-check" aria-hidden="true"></i>
				<span id="solved">{{ $studentQuiz->answers()->count() }}</span>
				<p>محلولة</p>
			</div>

			<div class="col-3 question_reminder">
				<i class="fa fa-question-circle" aria-hidden="true"></i>
				<span id="rest">{{ $questions->count() - $studentQuiz->answers()->count() }} </span>
				<p>متبقي</p>
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
	<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>

@stop
