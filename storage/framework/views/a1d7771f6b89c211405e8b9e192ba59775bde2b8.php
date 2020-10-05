<!DOCTYPE html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/front/img/favicon/apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e(asset('assets/front/img/favicon/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('assets/front/img/favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('assets/front/img/favicon/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('assets/front/img/favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('assets/front/img/favicon/manifest.json')); ?>">
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('assets/front/img/favicon/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">
    <style>
        .top-link {
          transition: all .25s ease-in-out;
          position: fixed;
          bottom: 0;
          right: 0;
          display: inline-flex;
          cursor: pointer;
          align-items: center;
          justify-content: center;
          margin: 0 3em 3em 0;
          border-radius: 50%;
          padding: .25em;
          width: 80px;
          height: 80px;
          background-color: transparent;
          border:none;
           outline:none;
        }
        .top-link:active{ box-shadow: 0 5px #666;
         transform: translateY(4px); outline:none;
            
        }
        .top-link.show {
          visibility: visible;
          opacity: 1;
        }
        .top-link.hide {
          visibility: hidden;
          opacity: 0;
        }
        
    </style>

<!--Adsense code --> 
<script data-ad-client="ca-pub-9816135127760407" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127418084-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-127418084-2');
</script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1902058279805929');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1902058279805929&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


	<script src='https://www.google.com/recaptcha/api.js'></script>

	<!--------------->
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<?php echo $__env->yieldContent("meta"); ?>
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/bootstrap.min.css')); ?>">
	<?php if(App('lang')=="ar"): ?>
		<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/bootstrap-rtl.css')); ?>">
	<?php endif; ?>
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/jquery-ui.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/font-awesome.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/swiper.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/style.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/media.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset("/vendors/sweetalert/sweetalert.css")); ?>">
	<?php echo $__env->yieldContent("styles"); ?>
	<style>
		.display-none{display:none;}
		#fc_widget{margin-top: 0px !important;}
	</style>
	<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/a1b68963b542466ee12238e90/8098f71e1e7a79453248389b3.js");</script>
</head>

<body>
	<?php $locale = session()->get('locale') ?>
	<?php $dir = $locale === "ar" ? "rtl" : "ltr" ?>
    

	<?php echo $__env->make("front.layouts._header", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php if(Session::has("alert-success")): ?>
		<div class="alert alert-success" style="direction: <?php echo e($dir); ?>;text-align: justify;"><?php echo Session::get('alert-success'); ?></div>
	<?php endif; ?>
	<?php if(Session::has("alert-danger")): ?>
		<div class="alert alert-danger" style="direction: <?php echo e($dir); ?>;text-align: justify;"><?php echo Session::get('alert-danger'); ?></div>
	<?php endif; ?>
	<?php echo $__env->yieldContent("content"); ?>
	<?php echo $__env->make("front.layouts._footer", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
	<div id="content_loading" class="modal fade show" role="dialog"  style="display:none; padding-right: 17px;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<img src="<?php echo e(asset('assets/admin/img/ajax-loading.gif')); ?>" alt="" class="loading">
					<span> &nbsp;&nbsp;<?php echo e(trans('home.loading')); ?> </span>
				</div>
			</div>
		</div>
	</div>
	
    <button type="button" id="js-top" class="btn btn-primary top-link hide" data-toggle="modal" data-target="#modalDiscount"><img src="https://img.icons8.com/plasticine/100/000000/gift.png" style="margin-left: -3rem;padding-top: 5rem;width: 4rem;"/></button>
     <!--Modal: modalDiscount-->
    <div class="modal fade right" id="modalDiscount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true" data-backdrop="true">
      <div class="modal-dialog modal-side modal-bottom-right modal-notify modal-danger" role="document">
        <!--Content-->
            <div class="modal-dialog">
              <div class="modal-content">
               
                <div class="modal-body" style="text-align: justify;"> 

                        <a href="https://swedish-academy.se/packs/6">
                            <img src="/uploads/kcfinder/upload/image/pages/pack.png" class="card-img-top"  width="100%" style="margin-top:33rem">
                        </a>

               </div>
              </div>
            </div>
        <!--/.Content-->
      </div>
    </div>
    <!--Modal: modalDiscount-->
	<script src="<?php echo e(asset('assets/front/js/jquery.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/front/js/jquery-ui.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/front/js/popper.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/front/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('assets/front/js/swiper.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/front/js/script.js')); ?>"></script>
	<script src="<?php echo e(asset('/adminDash/vendors/sweetalert/sweetalert.min.js')); ?>"></script>
	<script>
	    // Set a variable for our button element.
const scrollToTopButton = document.getElementById('js-top');

// Let's set up a function that shows our scroll-to-top button if we scroll beyond the height of the initial window.
const scrollFunc = () => {
  // Get the current scroll value
  let y = window.scrollY;
  
  // If the scroll value is greater than the window height, let's add a class to the scroll-to-top button to show it!
  if (y > 0) {
    scrollToTopButton.className = "top-link show";
  } else {
    scrollToTopButton.className = "top-link hide";
  }
};

window.addEventListener("scroll", scrollFunc);

const scrollToTop = () => {
  // Let's set a variable for the number of pixels we are from the top of the document.
  const c = document.documentElement.scrollTop || document.body.scrollTop;
  
  // If that number is greater than 0, we'll scroll back to 0, or the top of the document.
  // We'll also animate that scroll with requestAnimationFrame:
  // https://developer.mozilla.org/en-US/docs/Web/API/window/requestAnimationFrame
  if (c > 0) {
    window.requestAnimationFrame(scrollToTop);
    // ScrollTo takes an x and a y coordinate.
    // Increase the '10' value to get a smoother/slower scroll!
    window.scrollTo(0, c - c / 10);
  }
};

// When the button is clicked, run our ScrolltoTop function above!
scrollToTopButton.onclick = function(e) {
  e.preventDefault();
  scrollToTop();
}
	</script>
	<?php echo $__env->make("front.layouts.js._newsletter_js", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->yieldContent("scripts"); ?>
	<?php if($user = Auth::user()): ?>
		<script src="https://wchat.freshchat.com/js/widget.js"></script>
		<script>
		  window.fcWidget.init({
		    token: "2c29fe31-f567-4a42-bf3b-6a72d911afde",
		    host: "https://wchat.freshchat.com"
		  });
		</script> 
		<script>
		  window.fcWidget.setExternalId('<?php echo e($user->username); ?>');

		  window.fcWidget.user.setFirstName('<?php echo e($user->full_name_ar); ?>');

		  window.fcWidget.user.setEmail('<?php echo e($user->email); ?>');

		  window.fcWidget.user.setProperties({
		    plan: "Estate",                 
		    status: "Active"                
		  });
		</script>
	<?php else: ?>
		<script src="https://snippets.freshchat.com/js/fc-pre-chat-form.js"></script>
		<script>
		  fcPreChatFormData = { 
		    //Form header color and Submit button color.
		    mainbgColor: '#0aa4db',
		    //Form Header Text and Submit button text color.
		    maintxColor: '#fff',
		    //Chat Form Title
		    title: 'الاكاديمية السويدية للتدريب الرياضي',
		    //Chat form Welcome Message 
		    textBanner: 'يمكنك التواصل معنا عبر الشات من هنا',
		    //Name field Label
		    nameLabel: 'الإسم',
		    //Set reqName as 'required' if you want the name field to be mandatory.
		    reqName: 'غير مطلوب',
		    //If name field is set as mandatory, then the below message will be displayed if the field value is not valid or empty.
		    nameError: 'الرجاء إدخال إسم صحيح :)',
		    //To not display the Email, set the value to 'no'
		    showEmail: 'نعم',
		    //Email field label
		    emailLabel: 'البريد الالكتروني',
		    //Set reqEmail as 'required' if you want the field to be mandatory. 
		    reqEmail: 'غير مطلوب',
		    //If email field is set as mandatory, then the below message will be displayed if the field value is not valid or empty.
		    emailError: 'الرجاء إدخال بريد إلكتروني صالح',
		    //To not display the Phone, set the value to 'no'
		    showPhone: 'نعم',
		    //Phone Field Label
		    phoneLabel: 'رقم الهاتف',
		    //Set reqPhone as 'required' if you want the field to be mandatory.
		    reqPhone: 'مطلوب',
		    //If phone field is set as mandatory, then the below message will be displayed if the field value is not valid or empty.
		    phoneError: 'الرجاء إدخال رقم هاتف صالح',
		    //Submit Button Label.
		    SubmitLabel: 'إبدأ',
		  };
		  window.fcSettings = {
		    token: '2c29fe31-f567-4a42-bf3b-6a72d911afde',
		    host: "https://wchat.freshchat.com",
		    config: {
		      cssNames: {
		        //The below element is mandatory. Please add any custom class or leave the default.
		        widget: 'custom_fc_frame',
		        //The below element is mandatory. Please add any custom class or leave the default.
		        expanded: 'custom_fc_expanded'
		      }
		    },
		    onInit: function() {
		      console.log('widget init');
		      fcPreChatform.fcWidgetInit(fcPreChatFormData);
		    }
		  };
		</script>
		<script src="https://wchat.freshchat.com/js/widget.js"></script>
	<?php endif; ?>
</body>
</html>	