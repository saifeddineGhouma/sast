<?php $__env->startSection('styles'); ?>	
	<link href="<?php echo e(asset('assets/front/vendors/validation/css/bootstrapValidator.min.css')); ?>" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/vendors/build/css/intlTelInput.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
	<title><?php echo e(trans('home.login_register')); ?></title>	
	<?php
		$setting = App('setting');
		$setting_trans = $setting->settings_trans(Session::get('locale'));
		if(empty($setting_trans))
			$setting_trans = $setting->settings_trans('en');
	?>
	<meta name="keywords" content="<?php echo e($setting_trans->meta_keyword); ?>" />
	<meta name="description" content="<?php echo e($setting_trans->meta_description); ?>">
<?php $__env->stopSection(); ?>
<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>

<?php $__env->startSection('content'); ?>
<div class="training_purchasing">
	<div class="container training_container">
		<div class="media" style="direction:<?php echo e($dir); ?>">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">

					<li class="breadcrumb-item">
						<i class="fa fa-home" aria-hidden="true"></i>
						<a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						<span><?php echo e(trans('home.login_register')); ?></span>
					</li>
				</ol>
			</nav>
		</div>

	</div>
</div>

<div class="login-area">
	<div class="container">
		<div class="row">
			<div class="col-md-6 login-form" style="direction:<?php echo e($dir); ?>">
				<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true"><?php echo e(trans('home.you_have_account')); ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="profile" aria-selected="false"><?php echo e(trans('home.new_user')); ?></a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent" style="text-align: justify">
					<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
						<?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						
						<form method="POST" id="login-form" action="<?php echo e(url(App('urlLang').'login')); ?>">
							<p><?php echo e(trans('home.login')); ?></p>
							
							<?php echo csrf_field(); ?>

							<?php if(session('status')): ?>
								<div class="alert alert-success">
									<?php echo e(session('status')); ?>

								</div>
							<?php endif; ?>
							<?php if(isset($msg)): ?>
								<div class="alert alert-danger alert-noborder">
									<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>

									<ul>
										<li><?php echo e(trans('home.close_account')); ?> <a href="https://swedish-academy.se/contact"><?php echo e(trans('home.contact_us')); ?></a></li>
									</ul>
								</div>
							<?php endif; ?>
							<div class="form-group <?php echo e($errors->has('login') ? ' has-error' : ''); ?>">
								<label for="InputEmail"> <?php echo e(trans('home.username_email_mobile')); ?> <span>*</span></label>
								<input type="text" class="form-control required" id="InputEmail"  name="login" value="<?php echo e(old('login')); ?>">
								<?php if($errors->has('login')): ?>
									<span class="help-block">
		                                <strong><?php echo e($errors->first('login')); ?></strong>
		                            </span>
								<?php endif; ?>
							</div>

							<div class="form-group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
								<label for="InputPassword"> <?php echo e(trans('home.password')); ?> <span>*</span></label>
								<input type="password" class="form-control required" name="password">
								<?php if($errors->has('password')): ?>
									<span class="help-block">
		                                <strong><?php echo e($errors->first('password')); ?></strong>
		                            </span>
								<?php endif; ?>
							</div>

							<div class="form-check col-md-6">
								<input type="checkbox" class="form-check-input" name="remember">
								<label class="form-check-label" for="Check"><?php echo e(trans('home.remember_me')); ?></label>
							</div>

							<div class="form-check password-recover col-md-6">
								<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false"><?php echo e(trans('home.forget_pwd')); ?></a>
									</li>
								</ul>

							</div>
							<div class="clear"></div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-login"><?php echo e(trans('home.sign_up')); ?></button>
							</div>
							<div class="clear"></div>
							<div class="login-or">
								<hr class="hr-or">
								<span class="span-or"><?php echo e(trans('home.or')); ?></span>
							</div>
							<div class="row text-center omb_socialButtons">
								<div class="col-xs-4">
									<a href="<?php echo e(url(App('urlLang').'facebooklogin')); ?>" class="btn omb_btn-facebook">
										<i class="fa fa-facebook"></i>
									</a>
								</div>
								<div class="col-xs-4">
									<a href="<?php echo e(url(App('urlLang').'twitterlogin')); ?>" class="btn omb_btn-twitter">
										<i class="fa fa-twitter"></i>
									</a> 
								</div>
								<div class="col-xs-4">
									<a href="<?php echo e(url(App('urlLang').'googlelogin')); ?>" class="btn omb_btn-google">
										<i class="fa fa-google-plus"></i>
									</a>
								</div>
							</div>
						</form>
					</div>


					<div class="tab-pane fade" id="signin" role="tabpanel" aria-labelledby="profile-tab">
						<form method="POST" id="register-form" action="<?php echo e(url(App('urlLang').'register')); ?>">
							<?php echo csrf_field(); ?>

							<div class="form-group">
								<label for="InputEmail"> <?php echo e(trans('home.nom_user')); ?> <span>*</span></label>
								<input type="text" class="form-control" name="username" value="<?php echo e(old('username')); ?>">
							</div>

							<div class="form-group">
								<label for="InputEmail">  <?php echo e(trans('home.your_email')); ?> <span>*</span></label>
								<input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>">
							</div>

							<div class="form-group">
								<label>  <?php echo e(trans('home.num_tel')); ?> <span>*</span></label>
								<input type="text" class="form-control" id="mobile1" name="mobile1" value="<?php echo e(old('mobile')); ?>">
							</div>

							<div class="form-group">
								<label for="InputPassword"><?php echo e(trans('home.pwd')); ?>  <span>*</span></label>
								<input type="password" class="form-control" name="password">
							</div>

							<div class="form-group">
								<label for="InputPassword"><?php echo e(trans('home.confirm_pwd')); ?>  <span>*</span></label>
								<input type="password" class="form-control" name="confirm_password">
							</div>

							<div class="form-check">
								<input type="checkbox" class="form-check-input" name="agreement">
								<label class="form-check-label" for="Check">
								<?php echo e(trans('home.accepter_cond')); ?>	
									<a href="/pages/usage-policy">
									<?php echo e(trans('home.condition_term')); ?> <?php echo e(trans('home.and')); ?> <?php echo e(trans('home.privacy_police')); ?>

									</a>
									


								</label>
							</div>

							<div class="clear"></div>
							<div class="col-md-12 text-center">
								<button type="submit" id="signup_submit" data-loading-text="<?php echo e(trans('home.signing_up')); ?>" class="btn btn-login"><?php echo e(trans('home.sign_up')); ?></button>
							</div>
						</form>
					</div>

					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
						<form method="POST" action="<?php echo e(url(App('urlLang').'password/email')); ?>" >
							<?php echo csrf_field(); ?>

							<p><?php echo e(trans('home.please_enter_email_reset')); ?></p>
							<?php if(session('status')): ?>
								<div class="alert alert-success">
									<?php echo e(session('status')); ?>

								</div>
							<?php endif; ?>
							<div class="form-group">
								<label for="InputEmail">  <?php echo e(trans('home.your_email')); ?> <span>*</span></label>
								<input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>">
								<?php if($errors->has('email')): ?>
									<span class="help-block">
				                    <strong><?php echo e($errors->first('email')); ?></strong>
				                </span>
								<?php endif; ?>
							</div>

							<div class="clear"></div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-login"><?php echo e(trans('home.send')); ?></button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>




<div id="loadmodel_category" class="modal fade in" role="dialog"  style="display:none; padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
                <img src="<?php echo e(asset('assets/admin/img/ajax-loading.gif')); ?>" alt="" class="loading">
                <span> &nbsp;&nbsp;<?php echo e(trans('home.signing_up')); ?> </span>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('assets/front/vendors/build/js/intlTelInput.js')); ?>"></script>
	<script>
        $("#mobile1").intlTelInput({
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: "off",
            // dropdownContainer: "body",
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            hiddenInput: "mobile",
             initialCountry: "auto",
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            placeholderNumberType: "MOBILE",
            // preferredCountries: ['cn', 'jp'],
            // separateDialCode: true,
            utilsScript: "<?php echo e(asset('assets/front/vendors/build/js/utils.js')); ?>"
        });

	</script>

	<script src="<?php echo e(asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>
	<?php echo $__env->make("front.auth.js.login_js", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>