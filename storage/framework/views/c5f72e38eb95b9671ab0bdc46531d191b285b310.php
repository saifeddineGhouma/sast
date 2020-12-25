<?php
$totalPrice = 0;
//print_r($cart);
?>
<table id="cart" class="table cart-tble table-condensed" style="direction: <?php echo e($dir); ?> " >
    <thead>
    <tr>
        <th style="width:50%" class="text-center" ><?php echo app('translator')->getFromJson('navbar.product'); ?></th>
        <th style="width:10%" class="text-center"><?php echo app('translator')->getFromJson('navbar.price'); ?></th>
        <th style="width:8%"  class="text-center"><?php echo app('translator')->getFromJson('navbar.qte'); ?></th>
        <th style="width:22%" class="text-center"><?php echo app('translator')->getFromJson('navbar.total'); ?></th>
        <th style="width:10%"></th>
    </tr>
    </thead>
    <tbody>
	
    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$cart_pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $type = "book";
        $product_id = 0;
        if(isset($cart_pro['coursetypevariation_id'])){
            $type = "course";
            $courseTypeVariation = \App\CourseTypeVariation::findOrFail($cart_pro['coursetypevariation_id']);
            $courseType = $courseTypeVariation->courseType;
            $course = $courseType->course;
            $course_trans = $course->course_trans(session()->get('locale'));
            if(empty($course_trans))
                $course_trans = $course->course_trans("ar");
            $product_id = $cart_pro['coursetypevariation_id'];
        }elseif(isset($cart_pro['quiz_id'])){
            $type = "quiz";
            $quiz = \App\Quiz::findOrFail($cart_pro['quiz_id']);
            $quiz_trans = $quiz->quiz_trans(session()->get('locale'));
            if(empty($quiz_trans))
                $quiz_trans = $quiz->quiz_trans("ar");
            $product_id = $cart_pro['quiz_id'];
        }elseif(isset($cart_pro['pack_id'])){
            $type = "packs";
            $packs = \App\Packs::findOrFail($cart_pro['pack_id']);
            $product_id = $cart_pro['pack_id'];
        }else{
            $book = \App\Book::findOrFail($cart_pro['book_id']);
            $book_trans = $book->book_trans(session()->get('locale'));
            if(empty($book_trans))
                $book_trans = $book->book_trans("ar");
            $product_id = $cart_pro['book_id'];
        }
        ?>
        <tr>
            <td data-th="<?php echo app('translator')->getFromJson('navbar.product'); ?>">
				
				<?php if(isset($cart_pro['coursetypevariation_id'])): ?>
					<?php $__currentLoopData = $course->courseDiscounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseDiscount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($courseDiscount->num_students == $cart_pro["quantity"]): ?>
							<?php ($pourc = $courseDiscount->discount); ?>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>

                <div class="row">
                    <?php if($type=="course"): ?>
                        <div class="col-sm-3 hidden-xs">
                            <img src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$course->image)); ?>" alt="<?php echo e($course_trans->name); ?>" class="cart-img"/>
                        </div>
                        <div class="col-sm-9">
                            <a href="<?php echo e(url(App('urlLang').'courses/'.$courseType->id)); ?>"><h4><?php echo e($course_trans->name); ?> - <?php echo e(trans('home.'.$courseType->type)); ?></h4></a>
                            <p><?php echo e($course_trans->short_description); ?></p>
                        </div>
                    <?php elseif($type=="quiz"): ?>
                        <p><?php echo e($quiz_trans->name); ?></p>
                    <?php elseif($type=="packs"): ?>
                        <p><?php echo e($packs->titre); ?></p>
                    <?php else: ?>
                        <div class="col-sm-3 hidden-xs">
                            <img src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$book->image)); ?>" alt="<?php echo e($book_trans->name); ?>" class="cart-img"/>
                        </div>
                        <div class="col-sm-9">
                            <a href="<?php echo e(url(App('urlLang').'books/'.$book_trans->slug)); ?>"><h4><?php echo e($book_trans->name); ?></h4></a>
                            <p><?php echo e($book_trans->short_description); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </td>
            <td data-th="<?php echo app('translator')->getFromJson('navbar.price'); ?>">
                <?php 
                    $setting = App('setting');
                    $vat = $setting->vat*($cart_pro["price"]/100);
                ?>
                $<?php echo e(floor($cart_pro["price"]+$vat)); ?>

            </td>
            <td data-th="<?php echo app('translator')->getFromJson('navbar.qte'); ?>">
                <input type="number" class="form-control text-center input_qte"  
                 onChange="$('#btnUpdate_<?php echo e($product_id); ?>').click()"
                max="" min="1" id="quantity_<?php echo e($product_id); ?>" name="quantity_<?php echo e($product_id); ?>" value="<?php echo e($cart_pro['quantity']); ?>">
            </td>
            <td class="text-center">
                <?php
                    $cart_pro["total"] = floor($cart_pro["price"]+$vat)*$cart_pro['quantity'];
					if(isset($pourc)){
						$cart_pro["total"] = $cart_pro["total"] - (($cart_pro["total"]/100) * $pourc);
					}
					
                    $totalPrice+=$cart_pro["total"];
                ?>
                $<?php echo e($cart_pro["total"]); ?>

            </td>
            <td class="actions" data-th="">
                <button style="display:none" class="btn btn-info btn-sm btn_update" data-type="<?php echo e($type); ?>"
                        <?php if($type=="course"): ?>
                        data-coursetypevariation_id='<?php echo e($cart_pro["coursetypevariation_id"]); ?>'
                        <?php elseif($type=="quiz"): ?>
                            data-quiz_id='<?php echo e($cart_pro["quiz_id"]); ?>'
                        <?php elseif($type=="packs"): ?>
                            data-quiz_id='<?php echo e($cart_pro["pack_id"]); ?>'
                        <?php else: ?>
                        data-book_id='<?php echo e($cart_pro["book_id"]); ?>'
                        <?php endif; ?>
                        id="btnUpdate_<?php echo e($product_id); ?>"
                ><i class="fa fa-refresh"></i></button>
                <button class="btn btn-danger btn-sm product_delete" data-type="<?php echo e($type); ?>"
                        <?php if($type=="course"): ?>
                        data-coursetypevariation_id='<?php echo e($cart_pro["coursetypevariation_id"]); ?>'
                        <?php elseif($type=="quiz"): ?>
                            data-quiz_id='<?php echo e($cart_pro["quiz_id"]); ?>'
                        <?php elseif($type=="packs"): ?>
                            data-quiz_id='<?php echo e($cart_pro["pack_id"]); ?>'
                        <?php else: ?>
                        data-book_id='<?php echo e($cart_pro["book_id"]); ?>'
                        <?php endif; ?>
                ><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
    <?php 
        $next = session()->get('locale') === "ar" ? "left" : "right";
        $back = session()->get('locale') === "ar" ? "right" : "left";
    
    ?>

    <?php if(isset($fromPage)&&$fromPage=="cart"): ?>
        <tfoot>
        <tr>
        <td><a href="<?php echo e(url(App('urlLang').'all-courses')); ?>" class="btn btn-warning pull-<?php echo e($back); ?>"><i class="fa fa-angle-<?php echo e($back); ?>"></i> <?php echo app('translator')->getFromJson('navbar.previous'); ?></a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong> <?php echo app('translator')->getFromJson('navbar.totalprice'); ?> <span class="pricenovat"><?php echo e($totalPrice); ?> $</span></strong></td>

        <?php if(auth()->check()): ?>
        <td><a href="<?php echo e(url(App('urlLang').'checkout')); ?>" class="btn btn-success btn-block"><?php echo app('translator')->getFromJson('navbar.next'); ?> <i class="fa fa-angle-<?php echo e($next); ?>"></i></a></td>
        <?php else: ?>
          <td><a href="<?php echo e(url(App('urlLang').'checkout_anlogged')); ?>" class="btn btn-success btn-block"><?php echo app('translator')->getFromJson('navbar.next'); ?> <i class="fa fa-angle-<?php echo e($next); ?>"></i></a></td>

        <?php endif; ?>



        </tr>
        </tfoot>
    <?php endif; ?>
</table>