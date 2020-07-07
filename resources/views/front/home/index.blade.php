@extends('front/layouts/master')

@section('meta')

<?php
	$setting_trans = $setting->settings_trans(App('lang'));
	if(empty($setting_trans))
		$setting_trans = $setting->settings_trans('en');
?>
	<title>{{$setting_trans->meta_title}}</title>
	<meta name="keywords" content="{{$setting_trans->meta_keyword}}" />
	<meta name="description" content="{{$setting_trans->meta_description}}">	
 
@stop

@php
    $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ;
    $align = session()->get('locale') === "ar" ? "right" : "left" ;
    $locale = session()->get('locale');
@endphp    
@section('styles')

@stop
@section('content') 

<div class="modal" id="infos" style="direction:{{ $dir }}">
    <div class="modal-dialog">
      <div class="modal-content" style="text-align: center">
       {{-- <div class="modal-header">
          <h4 class="modal-title" style="text-align: justify">{{ trans('home.voir_plus') }}</h4>
          <button type="button" class="close" data-dismiss="modal">
          </button>            
        </div>  --}}
        <img src="{{asset('uploads/kcfinder/upload/image/'.App("setting")->settings_trans(App('lang'))->logo)}}" alt="Swedish" title="Swedish">

        <div class="modal-body" style="text-align: center;">
            إذا كنت تريد أن تصبح شريكًا للأكاديمية السويدية     
        <br>
        <button onclick="js:location.href='{{url(App('urlLang').'partnership')}}'" type="button" class="btn btn-primary" > سجل الان  </button>
        </div>
            
        <div class="modal-footer" style="display: {{ $locale === "ar" ? "" : "inline-flex"}}" >
          <button type="button"  data-dismiss="modal">{{ trans('home.fermer_popup_contact') }}</button>
        </div>
      </div>
    </div>
</div>





<aside class="slider">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($sliderImages as $key=>$sliderImage)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" @if($loop->first)class="active"@endif></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($sliderImages as $sliderImage)
                    <div class="carousel-item item {{ $loop->first?'active':null }}">
                        <img class="d-block w-100" src="{{asset('uploads/kcfinder/upload/image/'.$sliderImage->image)}}"  alt="{{$sliderImage->title}}">
                        <div class="slider_info "  style="direction: {{$dir}};text-align: {{$align}};">
                            <h3 style="text-align: {{$align}};">@lang('navbar.sliderSpecialite')</h3>
                            <h1 style="text-align: {{$align}};">@lang('navbar.sliderTitre', ['sliderTitre' => $sliderImage->title]) </h1>
                            <h3 style="text-align: {{$align}};">@lang('navbar.sliderDesc', ['sliderDesc' => $sliderImage->description])</h3>
                            <button onclick="location.href='{{ $sliderImage->link }}'" class="start_now">@lang('navbar.startNow')</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </aside>
    <!-- End Slider -->
<!-- {!! $setting_trans->index_section !!} -->

<!-- <div class="welcome">
    <div class="container">
        <div class="welcome_head"> -->
<div class="video_content">
        <div class="container">
            <div class="video_head">         
                <h4>{{ trans('home.welcom_in_academy_index') }}</h4>
          
            </div>                           
                <div class="page-header hello_in_sast">
                      
                    <div class="row" style="margin-bottom: 20px;">
                      <!--  <div class="col-md-4">
                             <img src="https://swedish-academy.se/assets/front/img/sast_img.png" />
                                <h3 class="ddnn"> د. علي  فالح سلمان<span>مدير الأكاديمية</span></h3>
                        </div> 
                        <div class="col-md-8">-->
                               
                                 
                                <p style = "direction : {{$dir}}">{{ trans('home.paragraphe_welcome_in_academy_index') }}</p>

                                <button onclick="js:location.href='https://swedish-academy.se/pages/%D9%85%D8%B1%D8%AD%D8%A8%D8%A7-%D8%A8%D9%83%D9%85'" class="view_more">  {{ trans('home.read_more_welcome_academy_index') }} </button>

                        <!-- </div> -->
                                
                    </div>
                </div>
    </div>
    
