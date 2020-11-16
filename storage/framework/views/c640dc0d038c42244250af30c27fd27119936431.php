<style>
p{text-algin:center;}
</style>
    <div class=" course_curriculum courses_more_info_content">
        <div class="content_header_one">
            <p><?php echo app('translator')->getFromJson('navbar.courseWay'); ?></p>
        </div>
        <?php if(in_array($courseType->id, [292, 298, 328])): ?> 
          <?php if($user): ?>
            <?php if(!$user->user_lang()->exists()): ?>
                <div> اختر لغة الدراسة </div>
                <form method="POST">
                <div>
                    <a href="<?php echo e(url('/addStudLang/fr/' . $user->id)); ?>" onclick="return confirm('هل انت متأكد من لغة الدراسة ؟  لا يمكنك تغيير اللغة الا عن طريق الاتصال بنا ')"> فرنسية </a> 
                    
                    
                </div>

                    
                <div><a href="<?php echo e(url('/addStudLang/ar/'. $user->id)); ?>" onclick="return confirm('هل انت متأكد من لغة الدراسة ؟  لا يمكنك تغيير اللغة الا عن طريق الاتصال بنا ')">   عربية </a></div>  
                </form>
            <?php else: ?> 
            <div id="accordion">
                <?php $__currentLoopData = $course->courseStudies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseStudy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card curriculum_card card_deactive">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_<?php echo e($courseStudy->id); ?>" aria-expanded="true" aria-controls="collapse_<?php echo e($courseStudy->id); ?>">
                                    <span><?php echo e($courseStudy->duration); ?> <sup><?php echo app('translator')->getFromJson('navbar.hours'); ?></sup></span> | <b><?php echo e($loop->iteration); ?>.</b><?php echo e($courseStudy->{'name_'.App('lang')}); ?> <?php echo e($courseStudy->type); ?>

                                </button>
                            </h5>
                            <span class="showhide">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div id="collapse_<?php echo e($courseStudy->id); ?>" class="collapse" aria-labelledby="heading_<?php echo e($courseStudy->id); ?>" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-1 curriculum_type">
                                        <?php if( $courseStudy->type == "pdf"): ?>
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        <?php if( $courseStudy->type == "video"): ?>
                                            <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                        <?php endif; ?>
                                        <?php if( $courseStudy->type == "html"): ?>
                                            <i class="fa fa-text-height" aria-hidden="true"></i> 
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-8 curriculum_title">
                                        <p><?php echo e($courseStudy->{'name_'.App('lang')}); ?> </p>
                                    </div>
                                    <div class="col-3 curriculum_watch">
                                        <?php if($courseStudy->only_registered && Auth::guest()): ?>
                                            <button onclick="location.href='<?php echo e(url(App('urlLang').'login')); ?>'">للمسجلين فقط</button>
                                        <?php else: ?>
                                            <?php if($course->isRegistered()): ?>
                                                <?php if($courseStudy->type == "html"||$courseStudy->type == "pdf"): ?>
													<?php if($courseStudy->type == "html"): ?>
															<button onclick="location.href='<?php echo e(url(App('urlLang').'courses/studies?courseStudy_id='.$courseStudy->id)); ?>'" target="_blank">مشاهدة</button>
													<?php elseif($courseStudy->type == "pdf"): ?>
														<?php if($user->user_lang['lang_stud'] == "ar" ): ?>
															<button onclick="location.href='<?php echo e(url(App('urlLang').'/uploads/kcfinder/upload/file/'. $courseStudy->url )); ?>'" target="_blank">مشاهدة</button>
														<?php else: ?>
															<button onclick="location.href='<?php echo e(url(App('urlLang').'/uploads/kcfinder/upload/file/new book/FITNESS INSTRUCTOR FR.pdf')); ?>'" target="_blank">مشاهدة</button>
														<?php endif; ?> 
													<?php endif; ?>
                                                    <a href="https://swedish-academy.se/telecharge.php?pdf=<?php echo e($courseStudy->url); ?>" download="<?php echo e($courseStudy->url); ?>" target="_blank" style="float: left;">
                                                        <img src="<?php echo e(asset('assets/front/img/icon-download.png')); ?>" /> 
                                                        تحميل
                                                    </a>
                                                <?php else: ?>
                                                    <button href="<?php echo e(url(App('urlLang').'uploads/kcfinder/upload/file/'.$courseStudy->url)); ?>" target="_blank">مشاهدة</button>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <button onclick="location.href='<?php echo e(url(App('urlLang').'login')); ?>'">للمسجلين فقط</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  

            </div> 
        
            <?php endif; ?> 
          <?php endif; ?>
        <?php else: ?>
            <?php if(in_array($courseType->id, [299, 300, 301, 302])): ?>
             <p>   انقر على هذه الصورة اذا اردت شراء احد كتبتنا  </p> <br>
             <a href="<?php echo e(url(App('urlLang').'books')); ?>"> <?php echo app('translator')->getFromJson('navbar.libraire'); ?>  </a>

            <?php else: ?> 
                <div id="accordion">
                    <?php $__currentLoopData = $course->courseStudies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseStudy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card curriculum_card card_deactive">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_<?php echo e($courseStudy->id); ?>" aria-expanded="true" aria-controls="collapse_<?php echo e($courseStudy->id); ?>">
                                        <span><?php echo e($courseStudy->duration); ?> <sup><?php echo app('translator')->getFromJson('navbar.hours'); ?></sup></span> | <b><?php echo e($loop->iteration); ?>.</b><?php echo e($courseStudy->{'name_'.app()->getLocale()}); ?> <?php echo e($courseStudy->type); ?>

                                    </button>
                                </h5>
                                <span class="showhide">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div id="collapse_<?php echo e($courseStudy->id); ?>" class="collapse" aria-labelledby="heading_<?php echo e($courseStudy->id); ?>" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-1 curriculum_type">
                                            <?php if( $courseStudy->type == "pdf"): ?>
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            <?php endif; ?>
                                            <?php if( $courseStudy->type == "video"): ?>
                                                <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                            <?php endif; ?>
                                            <?php if( $courseStudy->type == "html"): ?>
                                                <i class="fa fa-text-height" aria-hidden="true"></i> 
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-8 curriculum_title">
                                            <p><?php echo e($courseStudy->{'name_'.app()->getLocale()}); ?> </p>
                                        </div>
                                        <div class="col-3 curriculum_watch">
                                            <?php if($courseStudy->only_registered && Auth::guest()): ?>
                                                <button onclick="location.href='<?php echo e(url(App('urlLang').'login')); ?>'"><?php echo app('translator')->getFromJson('navbar.pleaseLogIn'); ?></button>
                                            <?php else: ?>
                                                <?php if($course->isRegistered()): ?>
                                                    <?php if($courseStudy->type == "html"||$courseStudy->type == "pdf"): ?>
                                                        <?php if($courseStudy->type == "html"): ?>
                                                            <button onclick="location.href='<?php echo e(url(App('urlLang').'courses/studies?courseStudy_id='.$courseStudy->id)); ?>'" target="_blank"><?php echo app('translator')->getFromJson('navbar.view'); ?></button>
                                                    <?php elseif($courseStudy->type == "pdf"): ?>
                                                        
                                                                <button onclick="location.href='<?php echo e(url(App('urlLang').'/uploads/kcfinder/upload/file/'. $courseStudy->url )); ?>'" target="_blank"><?php echo app('translator')->getFromJson('navbar.view'); ?></button>
                                                            
                                                            <?php endif; ?>
                                                        <a href="https://swedish-academy.se/telecharge.php?pdf=<?php echo e($courseStudy->url); ?>" download="<?php echo e($courseStudy->url); ?>" target="_blank" style="float: left;">
                                                            <img src="<?php echo e(asset('assets/front/img/icon-download.png')); ?>" /> 
																<?php echo app('translator')->getFromJson('navbar.upload_file'); ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <button onclick="location.href='<?php echo e(url(App('urlLang').'uploads/kcfinder/upload/file/'.$courseStudy->url)); ?>'" target="_blank"><?php echo app('translator')->getFromJson('navbar.view'); ?></button>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <button onclick="location.href='<?php echo e(url(App('urlLang').'login')); ?>'"><?php echo app('translator')->getFromJson('navbar.pleaseLogIn'); ?></button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>