@extends('front/layouts/master')

@section('meta')
    <title>باقة</title>
    <meta name="keywords" content="باقة" />
    <meta name="description" content="باقة">
@stop

@section('styles')
	<link rel="stylesheet" href="{{asset('assets/front/css/style_courses.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/style_courses_filteration.css')}}">
@stop

@section('content')
<!-- Start book -->
<div class="training_purchasing">
	<div class="container training_container">
		<div class="media">
			<div class="media-body align-self-center">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a title="Go to Home Page" href="{{url(App('urlLang'))}}">{{trans('home.home')}}</a>
						</li>
						<li class="breadcrumb-item">
							<span>
									باقة
							</span>
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- Start Course Filter -->
<div class="course_filter">
	<div class="container filter_container">
		<div class="row justify-content-between">
			<div class="col-lg-3  filteration_method"></div>
			<div class="col-lg-9  filteration">
				<div class="filteration_content">
					<div class="row justify-content-between content_head">
						<div class="company_courses col-12 resltrslt">
							@foreach($packs as $pack)
								<?php
									$card = "one";
									switch ($loop->index%8){
										case 1;
											$card = "two";
											break;
										case 2;
											$card = "three";
											break;
										case 3;
											$card = "four";
											break;
										case 4;
											$card = "five";
											break;
										case 5;
											$card = "six";
											break;
										case 6;
											$card = "seven";
											break;
										case 7;
											$card = "eight";
											break;
									}
								?>
								<?php
									$setting = App('setting');
									$vat = $setting->vat*$pack->prix/100;

								?>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-margin">
									<div class="card course_animation card_style_{{ $card }}">
										<img class="card-img-top" src="{{asset('uploads/kcfinder/upload/image/packs/'.$pack->image)}}" alt="{{ $pack->titre }}">
										<span class="badge badge-pill badge-warning">
											<span>
												{{$pack->prix+$vat}} <b>$</b>
											</span>
										</span>
										<span class="badge badge-pill badge-warning2">أون لاين</span>
										<div class="card-body">
											<section class="rate rtgcrc">
												&nbsp;
											</section>
											<!--div class="circle_profile">
												<img src="https://swedish-academy.se/uploads/kcfinder/upload/image/users/1523080472sast_img.png">
											</div-->
											<h5 class="card-title">
												&nbsp;
											</h5>
											<p class="card-text"><a href="{{ url(App('urlLang').'packs/'.$pack->id) }}">{{ $pack->titre }}</a></p>
											<div class="more_info">
												<div class="row">
													<div class="col train_prograrm">
														<img src="https://swedish-academy.se/assets/front/img/verified_list.svg">
														<a href="{{ url(App('urlLang').'packs/'.$pack->id) }}">الدورة</a>
														<i class="fa fa-caret-left"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
   @include('front.packs.js.view_js')
@stop


