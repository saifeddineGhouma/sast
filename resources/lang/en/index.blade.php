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

@section('styles')

@stop
@section('content')
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
                        <div class="slider_info ">
                            <h3>اختصاصنا الدورات الرياضية</h3>
                            <h1>{{ $sliderImage->title }}</h1>
                            <h3>{!! $sliderImage->description !!}</h3>
                            <button onclick="location.href='{{ $sliderImage->link }}'" class="start_now">ابدأ الأن</button>
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
                <h4>مرحبا بكم في الأكاديمية السويدية للتدريب الرياضي</h4>
          
            </div>                           
                <div class="page-header hello_in_sast">
                      
                    <div class="row">
                       {{-- <div class="col-md-4">
                             <img src="https://swedish-academy.se/assets/front/img/sast_img.png" />
                                <h3 class="ddnn"> د. علي  فالح سلمان<span>مدير الأكاديمية</span></h3>
                        </div>
                               
                        <div class="col-md-8"> --}}
                                 
                                <p>لطالما كان هدف الاكاديمية السويدية للتدريب الرياضي SAST والمجلس العالمي للعلوم الرياضية في السويد GCSS، أن نكون في طليعة المؤسسات التدريبية العاملة في تطوير العلوم الرياضية، وقد سعينا منذ البداية إلى ترسيخ سمعتنا عبر تقديم الدورات التدريبية الأعلى جودة في المنطقة العربية</p>

                                <button onclick="js:location.href='https://swedish-academy.se/pages/%D9%85%D8%B1%D8%AD%D8%A8%D8%A7-%D8%A8%D9%83%D9%85'" class="view_more">  اقرأ المزيد</button>

                        {{-- </div> --}}
                                
                    </div>
                </div>
    </div>
