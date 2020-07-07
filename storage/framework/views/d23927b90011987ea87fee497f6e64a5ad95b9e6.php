<?php $__env->startSection('meta'); ?>
<?php
	if($type=="category"){
		$cat_trans = $category->category_trans(session()->get('locale'));
		if(empty($cat_trans))
			$cat_trans = $category->category_trans("en");
	}else{
		$cat_trans = App('setting')->settings_trans(session()->get('locale'));
		if(empty($cat_trans))
			$cat_trans = App('setting')->settings_trans("en");
	}
	
	function recurseFromFirstParent($subcat,$category){
		$parent = $subcat->maincat;
		$subcat_trans = $subcat->category_trans(session()->get('locale'));
		if(empty($subcat_trans))
			$subcat_trans = $subcat->category_trans("en");
		if(!empty($parent)){											
			recurseFromFirstParent($parent,$category);
		}
        echo '<li class="breadcrumb-item">';
        if($category!=$subcat)
            echo '<a href="'.url(App("urlLang").$subcat_trans->slug).'">';
        else{
            echo '<span>';
		}
        echo  $subcat_trans->name;
        if($category!=$subcat)
            echo '</a>';
        else{
            echo '</span>';
		}
        echo '</li>';
	}
	
?>
	<title><?php echo e($cat_trans->meta_title); ?></title>
	<meta name="keywords" content="<?php echo e($cat_trans->meta_keyword); ?> " />
	<meta name="description" content="<?php echo e($cat_trans->meta_description); ?> ">
	<?php if($type=="category"): ?>
		<?php if($category->noindex && $category->nofollow): ?>
			<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		<?php elseif($category->noindex): ?>
			<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
		<?php elseif($category->nofollow): ?>
			<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
		<?php endif; ?>
		
		<?php if($category->canonical): ?>
			<link rel="canonical" href="<?php echo e($_SERVER['REQUEST_URI']); ?>" />
		<?php endif; ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/style_courses.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/style_courses_filteration.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php $__env->startSection('content'); ?>
<!-- Start Training Purchasing -->
<div class="training_purchasing">
	<div class="container training_container">
		<div class="media">
			<div class="media-body align-self-center">
				<nav aria-label="breadcrumb" style="direction: <?php echo e($dir); ?>;">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a title="Go to Home Page" href="<?php echo e(url(App('urlLang'))); ?>"><?php echo e(trans('home.home')); ?></a>
						</li>
						<?php if($type=="category"): ?>
							<?php echo recurseFromFirstParent($category,$category); ?>

						<?php else: ?>
							<li class="breadcrumb-item">
							<span>
									<?php echo e($cat_trans->name); ?>

							</span>
							</li>
						<?php endif; ?>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- End Training Purchasing -->

<!-- Start Course Filter -->
<div class="course_filter" style="direction:<?php echo e($dir); ?>">
	<div class="container filter_container">
		<div class="row justify-content-between">
			<div class="col-lg-3  filteration_method" style="text-align: justify;">
				<?php echo $__env->make("front.categories._sidebar",array("cat_trans"=>$cat_trans), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
			<div class="col-lg-9  filteration">
				<div class="filteration_head">
					<div class="row justify-content-between">
						<div class="col-12 srchrslt" style="text-align: justify;">
							<div id="search_total" style="margin-bottom:10px;">&nbsp; <?php echo e($countCourses); ?> &nbsp;<?php echo e(trans('home.results_found_for')); ?>&nbsp;
								<?php if($type=="all-courses"): ?>
									<strong> <?php echo e(trans('home.all_courses')); ?></strong>
								<?php else: ?>
									<strong><?php echo e($cat_trans->name); ?></strong>
								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>
				<div class="filteration_content">
					<div class="row justify-content-between content_head">
						<div class="col-6 search_sort">
							<span> <?php echo e(trans('home.filtre_selon')); ?> </span>
							<select class="custom-select search_select" id="sort_link">
								<option value="newest"><?php echo e(trans('home.newest')); ?></option>
								<option value="toprated"><?php echo e(trans('home.top_rated')); ?></option>

							</select>
						</div>
						
						<div class="company_courses col-12 resltrslt">

							<input type="hidden" id="cat_id" value="<?php echo e(isset($category->id) ? $category->id : 0); ?>"/>
							<input type="hidden" id="type" value="<?php echo e($type); ?>"/>

							<input type="hidden" id="start_at" value="<?php echo e($start_at); ?>"/>
							<input type="hidden" id="step" value="<?php echo e($step); ?>"/>
							<input type="hidden" id="countpro" value="<?php echo e($countCourses); ?>"/>
							<input type="hidden" id="sort_order" value=""/>
							<div id="coruses-container" class="row justify-content-around content_info">
								<?php echo $__env->make('front.courses._courses2',array("courseTypes"=>$courseTypes), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							</div>
							<div class="pagination-area ">
								<div class="load-more">
									<div class="col-sm-8 col-sm-push-2 col-xs-12 text-center load-more-holder <?php echo e($countCourses<=$start_at?'display-none':''); ?>">
										<a><button id="new-products_grid" class="button btn-cool" data-loading-text="<?php echo e(trans('home.loading')); ?>"><?php echo e(trans('home.load_more')); ?></button></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <?php echo $__env->make('front.categories.js.view_js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>