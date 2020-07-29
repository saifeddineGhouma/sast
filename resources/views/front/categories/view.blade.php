@extends('front/layouts/master')

@section('meta')
<?php
	if($type=="category"){
		$cat_trans = $category->category_trans(session()->get('locale'));
		if(empty($cat_trans))
			$cat_trans = $category->category_trans("en");
	}else{
		$cat_trans = App('setting')->settings_trans(session()->get('locale'));
		if(empty($cat_trans))
			$cat_trans = App('setting')->settings_trans("en");
	}
	
	function recurseFromFirstParent($subcat,$category){
		$parent = $subcat->maincat;
		$subcat_trans = $subcat->category_trans(session()->get('locale'));
		if(empty($subcat_trans))
			$subcat_trans = $subcat->category_trans("en");
		if(!empty($parent)){											
			recurseFromFirstParent($parent,$category);
		}
        echo '<li class="breadcrumb-item">';
        if($category!=$subcat)
            echo '<a href="'.url(App("urlLang").$subcat_trans->slug).'">';
        else{
            echo '<span>';
		}
        echo  $subcat_trans->name;
        if($category!=$subcat)
            echo '</a>';
        else{
            echo '</span>';
		}
        echo '</li>';
	}
	
?>
	<title>{{ $cat_trans->meta_title }}</title>
	<meta name="keywords" content="{{$cat_trans->meta_keyword}} " />
	<meta name="description" content="{{$cat_trans->meta_description}} ">
	@if($type=="category")
		@if($category->noindex && $category->nofollow)
			<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		@elseif($category->noindex)
			<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
		@elseif($category->nofollow)
			<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
		@endif
		
		@if($category->canonical)
			<link rel="canonical" href="{{$_SERVER['REQUEST_URI']}}" />
		@endif
	@endif
@stop

@section('styles')
	<link rel="stylesheet" href="{{asset('assets/front/css/style_courses.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/style_courses_filteration.css')}}">
@stop

@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@section('content')
<!-- Start Training Purchasing -->
<div class="training_purchasing">
	<div class="container training_container">
		<div class="media">
			<div class="media-body align-self-center">
				<nav aria-label="breadcrumb" style="direction: {{$dir}};">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a title="Go to Home Page" href="{{url(App('urlLang'))}}">{{trans('home.home')}}</a>
						</li>
						@if($type=="category")
							{!! recurseFromFirstParent($category,$category) !!}
						@else
							<li class="breadcrumb-item">
							<span>
									{{$cat_trans->name}}
							</span>
							</li>
						@endif
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- End Training Purchasing -->

<!-- Start Course Filter -->
<div class="course_filter" style="direction:{{ $dir }}">
	<div class="container filter_container">
		<div class="row justify-content-between">
			<div class="col-lg-3  filteration_method" style="text-align: justify;">
				@include("front.categories._sidebar",array("cat_trans"=>$cat_trans))
			</div>
			<div class="col-lg-9  filteration">
				<div class="filteration_head">
					<div class="row justify-content-between">
						<div class="col-12 srchrslt" style="text-align: justify;">
							<div id="search_total" style="margin-bottom:10px;">&nbsp; {{$countCourses}} &nbsp;{{ trans('home.results_found_for') }}&nbsp;
								@if($type=="all-courses")
									<strong> {{ trans('home.all_courses') }}</strong>
								@else
									<strong>{{ $cat_trans->name }}</strong>
								@endif
							</div>

						</div>
					</div>
				</div>
				<div class="filteration_content">
					<div class="row justify-content-between content_head">
						<div class="col-6 search_sort">
							<span> {{trans('home.filtre_selon')}} </span>
							<select class="custom-select search_select" id="sort_link">
								<option value="newest">{{trans('home.newest')}}</option>
								<option value="toprated">{{trans('home.top_rated')}}</option>

							</select>
						</div>
						{{--<div class="col-6 search_sort">
							<span>طريقة العرض :</span>
							<i class="fa fa-list" onclick="return false;" class="view-list"></i>
							<i class="fa fa-th" onclick="return false;" class="view-grid"></i>
						</div>--}}
						<div class="company_courses col-12 resltrslt">

							<input type="hidden" id="cat_id" value="{{$category->id or 0}}"/>
							<input type="hidden" id="type" value="{{$type}}"/>

							<input type="hidden" id="start_at" value="{{$start_at}}"/>
							<input type="hidden" id="step" value="{{$step}}"/>
							<input type="hidden" id="countpro" value="{{$countCourses}}"/>
							<input type="hidden" id="sort_order" value=""/>
							<div id="coruses-container" class="row justify-content-around content_info">
								
								@include('front.courses._courses2',array("courseTypes"=>$courseTypes))
							</div>
							<div class="pagination-area ">
								<div class="load-more">
									<div class="col-sm-8 col-sm-push-2 col-xs-12 text-center load-more-holder {{$countCourses<=$start_at?'display-none':''}}">
										<a><button id="new-products_grid" class="button btn-cool" data-loading-text="{{trans('home.loading')}}">{{trans('home.load_more')}}</button></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
   @include('front.categories.js.view_js')
@stop
