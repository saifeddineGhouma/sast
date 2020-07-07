<div class="col-lg-12 course_teacher courses_more_info_content">
    <div class="content_header_one">
        <p style="text-align: <?php echo e($textalign); ?>"><?php echo app('translator')->getFromJson('navbar.Coachs'); ?></p>
    </div>
    <div class="company_courses ">
        <div class="row" style="direction: <?php echo e($dir); ?>">
            <?php $__currentLoopData = $courseType->couseType_variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseTypeVariation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $teacher_trans = $courseTypeVariation->teacher->teacher_trans(session()->get('locale'));
                    if(empty($teacher_trans))
                        $teacher_trans = $courseTypeVariation->teacher->teacher_trans('ar');
                ?>
                <div class="col-lg-4 col-md-4 zoom">
                    <div class="card card_style_one">
                        <img class="card-img-top" src="<?php echo e(asset('uploads/kcfinder/upload/image/users/'.$courseTypeVariation->teacher->user->image)); ?>" alt="Card image cap">
                        <div class="card-body ">
                            <h5 class="card-title">
                                <a href="#" onclick="return false;"><?php echo e($courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')}); ?></a>
                            </h5>
                            <p class="card-text"><?php echo e($teacher_trans->job); ?></p>

                            <?php $__currentLoopData = $courseTypeVariation->teacher->socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e($social->link); ?>" target="_blank"><i class="<?php echo e($social->font); ?>" aria-hidden="true"></i></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="more_info">
                                <p><?php echo e($teacher_trans->about); ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div> 