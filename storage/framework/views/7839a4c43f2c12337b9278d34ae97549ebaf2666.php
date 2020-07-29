<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>

<div class="filteration_method_head"  style="direction:<?php echo e($dir); ?>">
	<p><?php echo e(trans('home.filtre_courses_sidbar')); ?></p> 
</div>
<div class="filteration_method_content">
	<div class="row justify-content-between price_rate_filter">
		<div class="col-12">
			<?php if($type=="all-courses"): ?>
				<p><?php echo e(trans('home.all_courses_filtre_sidbar')); ?></p>
			<?php else: ?>
				<p><?php echo e($cat_trans->name); ?></p>
			<?php endif; ?>
                <?php 
                if($type=="all-courses"){
                    $subcats = \App\Category::get();
                }else{
                    $subcats = $category->subcat;
                }


                function recurseCat($subcat){
                    $subcat_trans = $subcat->category_trans(session()->get('locale'));
                    if(empty($subcat_trans))
                        $subcat_trans = $subcat->category_trans("en");

                    $name = $subcat_trans->name;

                    echo '<div class="form-check">
								<input class="form-check-input cat_check" type="checkbox" data-id="'.$subcat->id.'">
								<label class="form-check-label">'.$subcat_trans->name.'</label>
							</div>';
                }
                ?>
				<?php if(!is_null($subcats)&&$subcats->count()>0): ?>
					<?php if($type=="category"): ?>
						<div class="form-check">
							<input class="form-check-input cat_check" type="checkbox" data-id="<?php echo e($category->id); ?>">
							<label class="form-check-label"><?php echo e($cat_trans->name); ?></label>
						</div>
					<?php endif; ?>
					<?php $__currentLoopData = $subcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php echo recurseCat($subcat); ?>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<?php endif; ?>
		</div>
	</div>
	<div class="row justify-content-between price_rate_filter">
		<div class="col-12">
			<p><?php echo e(trans('home.type_cours')); ?></p>
			<div class="form-check">
				<input class="form-check-input type_check" type="checkbox" value="online">
				<label class="form-check-label"><?php echo e(trans('home.online')); ?> </label>
			</div>
			<div class="form-check">
				<input class="form-check-input type_check" type="checkbox" value="presence">
				<label class="form-check-label"> <?php echo e(trans('home.classroom')); ?> </label>
			</div>
		</div>
	</div>
	<div class="row justify-content-between price_rate_filter">
		<div class="col-12">
			<p> <?php echo e(trans('home.price')); ?></p>
		</div>
		<div class="col-5">
			<span class="slider_text_range"> <?php echo e(trans('home.to')); ?></span>
			<input type="text" id="amount_two" value="<?php echo e($maxPrice); ?>" style="text-align: justify">
		</div>
		<div class="col-5" >
			<span class="slider_text_range"><?php echo e(trans('home.from')); ?></span>
			<input type="text" id="amount_one" value="<?php echo e($minPrice); ?>"  style="text-align: justify">
		</div>
		<div class="col-12">
			<div id="slider-range_one"></div>
		</div>
	</div>
</div>