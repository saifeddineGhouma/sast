<?php $__env->startSection('meta'); ?>

<?php
	$setting_trans = $setting->settings_trans(App('lang'));
	if(empty($setting_trans))
		$setting_trans = $setting->settings_trans('en');
?>
	<title><?php echo e($setting_trans->meta_title); ?></title>
	<meta name="keywords" content="<?php echo e($setting_trans->meta_keyword); ?>" />
	<meta name="description" content="<?php echo e($setting_trans->meta_description); ?>">	
 
<?php $__env->stopSection(); ?>

<?php
    $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ;
    $align = session()->get('locale') === "ar" ? "right" : "left" ;
    $locale = session()->get('locale');
?>    
<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?> 

<div class="modal" id="infos" style="direction:<?php echo e($dir); ?>">
    <div class="modal-dialog">
      <div class="modal-content" style="text-align: center">
       
        <img src="<?php echo e(asset('uploads/kcfinder/upload/image/'.App("setting")->settings_trans(App('lang'))->logo)); ?>" alt="Swedish" title="Swedish">

        <div class="modal-body" style="text-align: center;">
           <?php echo app('translator')->getFromJson('navabr.partner_Swedish_Academy'); ?>  
        <br>
        <button onclick="js:location.href='<?php echo e(url(App('urlLang').'partnership')); ?>'" type="button" class="btn btn-primary" > سجل الان  </button>
        </div>
            
        <div class="modal-footer" style="display: <?php echo e($locale === "ar" ? "" : "inline-flex"); ?>" >
          <button type="button"  data-dismiss="modal"><?php echo e(trans('home.fermer_popup_contact')); ?></button>
        </div>
      </div>
    </div>
</div>





<aside class="slider">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $__currentLoopData = $sliderImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sliderImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($key); ?>" <?php if($loop->first): ?>class="active"<?php endif; ?>></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
            <div class="carousel-inner">
                <?php $__currentLoopData = $sliderImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sliderImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="carousel-item item <?php echo e($loop->first?'active':null); ?>">
                        <img class="d-block w-100" src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$sliderImage->image)); ?>"  alt="<?php echo e($sliderImage->title); ?>">
                        <div class="slider_info "  style="direction: <?php echo e($dir); ?>;text-align: <?php echo e($align); ?>;">
                            <h3 style="text-align: <?php echo e($align); ?>;"><?php echo app('translator')->getFromJson('navbar.sliderSpecialite'); ?></h3>
                            <h1 style="text-align: <?php echo e($align); ?>;"><?php echo app('translator')->getFromJson('navbar.sliderTitre', ['sliderTitre' => $sliderImage->title]); ?> </h1>
                            <h3 style="text-align: <?php echo e($align); ?>;"><?php echo app('translator')->getFromJson('navbar.sliderDesc', ['sliderDesc' => $sliderImage->description]); ?></h3>
                            <button onclick="location.href='<?php echo e($sliderImage->link); ?>'" class="start_now"><?php echo app('translator')->getFromJson('navbar.startNow'); ?></button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </aside>
    <!-- End Slider -->
<!-- <?php echo $setting_trans->index_section; ?> -->

<!-- <div class="welcome">
    <div class="container">
        <div class="welcome_head"> -->
<div class="video_content">
        <div class="container">
            <div class="video_head">         
                <h4><?php echo e(trans('home.welcom_in_academy_index')); ?></h4>
          
            </div>                           
                <div class="page-header hello_in_sast">
                      
                    <div class="row" style="margin-bottom: 20px;">
                      <!--  <div class="col-md-4">
                             <img src="https://swedish-academy.se/assets/front/img/sast_img.png" />
                                <h3 class="ddnn"> د. علي  فالح سلمان<span>مدير الأكاديمية</span></h3>
                        </div> 
                        <div class="col-md-8">-->
                               
                                 
                                <p style = "direction : <?php echo e($dir); ?>"><?php echo e(trans('home.paragraphe_welcome_in_academy_index')); ?></p>

                                <button onclick="js:location.href='https://swedish-academy.se/pages/%D9%85%D8%B1%D8%AD%D8%A8%D8%A7-%D8%A8%D9%83%D9%85'" class="view_more">  <?php echo e(trans('home.read_more_welcome_academy_index')); ?> </button>

                        <!-- </div> -->
                                
                    </div>
                </div>
    </div>
    
