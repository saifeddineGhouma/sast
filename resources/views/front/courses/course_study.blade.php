@extends('front/layouts/master')

@section('meta')
<?php
	$course_trans = $course->course_trans(App('lang'));
	if(empty($course_trans))
        $course_trans = $course->course_trans("en");
?>
	<title>{{ $course_trans->meta_title }}</title>
	<meta name="keywords" content="{{$course_trans->meta_keyword}}" />
	<meta name="description" content="{{$course_trans->meta_description}}">
@stop

@section('styles')
	<link rel="stylesheet" href="{{asset('assets/front/css/style_courses.css')}}">
	@if($courseStudy->type == "html")
	<script type="text/javascript">
        //Disable select-text script (IE4+, NS6+)
        function disableselect(e) {
            return false
        }

        function reEnable() {
            return true
        }
        //if IE4+
        document.onselectstart = new Function("return false")
        //if NS6
        if (window.sidebar) {
            document.onmousedown = disableselect
            document.onclick = reEnable
        }
	</script>
	@endif
@stop


@section('content')
<div class="container-fluid breadcrumbct">
	<div class="container training_container">
		<div class="media">
			<div class="media-body align-self-center">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a title="Go to Home Page" href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						@foreach($course->categories as $category)
							<li class="breadcrumb-item">
								<a href="{{url(App('urlLang').$category->category_trans(App('lang'))->slug)}}">
									{{$category->category_trans(App("lang"))->name or $category->category_trans("en")->name}}
								</a><span>&raquo;</span>
							</li>
						@endforeach
						<li class="breadcrumb-item">
							<a href="{{ url(App('urlLang').'courses/'.$course->courseTypes()->first()->id) }}">
								<span>
								{{ $course_trans->name }}
							</span><span>&raquo;</span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span>{{ $courseStudy->{'name_'.App('lang')} }}</span>
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
	<div class="container">

		@if($courseStudy->type == "html")
			{!! $courseStudy->content !!}
		@else
			<div id="example1"></div>

			<iframe src="https://docs.google.com/viewer?url={{asset('uploads/kcfinder/upload/file/'.$courseStudy->url)}}&embedded=true"
					onmousedown="return false;" onselectstart="return false;"
					frameborder="0" height="500px" width="100%" style=" margin-top: -100px; "></iframe>
		@endif
	</div>

@stop

@section('scripts')
	<script src="/js/pdfobject.js"></script>
@stop
