<?php $alignText = session()->get('locale') === "ar" ? "right" : "left" ?>
<div class="col-lg-3 text-right  filteration_method">
    <?php if(!$user->email_verified): ?>
        <div class="alert alert-info" data-alert="" style="text-align: <?php echo e($alignText); ?>" ><ul>
                <li><?php echo e(trans('home.you_notverified_email')); ?> <a href="<?php echo e(url(App('urlLang').'account/email-verification')); ?>" style='color: #23a1d1;'><?php echo e(trans('home.click_here')); ?> </a><?php echo e(trans('home.to_activate')); ?>.</li>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
  
    <div class="m-menu account_content text-right" style="direction:<?php echo e($dir); ?>" >
        <h5 class="head-side"><i class="fa click fa-bars" title="Click me!"></i> <?php echo e(trans('home.control_panel')); ?> </h5>
        <ul style="text-align: <?php echo e($alignText); ?>" >
            <li><a href="<?php echo e(url(App('urlLang').'account')); ?>" class="link-side"><span><i class="fa fa-th-large"></i><?php echo e(trans('home.home')); ?> </span></a></li>
            <li><a href="<?php echo e(url(App('urlLang').'account/info')); ?>" class="link-side"><span><i class="fa fa-pencil"></i> <?php echo e(trans('home.modifier_coordonne')); ?></span></a></li>
            <li><a href="<?php echo e(url(App('urlLang').'account/change-password')); ?>" class="link-side"><span><i class="fa fa-lock"></i> <?php echo e(trans('home.password')); ?></span></a></li>
        </ul>
        <ul style="text-align: <?php echo e($alignText); ?> ">
            <h5 class="head-side"><?php echo e(trans('home.the_shopping')); ?> </h5>
            <li><a href="<?php echo e(url(App('urlLang').'account/orders')); ?>" class="link-side"><span><i class="fa fa-credit-card"></i> <?php echo e(trans('home.mes_demandes')); ?></span></a></li>
            <li><a href="<?php echo e(url(App('urlLang').'account/points')); ?>" class="link-side"><span><i class="fa fa-shopping-bag"></i> <?php echo e(trans('home.mes_points')); ?></span></a></li>
            <li><a href="<?php echo e(url(App('urlLang').'account/coupons')); ?>" class="link-side"><span><i class="fa fa-shopping-bag"></i> <?php echo e(trans('home.my_coupons')); ?></span></a></li>
        </ul>
        <ul style="text-align: <?php echo e($alignText); ?>">
            <h5 class="head-side"><?php echo e(trans('home.certif_book')); ?></h5>
            <li><a href="<?php echo e(url(App('urlLang').'account/certificates')); ?>" class="link-side"><span><i class="fa fa-graduation-cap"></i> <?php echo e(trans('home.certif_compte')); ?></span></a></li>
            <li><a href="<?php echo e(url(App('urlLang').'account/books')); ?>" class="link-side"><span><i class="fa fa-file"></i><?php echo e(trans('home.books_compte')); ?> </span></a></li>	
			<?php if(isset($user->teacher->id)): ?>		
				<li>
					<a href="<?php echo e(url(App('urlLang').'/teachers/')); ?>" class="link-side"><span><i class="fa fa-file"></i><?php echo e(trans('home.home')); ?> لوحة المفاتيح</span></a>
				</li>
			<?php endif; ?>
            <li><a href="<?php echo e(url(App('urlLang').'account/ticket')); ?>" class="link-side"><span><i class="fa fa-sign-out"></i> <?php echo e(trans('home.demande_aide')); ?></span></a></li>
            <li><a href="<?php echo e(url(App('urlLang').'account/desactive')); ?>" class="link-side"><span><i class="fa fa-sign-out"></i><?php echo e(trans('home.close_account')); ?> </span></a></li>
            <li><a href="<?php echo e(url(App('urlLang').'logout')); ?>" class="link-side"><span><i class="fa fa-sign-out"></i> <?php echo e(trans('home.logout')); ?></span></a></li>
        </ul>
    </div>
</div>