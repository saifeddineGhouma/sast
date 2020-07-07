<?php
$setting = App('setting');
$setting_trans = $setting->settings_trans(session()->get('locale'));
if(empty($setting_trans))
    $setting_trans = $setting->settings_trans('en');
?>
<div class="footer">
	<div class="container">

			
			<div class="social_media">
                <div class="row justify-content-center">
				  <?php $__currentLoopData = App('setting')->socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-1">
                                <div class="background">
                                        <div class="circle">
                                             <a href="<?php echo e($social->link); ?>" target="_blank"><i class="<?php echo e($social->font); ?>  " ></i></a>
                                        </div>
                                </div>
                        </div>
						 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                </div>
			</div>
		<?php $textalgn = session()->get('locale') === "ar" ? "right" : "left" ?>
		<div class="row" dir= <?php echo e($dir); ?> style="text-align: <?php echo e($textalgn); ?>"> 
		

			<div class="col-lg-4 col-md-4  col-sm-12 ">
				<?php if(Session::get("locale") == "ar"): ?>
					<ul class="website_category" style="text-align: <?php echo e($textalgn); ?>">
						<?php
							$menuPos = App\MenuPos::find(3);
							$menu = $menuPos->menus()->first();
						?>
						<?php if(!empty($menu)): ?>
							<?php echo $menu->links("footer"); ?>

						<?php endif; ?>
					</ul>
					<ul class="website_category " style="text-align: <?php echo e($textalgn); ?>">
						<?php
							$menuPos = App\MenuPos::find(4);
							$menu = $menuPos->menus()->first();
						?>
						<?php if(!empty($menu)): ?>
							<?php echo $menu->links("footer"); ?>

						<?php endif; ?>
					</ul> 
				<?php else: ?>
					<ul class="website_category " style="text-align: <?php echo e($textalgn); ?>">
						<?php
							$menuPos = App\MenuPos::find(4);
							$menu = $menuPos->menus()->first();
						?>
						<?php if(!empty($menu)): ?>
							<?php echo $menu->links("footer"); ?>

						<?php endif; ?>
					</ul> 
					<ul class="website_category" style="text-align: <?php echo e($textalgn); ?>">
							<?php
								$menuPos = App\MenuPos::find(3);
								$menu = $menuPos->menus()->first();
							?>
							<?php if(!empty($menu)): ?>
								<?php echo $menu->links("footer"); ?>

							<?php endif; ?>
					</ul>
				<?php endif; ?>

			</div>

			<div class="col-lg-4 col-md-4  col-sm-12 ">

				<div class="mail">
					<i class="fa fa-envelope"   style="color:#ffcb05" aria-hidden="true"></i>
					<span><?php echo e($setting->email); ?></span>
				</div>
				<div class="phone">
					<i class="fa fa-phone"  style="color:#ffcb05" aria-hidden="true"></i>
					<span><?php echo e($setting->mobile); ?></span>
				</div>
			</div>	
			<div class="col-lg-4 col-md-4 col-sm-6  feedback_footer ">
				<form class="newsletter-form" method="post">
					<div class="displayNewsletter" style="display: none;"></div>
					<div class="form-group"><i class="fa fa-envelope" style='font-size:14px;color:#ffcb05;'></i><span style="color:#ffcb05;font-size:18px;">  <?php echo app('translator')->getFromJson('navbar.followUs'); ?></span>
					<input class="form-control feedback_send newsletter-email" type="text" placeholder="<?php echo app('translator')->getFromJson('navbar.tapeMailToFollow'); ?>">
					</div>
					<button data-loading-text="<?php echo app('translator')->getFromJson('navbar.following'); ?>" class="subscribe"><?php echo app('translator')->getFromJson('navbar.follow'); ?></button>

				</form>

			
			</div>
		</div>
	</div>
</div>
<!-- End Footer -->

<!-- Start CopyRight -->
<div class="copyright">
	<p><?php echo app('translator')->getFromJson('navbar.footertext'); ?> </p>
</div>
<!-- End CopyRight -->