@extends('front/layouts/master')

@section('meta')
<?php
	$course_trans = $course->course_trans(App('lang'));
	if(empty($course_trans))
        $course_trans = $course->course_trans("ar");

$videoExam_trans = $videoExam->videoexam_trans(App('lang'));
if(empty($videoExam_trans))
    $videoExam_trans = $videoExam->videoexam_trans("ar");
?>
	<title>{{ $videoExam_trans->name }}</title>
	<meta name="keywords" content="{{$course_trans->meta_keyword}}" />
	<meta name="description" content="{{$course_trans->meta_description}}">
@stop

@section('styles')

@stop


@section('content')
<div class="training_purchasing">
	<div class="container training_container">
		<div class="media">
			<img class="align-self-center ml-3" src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" alt="{{ $videoExam_trans->name }}">
			<div class="media-body align-self-center">
				<?php
					$courseType = $course->courseTypes()->first();
				?>
				<a href="{{ App('urlLang').'courses/'.$courseType->id }}" class="training_link">{{ $course_trans->name }}</a>
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
							{{ $videoExam_trans->name }}
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
		<button onclick="js:window.location.href='{{ url(App('urlLang').'account') }}'" class="btn btn-success" style="margin-right: 45%;margin-bottom: 20px;"> بقية الاختبارات  </button>
	</div>
	<div class="container quiz_container">
		<div class="row">
			{{-- les cas  --}}
				@if(in_array($course->id, [496, 502, 17, 532]))
				<div>
					<div class="form-group">
						<label class="col-md-4"> الحالة التدريبية لتصوير الفيديو  :  <span></span></label>
						
						<div class="col-md-12">
							{{ $casExamPratique->name }}
						</div>
					</div> 
				</div>
				@endif
{{-- end cas --}}
			@if($studentVideoExam->status == "completed")
				<div class="col-4  course_quiz_result courses_more_info_content">
					<div class="content_header_one">
						<i class="fa fa-bookmark" aria-hidden="true"></i>
						<span class="quiz_text">نتيجة الاختبار : </span> 
						<i class="fa fa-check-circle-o" aria-hidden="true"></i>
						<span class="quiz_result_statues">
							@if($studentVideoExam->successfull)
								ناجح
							@else
								راسب
							@endif
						</span>
					</div>
				</div>
			@endif
			<div class="col-4  course_quiz_result courses_more_info_content">
				<div class="content_header_one two">
					<span class="quiz_result_text">الحالة :   </span>
					<span class="quiz_result_number">
					{{ trans('home.'.$studentVideoExam->status) }}
					</span>
				</div>
			</div>
		</div>
		<div class="row result_table">
			{!! \App\VideoExam::showVideo($studentVideoExam->video) !!}
		</div>
		<div class="row">
			@if(!empty($studentVideoExam->manager_message))
				<p><span>رسالة المدير :</span>{{ $studentVideoExam->manager_message }}</p>
			@endif
			@if(!empty($studentVideoExam->website_message))
				<p><span>رسالة المدير :</span>{{ $studentVideoExam->website_message }}</p>
			@endif
			@if(!empty($studentVideoExam->user_message))
				<p><span>رسالة المدير :</span>{{ $studentVideoExam->user_message }}</p>
			@endif
		</div>
	</div>
</div>
<!-- End Quiz -->


@stop

@section('scripts')


@stop
