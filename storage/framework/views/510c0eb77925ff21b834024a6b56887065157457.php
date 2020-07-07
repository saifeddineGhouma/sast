<?php $__env->startSection('meta'); ?>

	<title>الكتب</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>الكتب</span> 
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="row">
                <?php echo $__env->renderEach("front.books._book",$books,'book'); ?>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>