</div>


 <div class="statistique">
        <div class="container">
             <div class="stat_head">  
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon1.png')}}"></div>
                                <div class="media-body-icon ">
                                    <h3 class="mt-0">+{{ $countTeacher }}</h3>
                                    <p>مدرب جاهز</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon2.png')}}"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0">+{{ $countBooks }}</h3>
                                    <p>كتاب للاكاديمية</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon3.png')}}"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0">{{ $countStudents }}</h3>
                                    <p>طالب مسجل</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="{{asset('assets/front/img/icon4.png')}}"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0">{{ $countCourses }}</h3>
                                    <p>برنامج تدريبي</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

         
    </div>           
    <div class="search">
        <div class="container">
            <div class="row">
                <div class="form">
                    <div class="form_header">
                        <h2>قم بالبحث عن اي دورة الأن</h2>
                    </div>
                    <form class="search_form" action="{{ url(App('urlLang').'search') }}">
                        <div class="form-group select_group">
                            <select name="category_id" class="form-control select_form">
                                <option value="" selected>اختر القسم</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_trans(App("lang"))->name or null }}</option>
                                @endforeach
                            </select>
                            <select name="country_id" class="form-control select_form">
                                <option value="" selected>اختر البلد</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_trans(App("lang"))->name or $country->country_trans("en")->name }}</option>
                                @endforeach
                            </select>
                            <select name="type" class="form-control select_form">
                                <option value="" selected>نوع الدورة</option>
                                <option value="online">أون لاين</option>
                                <option value="presence">حضور</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">ابحث الان</button>
                    </form>
                </div>
             
            </div>
        </div>
    </div>



    <div class="courses">
        <div class="container">
            <div class="content">
               <span> <h4>الدورات التدريبية</h4><span>
               <!--  <img src="{{asset('assets/front/img/line_copy.png')}}" /> -->
            </div>
            <div class=" company_courses ">
                <div class="row justify-content-around">
                    @include("front.courses._courses")
                </div>
            </div>
            <button onclick="js:location.href='{{url(App('urlLang').'all-courses')}}'" class="view_more">مشاهدة المزيد</button>
        </div>
    </div>



    <div class="video_content">
        <div class="container">
            <div class="video_head">
             <h4>الاكاديمية</h4>
            </div>
            <div class="row">
            <div class="col-md-6 ">
                <p>
                    لازلنا مستمرين في الاكاديمية السويدية للتدريب الرياضي SASTفي تعريب العديد من البرامج التدريبية ، بما يضمن إتاحة وتقديم المعارف العلمية المعاصرة في القارة العجوز باللغة العربية مع التركيز على قدرة جميع الطلاب على التفاعل الحيوي والذي يؤسس بالنتيجة لخلق فئة متعلمة ومستنيرة تستطيع المساهمة بشكل فعال في عملية البناء والتنوير في العالم العربي.

                    تقوم ادارة الاكاديمية السويدية للتدريب الرياضي SASTبالتنسيق الدائم والمستمر مع الكثير من الجامعات والمعاهد والاكاديميات الاوربية والدولية ، والتواصل مع خيرة المدربين والخبراء المحترفين في تخصصاتهم الرياضية لاستقدامهم واستثمارهم في تطوير منظومات عربية متخصصة بجودة الممارسة المهنية للفئات المهنية الراقية في العالم العربي من مدربين ومحاضرين رياضيين او متخصصين في المهن الرياضية المختلفة. وذلك لتسهيل انضمام تلك الفئات العربية في العديد من التخصصات المهنية الأكثر طلباً في السوق العربي والعالمي بما يخدم جهود التنمية و التطوير في المجتمع العربي الكبير من المحيط إلى الخليج.
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
    				<h4>الاعتماد الدولي</h4>
    			</div>
			<div class="swiper-contain">
				<div class="row certificate">
					<div class="owl-carousel owl-theme" style="direction: ltr;">
						<!-- <div class="item">
							<a href="http://www.europeactive.eu/" target="_blank"><img src="https://swedish-academy.se/assets/front/img/erpactive.png" /></a>
						</div> -->
						<div class="item">
							<a href="http://www.icsspe.org/content/members-headquarters" target="_blank"><img src="https://swedish-academy.se/assets/front/img/ICSSPE.png" /></a>
						</div>
					   <!-- 	<div class="item">
							<a href="http://www.ereps.eu/civicrm/profile/view?reset=1&id=51343&gid=38" target="_blank"><img src="https://swedish-academy.se/assets/front/img/EREPS.png" /></a>
						</div> -->
                        <div class="item">
                            <a href="https://internationalhandballcenter.com/" target="_blank"><img src="https://swedish-academy.se/assets/front/img/handballcenter.png" /></a>
                        </div>

                        <div class="item">
                            <a href="http://sjsr.se/en/home.php" target="_blank"><img src="https://swedish-academy.se/assets/front/img/sjsr.png" /></a>
                        </div>
					
						<div class="item">
							<a href="http://gcss.se" target="_blank"><img src="https://swedish-academy.se/assets/front/img/GCSS.png" /></a>
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
                <h4> المدربين </h4>
        <!-- <img src="{{asset('assets/front/img/line_copy_w.png')}}" /> -->
            </div>
            <div class="swiper-contain coaches_content">
                <div class="row justify-content-around">
                    <div class="owl-carousel owl-theme" style="direction: ltr;">
                         @foreach($teachers as $teacher)

                        <div class="item coach_header">
                            <img class="header_2" src="{{ asset("uploads/kcfinder/upload/image/users/".$teacher->user->image) }}" >
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
                    <div class="academy_student">
                        <a href="/login" class="content">
                            <span>انضم الي</span>
                            <p>طلاب الاكاديمية</p>
                        </a>
                        <a href="{{ url(App('urlLang').'account') }}" type="button" class="btn btn-primary btn-sign">سجل الأن</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 join">
                    <div class="academy_trainer">
                        <a href="/test/contact" class="content">
                            <span>انضم الي</span>
                            <p>مدربي للاكاديمية</p>
                        </a>
                        <a href="{{ url(App('urlLang').'contact') }}" type="button" class="btn btn-primary btn-sign">إتصل بنا</a>
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
                <h4>اراء الطلبة</h4>
            </div>
            <div class="clients_feedback">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($testimonials as $testimonial)
                            <div class="carousel-item {{ $loop->first?'active':null }}">
                                <div class="media">
                               <!--      <img class="align-self-center mr-3" src="{{asset('uploads/kcfinder/upload/image/'.$testimonial->image)}}" alt="{{$testimonial->testimonial_trans(App("lang"))->title or null}}"> -->
                                    <div class="media-body align-self-center">
                                        <p>{{ $testimonial->testimonial_trans(App("lang"))->description or null }}</p>
                                    </div>
                                </div>
                                <p class="client_name">{{ $testimonial->testimonial_trans(App("lang"))->name or null }}</p>
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

</script>
@stop
