<div class="col-lg-12 course_discussion courses_more_info_content">
    <div class="content_header_one">
        <p style="text-align: <?php echo e($textalign); ?>"><?php echo app('translator')->getFromJson('navbar.disscussion'); ?></p>
        
    </div>
    <div id="accordion" style="text-align: <?php echo e($textalign); ?>">
        <?php $__currentLoopData = $courseQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card discussion_card card_deactive">
                <div class="card-header row" id="heading_<?php echo e($courseQuestion->id); ?>" style="background: #d9e8da !important;">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsereply_<?php echo e($courseQuestion->id); ?>" aria-expanded="true" aria-controls="collapse_<?php echo e($courseQuestion->id); ?>">
                        <div class="col-2 header_img">
                            <h5 class="mb-0">
                                <div class="link_img">
                                    <?php if(!empty($courseQuestion->user)): ?>
                                        <img src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$courseQuestion->user->image)); ?>" >
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('assets/front/img/user1.jpg')); ?>" >
                                    <?php endif; ?>
                                </div>
                            </h5>
                        </div>
                        <div class="col-9 header_content">
                            <?php if(!empty($courseQuestion->user)): ?>
                                <span class="header_content_name"><?php echo e($courseQuestion->user->username); ?></span>
                            <?php else: ?>
                                <span class="header_content_name">أدمين</span>
                            <?php endif; ?>
                            <span class="header_content_date"><?php echo e(date("Y-m-d",strtotime($courseQuestion->created_at))); ?></span>
                            <p><?php echo $courseQuestion->discussion; ?></p>
                        </div>
                        <div class="col-1 header_col">
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                            <i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
                <div id="collapsereply_<?php echo e($courseQuestion->id); ?>" class="collapse" aria-labelledby="heading_<?php echo e($courseQuestion->id); ?>" data-parent="#accordion">
                    <?php $__currentLoopData = $courseQuestion->replies()->where('active',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!$loop->first): ?>
                            <div class="line_spetare"></div>
                        <?php endif; ?>
						<?php if(!empty($reply->user) and !empty($reply->type)): ?>
							<div class="card-body" style="background: #fff0b5 !important;">
						<?php elseif(!empty($reply->user) and empty($reply->type)): ?>
							<div class="card-body" style="background: #d9e8da !important;">
						<?php else: ?>
							<?php
								if(!empty($reply->admin_id)){
									$admin_idd = $reply->admin_id;
									$role = DB::table('role_admin')
											->join('roles', 'role_admin.role_id', '=', 'roles.id')
											->where('admin_id', $admin_idd)->first();
							?>
								<div class="card-body" style="background: #f9e0df !important;">
							<?php }else{ ?>
								<div class="card-body" style="background: #c8e1f5 !important;">
							<?php } ?>
						<?php endif; ?>
                            <div class="col-2 body_img">
                                <h5 class="mb-0">
                                    <div class="link_img">
                                        <?php if(!empty($reply->user)): ?>
                                            <img src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$reply->user->image)); ?>" style="top: -27px;left: 90%;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/front/img/discussion_link_img_2.png')); ?>" style="top: -27px;left: 90%;">
                                        <?php endif; ?>
                                    </div>
                                </h5>
                            </div>
                            <div class="col-10 body_content">
                                <span class="body_content_name">
                                    <?php if(!empty($reply->user)): ?>
                                        <?php echo e($reply->user->username); ?>

                                    <?php else: ?>
										<?php
											if(!empty($reply->admin_id)){
												$admin_idd = $reply->admin_id;
												$role = DB::table('role_admin')
														->join('roles', 'role_admin.role_id', '=', 'roles.id')
														->where('admin_id', $admin_idd)->first();
												if($role->name=="Super admin"){
													echo __('navbar.directeur');
												}else{
													echo __('navbar.admin');
												}
											}else{
												echo __('navbar.admin');
											}
										?>
                                    <?php endif; ?>
                                </span>
                                <p><?php echo $reply->discussion; ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="card-body row">
                        <div class="col-10 body_content">
                            <?php if(Auth::check()): ?>
                                <form method="post" class="reply-form" action='<?php echo e(url(App("urlLang")."courses/save-reply/".$courseQuestion->id)); ?>'>
                                    <div class="reply-message"></div>
                                    <?php echo csrf_field(); ?>

                                    <div class="form-group">
                                        <textarea class="add_comment" name="discussion" placeholder="<?php echo app('translator')->getFromJson('navbar.addcomment'); ?>"></textarea>
                                    </div>

                                    <button type="submit" class="insert_comment">اضف</button>
                                </form>
                            <?php else: ?>
                                <a href="<?php echo e(url(App('urlLang').'login')); ?>" class="btn"><?php echo app('translator')->getFromJson('navbar.loginToComment'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="card-body row">
                <div class="col-10 body_content">
                    <?php if(Auth::check()): ?>
                        <form method="post" class="reply-form" action='<?php echo e(url(App("urlLang")."courses/save-reply/".$course->id)); ?>'>
                            <div class="reply-message"></div>
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="quistionType" value="course"/>
                            <div class="form-group">
                            <textarea class="add_comment" name="discussion" placeholder="<?php echo app('translator')->getFromJson('navbar.addcomment'); ?>"></textarea>
                            </div>

                            <button type="submit" class="insert_comment"><?php echo app('translator')->getFromJson('navbar.add'); ?></button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(url(App('urlLang').'login')); ?>" class="btn"><?php echo app('translator')->getFromJson('navbar.loginToComment'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
    </div>
</div>