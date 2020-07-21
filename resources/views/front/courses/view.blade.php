@extends('front/layouts/master')

@section('meta')
<?php
	$course_trans = $course->course_trans(session()->get('locale'));
	if(empty($course_trans))
        $course_trans = $course->course_trans("ar");
?>
	<title>{{ $course_trans->meta_title }}</title>
	<meta name="keywords" content="{{$course_trans->meta_keyword}}" />
	<meta name="description" content="{{$course_trans->meta_description}}">
@stop

@section('styles')

	<style>
		.display-none{
			display: none;
		}
	</style>
@stop

@section('content')
	<div class="container-fluid " style="margin-bottom: 10px">
		@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
		@php $textalign = session()->get('locale') === "ar" ? "right" : "left" @endphp
		<div class="training_purchasing" >
			<div class="container training_container">
				<div class="media" style="direction : {{ $dir }}">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<i class="fa fa-home" aria-hidden="true"></i>
								<a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
							</li>
							
							@foreach($course->categories as $category)
								<li class="breadcrumb-item">
									<a href="{{url(App('urlLang').$category->category_trans(session()->get('locale'))->slug)}}">
										{{$category->category_trans(session()->get('locale'))->name or $category->category_trans("en")->name}}
									</a>
								</li>
							@endforeach

							<li class="breadcrumb-item active" aria-current="page">
								<span>
									{{ $course_trans->name }}
								</span>
							</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	
	
	
</div>
@include('common.errors')
@include("front.courses.course._header")
<div class="courses_selection">
	<div class="container" style="direction: {{ $dir }}">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item active">
				<a class="nav-link  " data-toggle="tab" href="#information" role="tab"  >@lang('navbar.infoSession')</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#curriculum" role="tab"  >@lang('navbar.courseWay')</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#discussion" role="tab"  >@lang('navbar.disscussion')</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#curriculum_exam" role="tab"  >@lang('navbar.exams')</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#teacher" role="tab" >@lang('navbar.coachs')</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#ratingcourse" role="tab" >@lang('navbar.evaluateCoachs')</a>
			</li>

		</ul>
	</div>
</div>
<!-- End Courses Selection -->
@if(Session::has('Review_Updated'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{!! Session::get('Review_Updated') !!} 
	</div>
@endif
<div class="courses_more_info">
	<div class="container">
		<div class="row more_info_one justify-content-between tab-content">
			<div class="tab-pane fade in active show" role="tabpanel" id="information">
				@include("front.courses.course._information")  
			</div>
			<div role="tabpanel" class="wide-tb  col-lg-12 tab-pane fade " id="curriculum">
				@include("front.courses.course._studies")
			</div>
			<div role="tabpanel" class="wide-tb  tab-pane fade" id="discussion">
				@include("front.courses.course._discussion")
			</div>
			<div role="tabpanel" class="wide-tb tab-pane fade" id="curriculum_exam">
				@include("front.courses.course._exams")
			</div>
            <div role="tabpanel" class="wide-tb  tab-pane fade" id="teacher">
                @include("front.courses.course._teachers")
            </div>
            <div role="tabpanel" class="wide-tb  tab-pane fade" id="ratingcourse">
                @include("front.courses.course._reviews")
            </div>
        </div>
    </div>
</div>

<div class="courses_most_requested">
    <div class="courses">
        <div class="container">
            <div class="content">
                <h4>@lang('navbar.mostsession')</h4>
                <img src="{{asset('assets/front/img/line_copy.png')}}" />
            </div>
            <div class="company_courses ">
                <div class="row">
					
                    @include("front.courses._courses",["courseTypes"=>$topCourseTypes])

                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
		<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
		<script>
			function alerttt(){
				alert("الرجاء الإنتظار 5دقائق لإعادة المحاولة");
			}
		</script>
		
	<script>
		function downloadf(fichier){
			//alert("afef");
			downloadURL('https://swedish-academy.se/uploads/kcfinder/upload/file/'+fichier);
		}
	</script>
	@include("front.courses.js.view_js")
@stop
