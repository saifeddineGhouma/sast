<?php $__env->startSection('meta'); ?>
<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php
    $page_trans = $page->page_trans(session()->get('locale'));
	if(empty($page_trans))
		$page_trans = $page->page_trans("en");
?>
	<title><?php echo e(!empty($page_trans->meta_title)?$page_trans->meta_title:$page_trans->title); ?></title>
	<meta name="keywords" content="<?php echo e($page_trans->meta_keyword); ?> " />
	<meta name="description" content="<?php echo e($page_trans->meta_description); ?> ">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction: <?php echo e($dir); ?> ">
                <nav aria-label="breadcrumb"> 
                    <ol class="breadcrumb"> 
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" style="direction:<?php echo e($dir); ?>">
                            <span><?php echo e($page_trans->title); ?></span>

                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area" style="direction:<?php echo e($dir); ?>; text-align: justify ;">
        <div class="container">
            <div class="row"> 
                
                <p>
                    <?php echo $page_trans->content; ?>

                </p>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>