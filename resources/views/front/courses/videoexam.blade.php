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
					$courseType = $course->courseTypes->first();
				?>
				
				<a href="" class="training_link">{{ $course_trans->name }}</a>
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

<div class="quiz">
	<div class="container quiz_container">
		<div class="row">
			<div class="col-12  course_quiz courses_more_info_content">
				@include('common.errors')
				{!! $videoExam_trans->content !!}

				<form method="post" id="form-video" action='{{url(App("urlLang")."courses/submit-video")}}'>
					{!! csrf_field() !!}
					<input type="hidden" name="course_id" value="{{ $course->id }}"/>
					<input type="hidden" name="videoExam_id" value="{{ $videoExam->id }}"/>
					

					
					
					<div>
						<div class="form-group">
							<p style="text-align: justify;" >	
							الاختبارالعملي لدورة مدرب اللياقة البدنية المعتمدة من الاكاديمية السويدية للتدريب الرياضي وفقا للمواصفات القياسية للسجل التونسي للمدربين المحترفين REPS TUNISIA  . سوف یتكون من التفسیر والأداء العملي لممارسة جلسة تدريبية تقيمية تنفذها بمفردك،وسوف یقوم معلمك بعرض الزمن الذي استغرقته مباشرة. تتبع الخطوات التالی:</p>  
							<p style="text-align: justify;">
							الإعداد: <br>
							<ol>
								<li style="text-align: justify;"> اقرأالحالة المذكورة في الاسفل. </li>
								<li style="text-align: justify;"> 	.	صمم جلسة تدریبیة مناسبة تنفذها بنفسك مشتملة على اختیار نوع التمرین و ترتیب التمارین و الأحمال و الشدة و الامتداد الممكن أو نقطة الإثارة العضلیة. </li>
							</ol>
							</p>
							<p style="text-align: justify;">
							عندالاختبار :
								<ol>
							<!--li style="text-align: justify;">	اشرح تصمیم برنامجك. </li--> 
								<li style="text-align: justify;"> قم بأداء جلسة التدریب وفقا لما تخطط له، ويجب أداء الإحماء بحيث تكون جاهزا قبل الاختبار.</li>

							</p>
						</div>
						<div class="form-group">
							<label class="col-md-4"> الحالة التدريبية هي  :  <span></span></label>
							<div class="col-md-12">
								<b>{{ $casExamPratique->name }}</b>
								<input type="hidden" name="subject" value="{{ $casExamPratique->name }}">
							</div>
						</div> 
					</div>
					<div id="accordion">
						<div class="form-group">
							<label class="col-md-4 control-label"><span></span></label>
							<div class="col-md-12">
							</div>
						</div>
						@if($videoExam->live == 0)
							<div class="form-group">
								<label class="col-md-2 control-label">رابط الفيديو <span>*</span></label>
								<div class="col-md-10">
									<input type="text" name="video" class="form-control">
								</div>
							</div>
						@else
							<div class="form-group">
								<div class="col-md-12">
									<b>يمكنك الاتصال بلاكاديمية لطلب تعيين موعد إمتحان مباشرة مع أحد المدربين من <a href="{{ url(App('urlLang').'contact') }}" target="_blank">هنا  </a>ثم النقر على "طلب إمتحان مباشر" </b>
								</div>
							</div>
						@endif
						<div class="form-group">
							<label class="col-md-2 control-label">ملاحظاتك</label>
							<div class="col-md-10">
								<textarea cols="60" name="user_message"  class="form-control"></textarea>
							</div>
						</div>
						<button type="submit" class="quiz_question_end">{{$videoExam->live == 0 ? 'انهاء الاختبار الأن ' : ' طلب إمتحان مباشر   ' }}</button>
					</div>
				</div>
					</div>


				
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End Quiz -->


@stop

@section('scripts')
	<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	@if($videoExam->live == 0)
		<script>
		    $("#form-video").bootstrapValidator({
		        excluded: [':disabled'],
		        fields: {
		            video: {
		                validators: {
		                    notEmpty: {
		                        message: 'رابط الفيديو مطلوب'
		                    }
		                },
		                required: true
		            },
		        }
		    }).on('success.form.bv', function(e) {

		    });
		</script>
	@endif
@stop
