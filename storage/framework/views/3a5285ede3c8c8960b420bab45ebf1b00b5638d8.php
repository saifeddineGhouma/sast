<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php $align = session()->get('locale') === "ar" ? "right" : "left" ?>

<div class="training_purchasing">
    <div class="container training_container">
        <div class="media" style="direction: <?php echo e($dir); ?>; text-align: <?php echo e($align); ?>">
           
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <img class="align-self-center mr-3" src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$course->image)); ?>"
                     alt="<?php echo e($course_trans->name); ?>">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <div class="media-body align-self-center">

                    <?php echo e($course_trans->name); ?> - <?php echo e(trans('home.'.$courseType->type)); ?>

                    <?php
                        $now = date("Y-m-d");
                        if($courseType->type=="online")
                            $courseType_variations = $courseType->couseType_variations;
                        else
                            $courseType_variations = $courseType->couseType_variations()
                                ->where('coursetype_variations.date_to', '>=', $now)->get();
                    ?>
                    <?php $__currentLoopData = $courseType_variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseTypeVariation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="teachernm">  <?php echo app('translator')->getFromJson('navbar.coach'); ?>  : <span>  <?php echo e($courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')}); ?></span>

                        <?php if(!empty($courseTypeVariation->government)): ?>
                            <span><?php echo e(isset($courseTypeVariation->government->government_trans(session()->get('locale'))->name) ? $courseTypeVariation->government->government_trans(session()->get('locale'))->name : null); ?></span>
                            <span><?php echo e($courseTypeVariation->date_from ." - ".$courseTypeVariation->date_to); ?></span>
                        <?php endif; ?>
                            <!-- <span>ﺷﻬﺎﺩﺓ :</span>
                            <?php if(!empty($courseTypeVariation->certificate)): ?>
                                <span>ﻧﻌﻢ</span>
                            <?php else: ?>
                                <span>ﻻ</span>
                            <?php endif; ?> -->
                        </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(Auth::check()): ?>
                        <?php
                        $certificateCount = \App\StudentCertificate::where("student_id",Auth::user()->id)
                            ->where("course_id",$course->id)->count();
                        ?>

                        <?php if($certificateCount>0): ?>
                            <?php if(in_array($course->id, [496, 502])): ?>
                            <?php else: ?>
                                <div class="alert alert-success alertweb"><i class="fa fa-exclamation-circle"></i>
                                    <strong> <?php echo app('translator')->getFromJson('navbar.sucessCertification'); ?></strong>
                                    <br> <?php echo app('translator')->getFromJson('navbar.visitYourCertification'); ?> <a href="<?php echo e(url(App('urlLang').'account')); ?>"><?php echo app('translator')->getFromJson('navbar.account'); ?></a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if($course->categories()->exists()): ?>
                    <?php if($course->categories->first()->id ==  5): ?>
                      <?php if(!$user): ?>
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            
                            <?php if($course->id == 505): ?>
                                
                                <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                    
                                    <label>أرفق وثائق إثبات الخبرة </label> <br> <br>
                                    
                                    <input type="file" name="url_certif"  required> <br> <br>
                                    <button  onclick="location.href='<?php echo e(url(App('urlLang').'account')); ?>'">  تأكيد    </button>
                                </div>
                            
                            <?php else: ?> 
                                <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                    
                                    <strong> ﻟﻠﺘﺴﺠﻴﻞ ﻓﻲ ﻫﺬﻩ اﻟﺪﻭﺭﺓ ﻳﺠﺐ عليك ادخال الرقم التسلسلي لشهادتك :  222222</strong><br> <br> 
                                    <input name="serial_number" required><br> <br>
                                    <button  onclick="location.href='<?php echo e(url(App('urlLang').'account')); ?>'">  تأكيد    </button> 
                                </div>
                            <?php endif; ?>    
                        
                      <?php else: ?>
                        <?php if(!$user->user_verify()->exists()): ?>
                        <form method="post"  action='<?php echo e(url(App("urlLang")."addVerify",[$user->id, $course->id])); ?>' accept-charset="utf-8" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                
                                <?php if($course->id == 505): ?>
                                    
                                    <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                        
                                        <label>أرفق وثائق إثبات الخبرة </label> <br> <br>
                                        
                                        <input type="file" name="url_certif"  required> <br> <br>
                                        <button type="submit">  تأكيد    </button>
                                    </div>
                                
                                <?php else: ?> 
                                    <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                        
                                        <strong> ﻟﻠﺘﺴﺠﻴﻞ ﻓﻲ ﻫﺬﻩ اﻟﺪﻭﺭﺓ ﻳﺠﺐ عليك ادخال الرقم التسلسلي لشهادتك :  </strong><br> <br> 
                                        <input name="serial_number" required><br> <br>
                                        <button type="submit">  تأكيد    </button> 
                                    </div>
                                <?php endif; ?>   
                            </form>
                        <?php else: ?> 
                           <?php if($user->user_verify->course_id == 505): ?>
                                <?php if($user->user_verify->verify == 0): ?>
                                    

                                    <form method="post"  action='<?php echo e(url(App("urlLang")."addVerify",[$user->id, $course->id])); ?>' accept-charset="utf-8" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                            
                                           
                                            <label>لقد تم تحميل الوثيقة بنجاح سيتم إرسال التأكيد عبر الميل</label> <br> <br>
                                            
                                            <input type="file" name="url_certif"  required > <br> <br>
                                            <button type="submit">  تأكيد    </button>
                                        </div> 
                                    </form>  
                                <?php endif; ?>
                               
                            <?php else: ?>
                              <?php if($course->id ==  505): ?>
                              <form method="post"  action='<?php echo e(url(App("urlLang")."addVerify",[$user->id, $course->id])); ?>' accept-charset="utf-8" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                        <label>أرفق وثائق إثبات الخبرة  partie 3</label> <br> <br>
                                        <input type="file" name="url_certif" required> <br> <br>
                                        <button type="submit">  تأكيد    </button>
                                    </div>
                                </form>
                              <?php endif; ?> 
                            <?php endif; ?>

                        <?php endif; ?>
                      <?php endif; ?>  
                    <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php if((!is_null($course->parent_course)&&!($course->isRegisteredParent()&&$course->isSuccessParent()))&&!$course->isRegistered()): ?>
                        <?php
                        $parent_courseType = $course->parent_course->courseTypes()->first();
                        $parentCourse = $course->parent_course;
                        $parentCourse_trans = $parentCourse->course_trans(session()->get('locale'));
                        if(empty($parentCourse_trans))
                            $parentCourse_trans = $parentCourse->course_trans("en");
                        ?>
                        <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                            <strong> <?php echo app('translator')->getFromJson('navbar.toRegisterYouhaveTo'); ?> :  </strong>
                            <br> <a href="<?php echo e(url(App('urlLang').'courses/'.$parent_courseType->id)); ?>"><?php echo e($parentCourse_trans->name); ?></a>
                            <?php if($course->needsExperience == true): ?>
                            <br>
                            <?php echo app('translator')->getFromJson('navbar.or'); ?>
                            <br>
                            <a href="#" id="needsExperienceBTN" data-toggle="collapse" data-target="#change-search"> <?php echo app('translator')->getFromJson('navbar.confirmYourExperiance'); ?>   </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="meta-price media-body align-self-center">
                    <?php if($courseType->points >0): ?>
                        <span class="points-on-course"><span><i class="fa fa-gift"></i> <?php echo e($courseType->points); ?>  <?php echo app('translator')->getFromJson('navbar.poitGratuitParSession'); ?></span>
						   <i class="repls"><?php echo app('translator')->getFromJson('navbar.changePointToHaveDiscount'); ?></i>
						   <a href="<?php echo e(url(App('urlLang').'pages/points-program')); ?>" target="_blank"><?php echo app('translator')->getFromJson('navbar.discoverOurPointsystem'); ?></a>
						</span>
					<?php endif; ?>
                    <?php
                        $first_Variation = $courseType->couseType_variations()->orderBy("price","asc")->first();
                        $setting = App('setting');
                        $vat = $setting->vat*$first_Variation->price/100;
                        $vat2 = $setting->vat*$first_Variation->pricesale/100;
                           

                    ?>

                    
                    <?php if($course->active == 0): ?>
                     <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;"><?php echo e(floor($first_Variation->price+$vat)); ?>$</span></button>
                    <?php else: ?>
                    <?php if((is_null($course->parent_course)||($course->isRegisteredParent()&&$course->isSuccessParent()))&&!$course->isRegistered()): ?>

                        <?php if($courseType->id == 296): ?>  
                            <?php if($course->isPayCourse()): ?>  
                                <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  <?php echo e(floor(($first_Variation->price+$vat)/2)); ?>$ </span></button>
                            <?php else: ?>
                                <?php if($course->isPayCourseLevel2()): ?> 
                                <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  <?php echo e(floor(($first_Variation->price+$vat)/2)); ?>$ </span></button>
                                <?php else: ?>
                                    <?php if($course->isPayPackThree()): ?>  
                                    <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  <?php echo e(floor(($first_Variation->price+$vat)/2)); ?>$ </span></button>
                                    <?php else: ?>
                                    <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  <?php echo e(floor($first_Variation->price+$vat)); ?>$ </span></button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
							
                            <?php if( !empty($course->categories->first()) && $course->categories->first()->id ==  5): ?>
								/**********/
                              <?php if(!$user): ?>
                              <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;"><?php echo e(floor($first_Variation->price+$vat)); ?>$</span></button>
                              <?php else: ?>
                                <?php if($user->user_verify()->exists()): ?>
                                  <?php if($user->user_verify->course_id == 505): ?>

                                    <?php if($user->user_verify->verify == 1): ?>
                                      <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  <?php echo e(floor($first_Variation->price+$vat)); ?>$  </span></button>        
                                    <?php else: ?> 
                                      <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;"><?php echo e(floor($first_Variation->price+$vat)); ?>$ </span></button>
                                    <?php endif; ?>

                                  <?php else: ?>
                                        <?php if($course->id ==  505): ?>  
                                            <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;"><?php echo e(floor($first_Variation->price+$vat)); ?>$ </span></button>
                                        <?php endif; ?>

                                    
                                  <?php endif; ?>



                                <?php else: ?>
                                <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;"><?php echo e(floor($first_Variation->price+$vat)); ?>$</span></button>
                                <?php endif; ?>
                              <?php endif; ?>
                            <?php else: ?>
                            
                            
                            <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  <?php echo e(floor($first_Variation->price+$vat)); ?>$ </span></button>        
                            <?php endif; ?>
                        <?php endif; ?>


                    <?php else: ?>
                    <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;"><?php echo e(floor($first_Variation->price+$vat)); ?>$ </span></button>
                    <?php endif; ?>
                    <?php endif; ?>
                
                </div>
            </div>
        </div>
        <div id="change-search" class="collapse" aria-expanded="false" style="">
            <div class="ccontrn">
                <div class="change-search-wrapper">

                    <div class="row gap-20">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="row gap-0">

                                <div class="col-xs-12 col-sm-12 col-md-12 groups-box">
                                    <div class="gbox">
                                    <?php if($courseType->type=="online"): ?>
                                          
                                  <?php else: ?>
                                          
                                  <?php endif; ?>
                                      
                                        <form id="cart-form" class="search_form incourse" method="post" action="<?php echo e(url(App('urlLang').'cart/add-to-cart')); ?>" enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>

                                            <?php if(Auth::check() ): ?>
												<?php if(isset(Auth::user()->user_lang->lang_stud)): ?>
													<span> لقد قمت باختيار اللغة  <?php echo e(Auth::user()->lang()=='Fr' ?"فرنسية'" : "عربية'"); ?> سابقا</span>
												<?php else: ?>
													<div class="form-group">
														<label class="form-label "> إختر لغة المحتوى   </label>
														<select class="form-control country_id" name="lang" id="lang" style="width: 200px;margin: auto;">
															<option >إختر لغة</option>
														   
																<option value="Fr" <?php echo e($user->lang()=="Fr" ? 'selected' :''); ?>>
																   فرنسية
																</option>
																 <option value="Ar" <?php echo e($user->lang()=="Ar" ? 'selected' :''); ?>>
																   عربية
																   </option>
															
														</select>
														
													</div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <div class="form-group select_group">
                                                <input type ="hidden" name="quantity" value="1">
                                                
                                                        
                                                            
                                                    
                                                       
                                                        
                                            </div>
                                            <div class="form-group select_group">
                                                <?php if($courseType->type=="online"): ?>
                                                
                                                <div class="radio-list">
                                                    <?php $__currentLoopData = $courseType->couseType_variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseTypeVariation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label>
                                                        <input type="hidden" class="select_form" name="coursetypevariation_id" value="<?php echo e($courseTypeVariation->id); ?>" data-price="<?php echo e($courseTypeVariation->price); ?>" checked="checked" >
                                                        
                                                        <?php if($courseType->type!="online"): ?>
                                                            
                                                        <?php endif; ?>

                                                        
                                                         <?php if($courseType->id == 296): ?>  
                                                            <?php if($course->isPayCourse()): ?>                                                      
                                                                <span><?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$</span>
                                                            <?php else: ?>
                                                                <?php if($course->isPayCourseLevel2()): ?> 
                                                                    <span><?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$</span>
                                                                <?php else: ?>
                                                                    <?php if($course->isPayPackThree()): ?>  
                                                                        <span><?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$</span>
                                                                    <?php else: ?>
                                                                     <span><?php echo e(floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)); ?>$</span>  
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                           
                                                        <?php endif; ?>
                                                        
                                                    </label>
                                                    
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                   <!--  <label>اﺧﺘﺮ اﻟﻤﺪﺭﺏ</label> -->
                                                <?php else: ?>
                                                    <label><?php echo app('translator')->getFromJson('navbar.choosecoachandDate'); ?></label>
                                                <div class="radio-list">
                                                    <?php $__currentLoopData = $courseType->couseType_variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseTypeVariation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label>
                                                        <input type="radio" class="select_form" name="coursetypevariation_id" value="<?php echo e($courseTypeVariation->id); ?>" data-price="<?php echo e($courseTypeVariation->price); ?>" checked="checked" >
                                                        <span><?php echo app('translator')->getFromJson('navbar.coach'); ?> : </span><span><?php echo e($courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')}); ?></span>
                                                        <?php if($courseType->type!="online"): ?>
                                                            <span>( <?php echo e(isset($courseTypeVariation->government->government_trans(session()->get('locale'))->name) ? $courseTypeVariation->government->government_trans(session()->get('locale'))->name : null); ?></span>
                                                            <span><?php echo e(trans('home.start_at')); ?></span><span><?php echo e($courseTypeVariation->date_from); ?><span><?php echo app('translator')->getFromJson('navbar.until'); ?></span><?php echo e($courseTypeVariation->date_to); ?> )</span>
                                                        <?php endif; ?>


                                                         
                                                     <?php if($courseType->id == 296): ?>  
                                                         <?php if($course->isPayCourse()): ?>                                                    
                                                          <span><?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$</span>
                                                         <?php else: ?>
                                                             <?php if($course->isPayCourseLevel2()): ?>                                                    
                                                             <span><?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$</span>
                                                             <?php else: ?>
                                                                <?php if($course->isPayPackThree()): ?> 
                                                                    <span><?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$</span>
                                                                <?php else: ?>
                                                                    <span><?php echo e(floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)); ?>$</span>  
                                                                <?php endif; ?>
                                                             <?php endif; ?>
                                                         <?php endif; ?>
                                                     <?php else: ?>
                                                      <span><?php echo e(floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)); ?>$</span> 
                                                     <?php endif; ?>
                                               
                                                    </label>
                                                    
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <?php endif; ?>
                                          
                                            </div>
                                            <!--div class="form-group select_group">
                                                <select name="date" class="form-control select_form">
                                                    <option value="" selected>اﺧﺘﺮ ﺗﺎﺭﻳﺦ اﻟﺪﻭﺭﺓ</option>
													<?php $__currentLoopData = $courseType->couseType_variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseTypeVariation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<option value=""><?php echo e($courseTypeVariation->date_from); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                </select>
                                            </div-->
                                            <?php if( !$course->isSuccessParent() && $course->needsExperience == true): ?>
                                                <div class="form-group" id="experience_files_group" >
                                                    <label><?php echo app('translator')->getFromJson('navbar.uploadExpirianceDocument'); ?></label>
                                                    <input type='file' name='experience_files[]' id='experience_files' multiple required="" />
                                                </div>
                                            <?php endif; ?>


                                            <?php if($courseType->id == 296): ?>  
                                                <?php if($course->isPayCourse()): ?>
                                                
                                                <div class="form-group" id="certif_file_296" > 
                                                    <label>أرفق الشهادة</label>
                                                    <input type='file' name='certif_file_296' id='certif_file_296' />
                                                </div>
                                                <?php else: ?>
                                                    <?php if($course->isPayCourseLevel2()): ?> 
                                                    <div class="form-group" id="certif_file_296" >
                                                        <label>أرفق الشهادة</label>
                                                        <input type='file' name='certif_file_296' id='certif_file_296' />
                                                    </div>
                                                    <?php else: ?>
                                                        <?php if($course->isPayPackThree()): ?>   
                                                        <div class="form-group" id="certif_file_296" >
                                                            <label>أرفق الشهادة</label>
                                                            <input type='file' name='certif_file_296' id='certif_file_296' />
                                                        </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>


                                            <p class="price btnadd">
                                                <button type="submit" class="btn btn-primary  btn-md"> <?php echo app('translator')->getFromJson('navbar.buy'); ?><span id="ttlprc"></span>
                                                    
                                                        <b><span id="quantity_span">
                                                            
                                                        
                                                            <?php if($courseType->id == 296): ?>  
                                                                <?php if($course->isPayCourse()): ?>
                                                                  <?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$
                                                                <?php else: ?>
                                                                    <?php if($course->isPayCourseLevel2()): ?>  
                                                                     <?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$ 
                                                                     <?php else: ?>
                                                                        <?php if($course->isPayPackThree()): ?>  
                                                                              <?php echo e(floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2)); ?>$ 
                                                                         <?php else: ?>
                                                                    <?php echo e(floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)); ?>$ 
                                                                         <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                             
                                                                
                                                                <?php echo e(floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)); ?>$ <!---edit_price --->

                                                            <?php endif; ?>
                                                        </span> 
                                            
                                                      
                                            </p> 

                                         

                                        </form>

                                    </div>


                                </div>

                            </div>

                        </div>



                    </div>

                </div></div>
        </div><!--g-->
    </div>
</div>


<!-----------------modal lang ------->

<div class="modal" tabindex="-1" role="dialog" id="lang_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> سنقوم بتغيير لغة المنهج و الاختبارات إلى اللغة  :<span id='langlabel'></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="color: red;"> احرص على الإختيار  الأول المجاني للغة المحتوى و في حال أردت تغييرها فعليك دفع 50$   </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="save_lang">أوافق</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#lang').on('change', function() {
        $('#langlabel').html($("#lang option:selected").text());
        $('#lang_modal').modal('show');
    });

    $('#save_lang').on('click', function() {

        var lang =$('#lang').val() ;
        url = "<?php echo e(route('add.student.lang',['lang'=>':lang','user'=>Auth::id()])); ?>";
        url = url.replace(':lang', lang);
 
        window.location.href= url ;




       

    });


</script>