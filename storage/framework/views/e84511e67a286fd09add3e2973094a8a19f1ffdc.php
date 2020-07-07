<?php
$course = $courseType->course;
$course_trans = $course->course_trans(Session::get('locale'));
if(empty($course_trans))
    $course_trans = $course->course_trans('en');

$countRatings = 0;
$sumRatings = 0;
if(!is_null($course->ratings()->where("approved",1))){
    $countRatings = $course->ratings()->where("approved",1)->count();
    $sumRatings = $course->ratings()->where("approved",1)
        ->select(DB::raw('sum(value) as sumRating'))->groupBy("course_id")->first();
    if(!empty($sumRatings))
        $sumRatings = $sumRatings->sumRating;
    else
        $sumRatings = 0;
}

$variationCount = $courseType->couseType_variations()->count();
$first_Variation = $courseType->couseType_variations()->orderBy("price","asc")->first();
$user=null;
if(!empty($first_Variation)){
    $user = $first_Variation->teacher->user;
}
$card = "one";
switch ($loop->index%8){
    case 1;
        $card = "two";
        break;
    case 2;
        $card = "three";
        break;
    case 3;
        $card = "four";
        break;
    case 4;
        $card = "five";
        break;
    case 5;
        $card = "six";
        break;
    case 6;
        $card = "seven";
        break;
    case 7;
        $card = "eight";
        break;
}
?>

<?php if(!empty($first_Variation)): ?>
  
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 col-margin zoom">
        
        <div class="card  card_style_<?php echo e($card); ?>">
            <a href="<?php echo e(url(App('urlLang').'courses/'.$courseType->id)); ?>"><img class="card-img-top" src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$course->image)); ?>" alt="<?php echo e($course_trans->name); ?>"></a>
             <?php if($variationCount>1): ?>
                            <sup>تبدأ من</sup>
                        <?php endif; ?>
                        <?php
                            $setting = App('setting');
                            $vat = $setting->vat*$first_Variation->price/100;
                            $vat2 = $setting->vat*$first_Variation->pricesale/100;
                           
                        ?>

                        <?php if(!empty($first_Variation->pricesale)): ?>
                        <div class="ribbon"><span>sale</span></div>
                        <span class="badge badge-pill badge-warning-sale">
                               
                                
                                  <p style="text-decoration: line-through;color:yellow"><?php echo e(floor($first_Variation->pricesale+$vat2)); ?> <b>$</b></p>
                                  <?php echo e(floor($first_Variation->price+$vat)); ?> <b>$</b>
                                
                        </span>
                        <?php else: ?>
                        <span class="badge badge-pill badge-warning">
                            <span>
                            <?php echo e(floor($first_Variation->price+$vat)); ?> <b>$</b>
                            </span>
                        </span>
                        <?php endif; ?>
                  
            <span class="badge badge-pill badge-warning2"><?php echo e(trans('home.'.$courseType->type)); ?></span>
            <div class="card-body ">
                 <a href="<?php echo e(url(App('urlLang').'courses/'.$courseType->id)); ?>">
                <section class="rate rtgcrc">
                    <?php echo $course->rating(($countRatings!=0)?$sumRatings/$countRatings:0); ?>


                </section>

                <?php if(!empty($user)): ?>
                    <div class="circle_profile">
                        <img src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$user->image)); ?>" />
                    </div>

                    <h5 class="card-title">
                        <?php if(false && $variationCount>1): ?>
                        <?php echo e(trans('home.plus_que_coach')); ?> 
                        <?php else: ?>
                            <?php echo e(trans('home.coach')); ?> /
                            <?php if(Session::get('locale') == "ar"): ?>
                                <?php echo e($user->full_name_ar); ?>

                            <?php else: ?>
                                <?php echo e($user->full_name_en); ?>

                            <?php endif; ?>
                        <?php endif; ?> 
                      </h5>
                <?php endif; ?>
                <p class="card-text"><a href="<?php echo e(url(App('urlLang').'courses/'.$courseType->id)); ?>"><?php echo e($course_trans->name); ?></a></p>

                <div class="more_info">
                    <?php if($courseType->type=="presence"): ?>
                        <?php if($variationCount<=1): ?>
                            <div class="row">
                                <div class="col">
                                    <i class="fa fa-calendar-alt"></i>
                                    <p><?php echo e($first_Variation->date_from); ?></p>
                                </div>
                                <div class="col">
                                    <i class="fa fa-map-marker-alt"></i>
                                    <?php if(!empty($first_Variation->government)): ?>
                                        <p><?php echo e(isset($first_Variation->government->government_trans(Session::get('locale'))->name) ? $first_Variation->government->government_trans(Session::get('locale'))->name : $first_Variation->government->government_trans("en")->name); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php $__currentLoopData = $courseType->couseType_variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $couseType_variation1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <div class="col">
                                        <i class="fa fa-calendar-alt"></i>
                                        <p><?php echo e($couseType_variation1->date_from); ?></p>
                                    </div>
                                    <div class="col">
                                        <i class="fa fa-map-marker-alt"></i>
                                        <?php if(!empty($couseType_variation1->government)): ?>
                                            <p><?php echo e(isset($couseType_variation1->government->government_trans(Session::get('locale'))->name) ? $couseType_variation1->government->government_trans(Session::get('locale'))->name : $couseType_variation1->government->government_trans("en")->name); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col train_prograrm">
                            <img src="<?php echo e(asset('assets/front/img/verified_list.svg')); ?>" />
                            <a href="<?php echo e(url(App('urlLang').'courses/'.$courseType->id)); ?>">الدورة</a>
                            <i class="fa fa-caret-left"></i>
                        </div>
                    </div>

                </div>
            </a>
            </div>
        </div>
        </a>
    </div>


<?php endif; ?>