</div>
   
  


 <div class="statistique" style="direction:<?php echo e($dir); ?>">
        <div class="container">
             <div class="stat_head">  
                    <div class="row" style="text-align: justify">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="<?php echo e(asset('assets/front/img/icon1.png')); ?>"></div>
                                <div class="media-body-icon ">
                                    <h3 class="mt-0">+<?php echo e($countTeacher); ?></h3>
                                    <p>  <?php echo e(trans('home.coach_ready_index')); ?> </p>

                                   
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="<?php echo e(asset('assets/front/img/icon2.png')); ?>"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0">+<?php echo e($countBooks); ?></h3>
                                    <p><?php echo e(trans('home.books_academy_index')); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="<?php echo e(asset('assets/front/img/icon3.png')); ?>"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0"><?php echo e($countStudents); ?></h3>
                                    <p> <?php echo e(trans('home.etudiant_inscrit_index')); ?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="media">
                                <div class="info_digram"><img class="align-self-center mr-3" src="<?php echo e(asset('assets/front/img/icon4.png')); ?>"></div>
                                <div class="media-body-icon">
                                    <h3 class="mt-0"><?php echo e($countCourses); ?></h3>
                                    <p> <?php echo e(trans('home.training_program_index')); ?></p>
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
                        <h2><?php echo e(trans('home.filtre_courses_index')); ?></h2>
                    </div>
                    <form class="search_form" action="<?php echo e(url(App('urlLang').'search')); ?>" >
                        <div class="form-group select_group"  >
                            <select name="category_id" class="form-control select_form" style="direction:<?php echo e($dir); ?>">
                                <option value="" selected> <?php echo e(trans('home.choisir_category')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e(isset($category->category_trans(Session::get('locale'))->name) ? $category->category_trans(Session::get('locale'))->name : null); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="country_id" class="form-control select_form" style="direction:<?php echo e($dir); ?>">
                                <option value="" selected><?php echo e(trans('home.choisir_pays')); ?></option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->id); ?>"><?php echo e(isset($country->country_trans(Session::get('locale'))->name) ? $country->country_trans(Session::get('locale'))->name : $country->country_trans("en")->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="type" class="form-control select_form" style="direction:<?php echo e($dir); ?>">
                                <option value="" selected><?php echo e(trans('home.type_cours')); ?></option>
                                <option value="online"><?php echo e(trans('home.online')); ?></option>
                                <option value="presence"><?php echo e(trans('home.presence')); ?></option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo e(trans('home.search_now')); ?></button>
                    </form>
                </div>
             
            </div>
        </div> 
    </div>



    <div class="courses">
        <div class="container">
            <div class="content">
               <span> <h4><?php echo e(trans('home.traning_courses_index')); ?></h4><span>
               <!--  <img src="<?php echo e(asset('assets/front/img/line_copy.png')); ?>" /> -->
            </div>
            <div class=" company_courses ">
                <div class="row justify-content-around">
                    <?php echo $__env->make("front.courses._courses", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                </div>
            </div>
            <button onclick="js:location.href='<?php echo e(url(App('urlLang').'all-courses')); ?>'" class="view_more"> <?php echo e(trans("home.voir_plus_index_courses")); ?></button>
        </div>
    </div> 



    <div class="video_content">
        <div class="container">
            <div class="video_head">
             <h4>   <?php echo e(trans("home.academy_index")); ?> </h4>
            </div> 
            <div class="row" style="direction:<?php echo e($dir); ?>">
            <div class="col-md-6"  style="text-align: justify"; >
                <p>  
                <?php echo e(trans("home.paragraphe_academy_index")); ?> 
                </p>
            </div>
            <div class="col-md-6 ">
            <span class="video_img">
             <a href="https://youtu.be/e393SPqur4k">   <img src="<?php echo e(asset('assets/front/img/academy_video.jpg')); ?>"  /></a>
             <span>
            </div>
          
            </div>
        </div> 
    </div>


    <!-- <?php echo $setting_trans->index_section2; ?> -->
<!-- 	<div class="certificate">
		<div class="container">
			<div class="certificate_info"> -->
        <div class="video_content">
            <div class="container">
                <div class="video_head">
    				<h4><?php echo e(trans("home.accreditation_internationale")); ?> </h4>
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
            <img src="<?php echo e(asset('assets/front/img/line_copy.png')); ?>" />
        </div>
        <div class="container">
            <div class="row books_category">
                <?php echo $__env->renderEach("front.books._book",$books,'book'); ?>
            </div>
            <button onclick="js:location.href='<?php echo e(url(App('urlLang').'books')); ?>'" class="view_more">مشاهدة المزيد</button>
        </div>
    </div-->

      <div class="coaches">
        <div class="container"> 
            <div class="coaches_head">
                <h4> <?php echo e(trans("home.formateur_index")); ?> </h4>
        <!-- <img src="<?php echo e(asset('assets/front/img/line_copy_w.png')); ?>" /> -->
            </div>
            <div class="swiper-contain coaches_content">
                <div class="row justify-content-around">
                    <div class="owl-carousel owl-theme" style="direction: ltr;">
                         <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="item coach_header">
                            <img class="header_2" src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$teacher->user->image)); ?>" width="207" height="202">
                             <div class="coach_more_info coach_social">
                                <div class="info_content">
                                    <?php $__currentLoopData = $teacher->socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacherSocial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e($teacherSocial->link); ?>"><i class="<?php echo e($teacherSocial->font); ?>"></i></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
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
        <!-- <img src="<?php echo e(asset('assets/front/img/line_copy_w.png')); ?>" /> 
            </div>
            <div class="coaches_content">
                <div class="row justify-content-around">
                    
                    <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="col-md-3 col-sm-6 col-xs-12 coaches_info coashes_js_two">
                        <div class="coach_header">
                            <img class="header_2" src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$teacher->user->image)); ?>" >
                            <div class="coach_more_info coach_social">
                                <div class="info_content">
                                    <?php $__currentLoopData = $teacher->socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacherSocial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e($teacherSocial->link); ?>"><i class="<?php echo e($teacherSocial->font); ?>"></i></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                        <p class="coach_name">
                            <?php echo e($teacher->user->full_name_ar); ?>

                        </p>
                        <p class="coach_country">
                            <?php echo e($teacher->nationality); ?>

                        </p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <span><?php echo e(trans("home.rejoindre_index")); ?></span>
                            <p> <?php echo e(trans("home.join_etudiant_academy")); ?></p>
                        </a>
                        <a href="<?php echo e(url(App('urlLang').'account')); ?>" type="button" class="btn btn-primary btn-sign"> <?php echo e(trans("home.register_now_index")); ?></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 join">
                    <div class="academy_trainer">
                        <a href="/partnership" class="content">
                            <span><?php echo e(trans("home.rejoindre_index")); ?> </span>
                            <p><?php echo e(trans("home.join_trainers_academy")); ?></p>
                        </a>
                        <a href="<?php echo e(url(App('urlLang').'partnership')); ?>" type="button" class="btn btn-primary btn-sign" > <?php echo e(trans("home.register_now_index")); ?></a>
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
                <h4><?php echo app('translator')->getFromJson('navbar.studentAvis'); ?></h4>
            </div>
            <div class="clients_feedback">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php $textalign = session()->get('locale') === "ar" ? "left" : "right" ?>
                        
                        <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($loop->first?'active':null); ?>">
                            <div class="media">
                           <!--      <img class="align-self-center mr-3" src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$testimonial->image)); ?>" alt=""> -->
                                <div class="media-body align-self-center">
                                    <p><?php echo e(isset($testimonial->comment) ? $testimonial->comment : null); ?>--<?php echo e($testimonial->id); ?>--</p>
                                </div>
                            </div>
                            <p class="client_name"><?php echo e(isset($testimonial->user->full_name_en) ? $testimonial->user->full_name_en : null); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>