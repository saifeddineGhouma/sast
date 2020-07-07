<?php $__env->startSection('meta'); ?>
<?php
	$course_trans = $course->course_trans(session()->get('locale'));
	if(empty($course_trans))
        $course_trans = $course->course_trans("ar");
?>
	<title><?php echo e($course_trans->meta_title); ?></title>
	<meta name="keywords" content="<?php echo e($course_trans->meta_keyword); ?>" />
	<meta name="description" content="<?php echo e($course_trans->meta_description); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

	<style>
		.display-none{
			display: none;
		}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="container-fluid " style="margin-bottom: 10px">
		<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
		<?php $textalign = session()->get('locale') === "ar" ? "right" : "left" ?>
		<div class="training_purchasing" >
			<div class="container training_container">
				<div class="media" style="direction : <?php echo e($dir); ?>">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<i class="fa fa-home" aria-hidden="true"></i>
								<a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
							</li>
							<?php $__currentLoopData = $course->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li class="breadcrumb-item">
									<a href="<?php echo e(url(App('urlLang').$category->category_trans(session()->get('locale'))->slug)); ?>">
										<?php echo e(isset($category->category_trans(session()->get('locale'))->name) ? $category->category_trans(session()->get('locale'))->name : $category->category_trans("en")->name); ?>

									</a>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<li class="breadcrumb-item active" aria-current="page">
								<span>
									<?php echo e($course_trans->name); ?>

								</span>
							</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	
	
	
</div>
<?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make("front.courses.course._header", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="courses_selection">
	<div class="container" style="direction: <?php echo e($dir); ?>">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item active">
				<a class="nav-link  " data-toggle="tab" href="#information" role="tab"  ><?php echo app('translator')->getFromJson('navbar.infoSession'); ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#curriculum" role="tab"  ><?php echo app('translator')->getFromJson('navbar.courseWay'); ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#discussion" role="tab"  ><?php echo app('translator')->getFromJson('navbar.disscussion'); ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#curriculum_exam" role="tab"  ><?php echo app('translator')->getFromJson('navbar.exams'); ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#teacher" role="tab" ><?php echo app('translator')->getFromJson('navbar.coachs'); ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#ratingcourse" role="tab" ><?php echo app('translator')->getFromJson('navbar.evaluateCoachs'); ?></a>
			</li>

		</ul>
	</div>
</div>
<!-- End Courses Selection -->
<?php if(Session::has('Review_Updated')): ?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo Session::get('Review_Updated'); ?>

	</div>
<?php endif; ?>
<div class="courses_more_info">
	<div class="container">
		<div class="row more_info_one justify-content-between tab-content">
			<div class="tab-pane fade in active show" role="tabpanel" id="information">
				<?php echo $__env->make("front.courses.course._information", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
			<div role="tabpanel" class="wide-tb  col-lg-12 tab-pane fade " id="curriculum">
				<?php echo $__env->make("front.courses.course._studies", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
			<div role="tabpanel" class="wide-tb  tab-pane fade" id="discussion">
				<?php echo $__env->make("front.courses.course._discussion", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
			<div role="tabpanel" class="wide-tb tab-pane fade" id="curriculum_exam">
				<?php echo $__env->make("front.courses.course._exams", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
            <div role="tabpanel" class="wide-tb  tab-pane fade" id="teacher">
                <?php echo $__env->make("front.courses.course._teachers", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div role="tabpanel" class="wide-tb  tab-pane fade" id="ratingcourse">
                <?php echo $__env->make("front.courses.course._reviews", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
</div>

<div class="courses_most_requested">
    <div class="courses">
        <div class="container">
            <div class="content">
                <h4><?php echo app('translator')->getFromJson('navbar.mostsession'); ?></h4>
                <img src="<?php echo e(asset('assets/front/img/line_copy.png')); ?>" />
            </div>
            <div class="company_courses ">
                <div class="row">
                    <?php echo $__env->make("front.courses._courses",["courseTypes"=>$topCourseTypes], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
		<script src="<?php echo e(asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>
		<script>
			function alerttt(){
				alert("الرجاء الإنتظار 5دقائق لإعادة المحاولة");
			}
		</script>
		
	<script>
		function downloadf(fichier){
			//alert("afef");
			downloadURL('https://swedish-academy.se/uploads/kcfinder/upload/file/'+fichier);
		}
	</script>
	<?php echo $__env->make("front.courses.js.view_js", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>