</div>
   
  


 <div class="statistique" style="direction:{{ $dir }}">
        <div class="container">
             <div class="stat_head">  
                    <div class="row" style="text-align: justify">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon1.png')}}"></div>
                                <div class="media-body-icon ">
                                    <h3 class="mt-0">+{{ $countTeacher }}</h3>
                                    <p>  {{ trans('home.coach_ready_index') }} </p>

                                   
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon2.png')}}"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0">+{{ $countBooks }}</h3>
                                    <p>{{ trans('home.books_academy_index') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon3.png')}}"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0">{{ $countStudents }}</h3>
                                    <p> {{ trans('home.etudiant_inscrit_index') }} </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon4.png')}}"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0">{{ $countCourses }}</h3>
                                    <p> {{ trans('home.training_program_index') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

         
    </div>          
    <!-- souhir -->  
    <div class="search">
        <div class="container"> 
            <div class="row" >
                <div class="form">
                    <div class="form_header">
                        <h2>{{ trans('home.filtre_courses_index') }}</h2>
                    </div>
                    <form class="search_form" action="{{ url(App('urlLang').'search') }}" >
                        <div class="form-group select_group"  >
                            <select name="category_id" class="form-control select_form" style="direction:{{ $dir }}">
                                <option value="" selected> {{ trans('home.choisir_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_trans(Session::get('locale'))->name or null }}</option>
                                @endforeach
                            </select>
                            <select name="country_id" class="form-control select_form" style="direction:{{ $dir }}">
                                <option value="" selected>{{ trans('home.choisir_pays') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_trans(Session::get('locale'))->name or $country->country_trans("en")->name }}</option>
                                @endforeach
                            </select>
                            <select name="type" class="form-control select_form" style="direction:{{ $dir }}">
                                <option value="" selected>{{ trans('home.type_cours') }}</option>
                                <option value="online">{{ trans('home.online') }}</option>
                                <option value="presence">{{ trans('home.presence') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('home.search_now') }}</button>
                    </form>
                </div>
             
            </div>
        </div> 
    </div>



    <div class="courses">
        <div class="container">
            <div class="content">
               <span> <h4>{{ trans('home.traning_courses_index') }}</h4><span>
               <!--  <img src="{{asset('assets/front/img/line_copy.png')}}" /> -->
            </div>
            <div class=" company_courses ">
                <div class="row justify-content-around">
                    @include("front.courses._courses") 
                </div>
            </div>
            <button onclick="js:location.href='{{url(App('urlLang').'all-courses')}}'" class="view_more"> {{ trans("home.voir_plus_index_courses") }}</button>
        </div>
    </div> 



    <div class="video_content">
        <div class="container">
            <div class="video_head">
             <h4>   {{ trans("home.academy_index") }} </h4>
            </div> 
            <div class="row" style="direction:{{ $dir }}">
            <div class="col-md-6"  style="text-align: justify"; >
                <p>  
                {{ trans("home.paragraphe_academy_index") }} 
                </p>
            </div>
            <div class="col-md-6 ">
            <span class="video_img">
             <a href="https://youtu.be/e393SPqur4k">   <img src="{{asset('assets/front/img/academy_video.jpg')}}"  /></a>
             <span>
            </div>
          
            </div>
        </div> 
    </div>


    <!-- {!! $setting_trans->index_section2 !!} -->
<!-- 	<div class="certificate">
		<div class="container">
			<div class="certificate_info"> -->
        <div class="video_content">
            <div class="container">
                <div class="video_head">
    				<h4>{{ trans("home.accreditation_internationale") }} </h4>
                </div>
               
			<div class="swiper-contain">
			    <!-- Uasyow Marque et sites -->
				<div class="row certificate">
				    <div class="col-md12">
				        <!--
					<div class="owl-carousel owl-theme" style="direction: ltr;">
						 <div class="item">
							<a href="http://www.europeactive.eu/" target="_blank"><img src="https://swedish-academy.se/assets/front/img/erpactive.png" /></a>
						</div> -->
						<div class="col-md-3 item">
							<a href="http://www.icsspe.org/content/members-headquarters" target="_blank"><img src="https://swedish-academy.se/assets/front/img/ICSSPE.png" /></a>
						</div>
					   <!-- 	<div class="item">
							<a href="http://www.ereps.eu/civicrm/profile/view?reset=1&id=51343&gid=38" target="_blank"><img src="https://swedish-academy.se/assets/front/img/EREPS.png" /></a>
						</div> -->
                        <div class="col-md-3 item">
                            <a href="https://internationalhandballcenter.com/" target="_blank"><img src="https://swedish-academy.se/assets/front/img/handballcenter.png" /></a>
                        </div>

                        <div class="col-md-3 item">
                            <a href="http://sjsr.se/en/home.php" target="_blank"><img src="https://swedish-academy.se/assets/front/img/sjsr.png" /></a>
                        </div>
						
						<div class="col-md-3 item">
							<a href="http://gcss.se" target="_blank"><img src="https://swedish-academy.se/assets/front/img/GCSS.png" /></a>
						</div>
					<!--</div>-->
				    </div>
				    <div class="col-md-12">
				       
						<div class="col-md-3 item">
							<a href="https://www.nasm.org/" target="_blank"><img src="https://swedish-academy.se/assets/front/img/nasm.png" /></a>
						</div>
					   
                        <div class="col-md-3 item">
                            <a href="https://tnreps.com/" target="_blank"><img src="https://swedish-academy.se/assets/front/img/repsindia-logo.png" /></a>
                        </div>

                        <div class="col-md-3 item">
                            <a href="https://www.afaa.com/" target="_blank"><img src="https://swedish-academy.se/assets/front/img/afaa.png" /></a>
                        </div>
						<div class="col-md-3 item">
						     
                        </div>
						
					
				    </div>
					<div class="btmwn"><hr></div>
				</div>
			</div>
			<!-- <a  class="view_more" href="pages/الاعتماد-الدولي">مشاهدة المزيد</a> -->
			
		</div>
    </div>


    <!--div class="book">
        <div class="content">
            <h4>كتب الاكاديمية</h4>
            <img src="{{asset('assets/front/img/line_copy.png')}}" />
        </div>
        <div class="container">
            <div class="row books_category">
                @each("front.books._book",$books,'book')
            </div>
            <button onclick="js:location.href='{{url(App('urlLang').'books')}}'" class="view_more">مشاهدة المزيد</button>
        </div>
    </div-->

      <div class="coaches">
        <div class="container"> 
            <div class="coaches_head">
                <h4> {{ trans("home.formateur_index") }} </h4>
        <!-- <img src="{{asset('assets/front/img/line_copy_w.png')}}" /> -->
            </div>
            <div class="swiper-contain coaches_content">
                <div class="row justify-content-around">
                    <div class="owl-carousel owl-theme" style="direction: ltr;">
                         @foreach($teachers as $teacher)

                        <div class="item coach_header">
                            <img class="header_2" src="{{ asset("uploads/kcfinder/upload/image/users/".$teacher->user->image) }}" width="207" height="202">
                             <div class="coach_more_info coach_social">
                                <div class="info_content">
                                    @foreach($teacher->socials as $teacherSocial)
                                        <a href="{{ $teacherSocial->link }}"><i class="{{ $teacherSocial->font }}"></i></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach  
                    </div>
                   <!--  <div class="btmwn"><hr></div> -->
                </div>
            </div>
            <!-- <a  class="view_more" href="pages/الاعتماد-الدولي">مشاهدة المزيد</a> -->
            
        </div>
    </div>

    <!-- Start Coaches -->
   <!--  <div class="coaches">
        <div class="container">
            <div class="coaches_head">
                <h4> المدربين </h4>
        <!-- <img src="{{asset('assets/front/img/line_copy_w.png')}}" /> 
            </div>
            <div class="coaches_content">
                <div class="row justify-content-around">
                    
                    @foreach($teachers as $teacher)

                    <div class="col-md-3 col-sm-6 col-xs-12 coaches_info coashes_js_two">
                        <div class="coach_header">
                            <img class="header_2" src="{{ asset("uploads/kcfinder/upload/image/users/".$teacher->user->image) }}" >
                            <div class="coach_more_info coach_social">
                                <div class="info_content">
                                    @foreach($teacher->socials as $teacherSocial)
                                        <a href="{{ $teacherSocial->link }}"><i class="{{ $teacherSocial->font }}"></i></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <p class="coach_name">
                            {{ $teacher->user->full_name_ar }}
                        </p>
                        <p class="coach_country">
                            {{ $teacher->nationality }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> -->
    <!-- End Coaches -->
    <!-- #################### -->
    <!-- Start Join Us -->
    <div class="join_us">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-lg-6 col-md-6  join">
                    <div class="academy_student" >
                        <a href="/login" class="content">
                            <span>{{ trans("home.rejoindre_index") }}</span>
                            <p> {{ trans("home.join_etudiant_academy") }}</p>
                        </a>
                        <a href="{{ url(App('urlLang').'account') }}" type="button" class="btn btn-primary btn-sign"> {{ trans("home.register_now_index") }}</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 join">
                    <div class="academy_trainer">
                        <a href="/partnership" class="content">
                            <span>{{ trans("home.rejoindre_index") }} </span>
                            <p>{{ trans("home.join_trainers_academy") }}</p>
                        </a>
                        <a href="{{ url(App('urlLang').'partnership') }}" type="button" class="btn btn-primary btn-sign" > {{ trans("home.register_now_index") }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- 
    <div class="feedback">
        <div class="container">
            <div class="feedback_head"> -->
            <div class="video_content">
        <div class="container">
            <div class="video_head">
                <h4>@lang('navbar.studentAvis')</h4>
            </div>
            <div class="clients_feedback">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @php $textalign = session()->get('locale') === "ar" ? "left" : "right" @endphp
                        {{-- @foreach($testimonials as $testimonial)
                             <div class="carousel-item {{ $loop->first?'active':null }}">
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <p>@lang('navbar.footerModalDesc', ['footerModalDesc' => $testimonial['comment']])</p>
                                        
                                        
                                    </div>
                                </div>
                            <p style="text-align: {{ $textalign }}" class="client_name">@lang('navbar.footerModalTitre', ['footerModalTitre' => $testimonial->user->full_name_en])</p>
                            </div>
                        @endforeach --}}
                        @foreach($testimonials as $testimonial)
                        <div class="carousel-item {{ $loop->first?'active':null }}">
                            <div class="media">
                           <!--      <img class="align-self-center mr-3" src="{{asset('uploads/kcfinder/upload/image/'.$testimonial->image)}}" alt=""> -->
                                <div class="media-body align-self-center">
                                    <p>{{ $testimonial->comment or null }}</p>
                                </div>
                            </div>
                            <p class="client_name">{{ $testimonial->user->full_name_en or null }}</p>
                        </div>
                    @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
@stop

@section('scripts')
<!-- Owl Stylesheets -->
<link rel="stylesheet" href="https://swedish-academy.se/assets/front/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://swedish-academy.se/assets/front/owlcarousel/assets/owl.theme.default.min.css">
<script src="https://swedish-academy.se/assets/front/owlcarousel/owl.carousel.js"></script>
<script>
    //modal script
$(document).ready(function ()
{
    $('#infos').modal('show')
    
})
    //modal script
$(document).ready(function ()
{
    $('#promotions').modal('show')
   
})

	$(document).ready(function() {
		var owl = $('.owl-carousel');
		owl.owlCarousel({
			items: 3,
			loop: true,
			margin: 20,
			autoplay: true,
			autoplayTimeout: 3000,
			autoplayHoverPause: true
		});
		$('.play').on('click', function() {
			owl.trigger('play.owl.autoplay', [1000])
		})
		$('.stop').on('click', function() {
			owl.trigger('stop.owl.autoplay')
		})
	})
</script>
<script>
    function HidePromo() {
  var x = document.getElementById("promotions");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
@stop
