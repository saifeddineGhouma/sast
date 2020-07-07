<form id="pay_form" action="<?php echo e(url(App('urlLang').'checkout/checkout')); ?>" method="post">
    <?php
    $totalPrice = 0;
    ?>
        
    <table id="cart" class="table cart-tble table-condensed">
        <thead>
        <tr>
            <th style="width:32%" style="text-align: center"><?php echo app('translator')->getFromJson('navbar.product'); ?></th>
            <th style="width:10" style="text-align: center"><?php echo app('translator')->getFromJson('navbar.price'); ?></th>
            <th style="width:8%" style="text-align: center"><?php echo app('translator')->getFromJson('navbar.qte'); ?></th>
            <th style="width:10%" class="text-center" style="text-align: center"><?php echo app('translator')->getFromJson('navbar.total'); ?></th>
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
                $quiz_trans = $quiz->quiz_trans(App('lang'));
                if(empty($quiz_trans))
                    $quiz_trans = $quiz->quiz_trans("ar");
                $product_id = $cart_pro['quiz_id'];
            }elseif(isset($cart_pro['pack_id'])){
                $type = "packs";
                $packs = \App\Packs::findOrFail($cart_pro['pack_id']);
                $product_id = $cart_pro['pack_id'];
            }else{
                $book = \App\Book::findOrFail($cart_pro['book_id']);
                $book_trans = $book->book_trans(App('lang'));
                if(empty($book_trans))
                    $book_trans = $book->book_trans("ar");
                $product_id = $cart_pro['book_id'];
            }
            ?>
            <tr>
                
                <td data-th="<?php echo app('translator')->getFromJson('navbar.product'); ?>" rowspan="2" class="text-center">
                    <div class="row">
                        <?php if($type=="course"): ?>
                            <div class="col-sm-2 hidden-xs">
                                <img src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$course->image)); ?>" alt="<?php echo e($course_trans->name); ?>" class="cart-img"/>
                            </div>
                            <div class="col-sm-10">
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
                <td data-th="<?php echo app('translator')->getFromJson('navbar.price'); ?>" class="text-center" >
                    <?php echo e($cart_pro["price"]); ?>$
                </td>
                <td data-th="<?php echo app('translator')->getFromJson('navbar.qte'); ?>" class="text-center" >
                    <?php echo e($cart_pro['quantity']); ?>

                </td>
                <td class="text-center">
                    <?php
                        $totalPrice+=$cart_pro["total"];
                    ?>
                    <?php echo e($cart_pro["total"]); ?>$
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center"><?php echo app('translator')->getFromJson('navbar.name'); ?> </th>
                                <th style="text-align: center"><?php echo app('translator')->getFromJson('navbar.troisiemenom'); ?></th>
                                <th style="text-align: center"><?php echo app('translator')->getFromJson('navbar.mail'); ?></th>
                                <th style="text-align: center"><?php echo app('translator')->getFromJson('navbar.phonenumber'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">1</td>
                                <td style="text-align: center"><?php echo e($user->username); ?></td>
                                <td style="text-align: center"><?php echo e($user->full_name_ar); ?></td>
                                <td style="text-align: center"><?php echo e($user->email); ?></td>
                                <td style="text-align: center"><?php echo e($user->mobile); ?></td>
                            </tr>
                            <?php for($i=2;$i<=$cart_pro['quantity'];$i++): ?>
                                <tr >
                                    <td><?php echo e($i); ?></td>
                                    <td>
                                        <div class="form-group">
                                            <input  type="text" name="std_usernames_<?php echo e($product_id); ?>_<?php echo e($i); ?>" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input  type="text" name="std_fullNames_<?php echo e($product_id); ?>_<?php echo e($i); ?>" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input  type="text" name="std_emails_<?php echo e($product_id); ?>_<?php echo e($i); ?>" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input  type="text" name="std_mobiles_<?php echo e($product_id); ?>_<?php echo e($i); ?>" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr >
            <td></td>
            <td colspan="3">
                <?php if(isset($checkout["points_value"])): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo e(trans('home.reward_points_exchanged')); ?>:
                        </div>
                        <div class="col-md-6 " style="text-align: center">
                            <?php echo e($checkout["points_value"]); ?>$-
                            <?php ($totalPrice = $totalPrice - $checkout["points_value"]); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(isset($checkout["coupon_value"])): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo e(trans('home.coupon')); ?>:
                            <?php
                                $coupon = App\Coupon::find($checkout["coupon_id"]);
                                $coupon_number = "";
                                if(!empty($coupon))
                                    $coupon_number = $coupon->coupon_number;
                                
                            ?>
                            <?php echo e($coupon_number); ?>

                        </div>
                        <div class="col-md-6" style="text-align: center" >
                            <?php echo e($checkout["coupon_value"]); ?>%-
                            
                            <?php ($coup = ($totalPrice/100)*$checkout["coupon_value"]); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td colspan="3">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo e(trans('home.total_sans_vat')); ?>:
                    </div>
                    <div class="col-md-6" style="text-align: center" >
                         <?php 
                            if(isset($coup)){
                                $totalPrice = $totalPrice - $coup;
                            }
                        ?>
                         $<?php echo $totalPrice; ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">
    
                <div class="row">
                    <div class="col-md-6">
                        <?php echo e(trans('home.vat')); ?>:
                    </div>
                    <div class="col-md-6" style="text-align: center" >
                         <?php 
                            $setting = App('setting');
                            $vat = $setting->vat*($cart_pro["price"]/100);
                            echo $setting->vat." %";
                        ?>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo e(trans('home.total_vat')); ?>:
                    </div>
                    <div class="col-md-6" style="text-align: center" >
                        $<?php echo e($checkout['vat']); ?>

                        
                    </div>
                </div>
            </td>
        </tr>
        
        <tr>
            <td>
            </td>
            <td colspan="3">
                 <div class="row">
                    <div class="col-md-6">
                        <?php echo e(trans('home.total_price')); ?>:
                    </div>
                    <div class="col-md-6" style="text-align: center">
                        $<?php echo e($checkout["totalPrice"]); ?>

                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>



<div class="clear"></div>

<div class="col-sm-12 btnsnex">
    <div id="error_message"></div>
    <?php echo csrf_field(); ?>

    <?php if($checkout['payment_method']=="stripe"): ?>
        <input type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" value="<?php echo app('translator')->getFromJson('navbar.paynow'); ?>" />

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pay with my card</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_live_7G2dGhC0acfWlKTRGUZOXOMK"
                                data-amount="<?php echo e(round($checkout["totalPrice"]*100,0)); ?>"
                                data-name="<?php echo e(App("setting")->settings_trans(App('lang'))->site_name); ?>"
                                data-description="Widget"
                                data-currency="USD"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto">
                        </script>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



    <?php else: ?>
        <input type="submit" class="btn btn-success" value="<?php echo app('translator')->getFromJson('navbar.paynow'); ?>" />
    <?php endif; ?>

    <input onclick="js:location.href='<?php echo e($checkout['totalPrice']==0?url(App('urlLang').'checkout'):url(App('urlLang').'checkout/payment')); ?>'" class="btn btn-warning" value="<?php echo app('translator')->getFromJson('navbar.previous'); ?>">
</div>
</form>