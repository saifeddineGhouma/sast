

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script type="text/javascript">
                    $( document ).ready( function() {
                          
                        
                        $('#div_exam_final').click(function(){
                            var link = $(this);
                            $('.exam_final_block').slideToggle('slow', function() {
                                if ($(this).is(':visible')) {
                                  
                                  $('#div_exam_final span').text('-'); 
                                
                                } else {
                                    $('#div_exam_final span').text('+');   
                                 
          
                                }    
        
                            });   
                          })
                          
                          
                          
                       $('#div_examn_vedio_2').click(function(){
                        var link = $(this);
                        $('.examn_vedio_2_block').slideToggle('slow', function() {
                            if ($(this).is(':visible')) {
                               
                              $('#div_examn_vedio_2 span').text('-'); 
                            
                            } else {
                                $('#div_examn_vedio_2 span').text('+');   
                                       
                            }    
    
                        });   
                      })
                          
                      $('#div_exam_final_thorique').click(function(){
                        var link = $(this);
                        $('.exam_final_thorique_block').slideToggle('slow', function() {
                            if ($(this).is(':visible')) {
                               
                              $('#div_exam_final_thorique span').text('-'); 
                            
                            } else {
                                $('#div_exam_final_thorique span').text('+');                                              
                            }    
    
                        });   
                      })

                    $('#div_quiz').click(function(){
                        var link = $(this);
                        $('.quiz_block').slideToggle('slow', function() {
                            if ($(this).is(':visible')) {
                                
                              $('#div_quiz span').text('-'); 
                            
                            } else {
                                $('#div_quiz span').text('+');   
                             
      
                            }    
    
                        });   
                    })


                    $('#div_stage').click(function(){
                        
                        var link = $(this);
                        $('.stage_block').slideToggle('slow', function() {
                            if ($(this).is(':visible')) {
                                
                              $('#div_stage span').text('-'); 
                            
                            } else {
                                $('#div_stage span').text('+');                                    
      
                            }    
    
                        });   
                    })


                    $('#div_video').click(function(){
                        var link = $(this);
                        $('.video_block').slideToggle('slow', function() {

                            if ($(this).is(':visible')) {
                               
                              $('#div_video span').text('-'); 
                            
                            } else {
                                $('#div_video span').text('+');   
                                       
                            } 
                         
                               
                        });   
                      })
    
                    $('#div_study_case').click(function(){
                    
                    var link = $(this);
                    $('.study_case_block').slideToggle('slow', function() {
                        if ($(this).is(':visible')) {
                           
                          $('#div_study_case span').text('-'); 
                        
                        } else {
                            $('#div_study_case span').text('+');   
                         
                        } 
                    });       
                  });

                        });

</script>
                      

<div class="col-lg-12 course_curriculum_exam courses_more_info_content">
    <div class="content_header_one">
        <p>الامتحانات</p>
        <?php echo $course->description_all_exam; ?>

        <?php if(Session::has('message')): ?>
            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <script>
                toastr.success("<?php echo e(Session::get('message')); ?>");
                swal({
                  title: "<?php echo e(Session::get('message')); ?>",
                  text: "",
                  icon: "success",
                  button: "Ok",
                });
            </script>
          
        <?php endif; ?>
     
    </div>
    <div id="accordion">
        <div class="card curriculum_exam_card card_deactive">
            <div class="card-header" id="headingTen">
                <h5 class="mb-0">
                    <p class=" btn-link ">
                        إجتياز الاختبارات التالية قبل البدأ في الاختبار النهائي للحصول على الشهادة 
                </h5>
            </div>
            <div>
                <div class="card-body">
                  
                        
                
                    <h3 class="form-section"  style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100% ; cursor: pointer;" id="div_quiz"> <span style="float: left;padding-left:10px;"> + </span>الكويزات</h3> 
                    <div class="content_header_one quiz_block" style="display: none">
                    <?php echo $course->description_quiz; ?>

                   
                   
                   
                    <?php if($quizzes->count()>0): ?> 

                        <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p>لا يوجد امتحانات</p>
                    <?php endif; ?>
                    
                    </div>
                    

                    <?php
                        $messageValid = "";
                        $validQuiz = $course->validateExam("quiz",$messageValid);
                            
                        $validAttempts = true;
                        $expired = false;
                           
                        $validateExam = $course->validateExam("quiz",$messageValid);
                    ?>
                    
                    
                    
                    <?php if(isset($course->stage)): ?>
                        
                        <?php if($course->stage->active): ?>

                        <h3 class="form-section "style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100% ; cursor: pointer;" id="div_stage"> <span style="float: left;padding-left:10px;"> + </span> التدريب العملي  </h3>    
                        <div class="content_header_one stage_block" style="display:none">
                        <?php echo $course->description_stage; ?>

                        
                            <?php if(!empty($user)): ?> 

                                <?php if($course->students_stage()->where('user_id',$user->id)->count()): ?>

                                    <p class="text-danger"> لقد قمت برفع الملف  </p>

                                    <p class="text-success"><?php echo e(($course->students_stage()->where('user_id',$user->id)->first()->valider==1)? 'ناجح' : 'إنتظار'); ?></p>
                                    <ul class="list-group" style="width: 500px;margin:auto;">
                                        <?php $__currentLoopData = $user->user_stage()->where('course_id',$course->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <li class="list-group-item"> التقرير<span style="float: left" onclick="return confirm('Are you sure you want to delete this file?');"><a href="<?php echo e(route('delete.stage',$stage->id)); ?>"><i class="fa fa-trash"></i></a></span>

                                      </li>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     
                                    </ul>

                                   <?php else: ?>


                                   <form method="post"  action='<?php echo e(url(App("urlLang")."postAddStage",[$courseType->course->id, $user->id])); ?>' accept-charset="utf-8" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <div class="row">
                                            <div class="col-1 curriculum_exam_type">                                    
                                            </div>
                                            <div class="col-6 curriculum_exam_title">
                                                تحميل الملفات

                                            </div>
                                            <div class="col-2 curriculum_exam_question_number">
                                                رفع الملفات من جهازك
                                            <br/>
                                            </div>
                                            <div class="col-3 curriculum_exam_watch">           
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1 curriculum_exam_type">
                                                
                                            </div>
                                            <div class="col-6 curriculum_exam_title">
                                               <input type="hidden">
                                               <br/>
                                               
                                            </div>
                                            <div class="col-2 curriculum_exam_question_number">
                                                <input type="hidden">
                                                <br/>
                                            </div>
                                            <div class="col-3 curriculum_exam_watch">           
                                                
                                            </div>
                                        </div>
                                            <div class="row">
                                                <div class="col-1 curriculum_exam_type">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </div>     

                                                <div class="col-6 curriculum_exam_title">   
                                                      <?php if($course->is_lang): ?>
                                                        
                                                        <?php if($user->user_lang()->exists()): ?>
                                                            <?php if($user->user_lang->lang_stud == "Fr" ): ?>
                                                                <p> <a href = "<?php echo e(route('downloadStage')); ?>"> استمارة مطلب التربص </a>  </p>
                                                            <?php else: ?>
                                                                <p> <a href = "<?php echo e(route('downloadDemandeStageArab')); ?>"> استمارة مطلب التربص </a>  </p>
                                                            <?php endif; ?>
                                                          <?php endif; ?>
                                                        <?php else: ?>
                                                       <p> <a href = "<?php echo e(route('downloadDemandeStageArab')); ?>">  استمارة مطلب التربص </a>  </p>
                                                    <?php endif; ?>
                                                </div>
                                    
                                                <div class="col-2 curriculum_exam_question_number">
                                                    <?php if(!empty($user)): ?>   
                                                    <?php
                                                        $messageValid = "";                               
                                                        $validQuiz = $course->validateQuiz("stage", $messageValid);
                                                        $validAttempts = true;
                                                        $expired = false;                               
                                                    ?>
                                
                                                        <input type="file" name="demande_stage" >
                                                    <?php endif; ?> 
                                                 </div>
                                                <div class="col-3 curriculum_exam_watch">
                                                
                                                </div>  
                                            </div>   
                                            <div class="row">
                                                <div class="col-1 curriculum_exam_type">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </div>
                                                
                                                <div class="col-6 curriculum_exam_title">  
                                                                                                           
 
                                                    <?php if($course->is_lang ): ?>
                                                        <?php if($user->user_lang()->exists()): ?>
                                                            <?php if($user->user_lang->lang_stud == "Fr" ): ?>
                                                            <p> <a href = "<?php echo e(url('download_eval')); ?>"> استمارة التقييم </a>  </p>  
                                                            <?php else: ?>
                                                            <p> <a href = "<?php echo e(url('download_eval_arab')); ?>"> استمارة التقييم </a>  </p>  
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                     <p> <a href = "<?php echo e(url('download_eval_arab')); ?>"> استمارة التقييم </a>  </p>  
                                                    <?php endif; ?>
                                                </div>


                        
                                                <div class="col-2 curriculum_exam_question_number">
                                                     <?php if(!empty($user)): ?>
                                                    <?php
                                                        $messageValid = "";
                                                        //print_r($course);
                                                        $validQuiz = $course->validateQuiz("stage", $messageValid);
                                                        $validAttempts = true;
                                                        $expired = false;
                                                        
                                                    ?>
                         
                                                                <input type="file" name="evaluation_stage" >   
                        
                        
                                                <?php endif; ?> 
                                                </div>
                        
                                                <div class="col-3 curriculum_exam_watch">           
                                                       
                                                </div>
                                            </div>
                                            <div class="row">
                                        <div class="col-1 curriculum_exam_type">
                                            
                                        </div>
                                        <div class="col-6 curriculum_exam_title">
                                        </div>
                                        <div class="col-2 curriculum_exam_question_number">
                                        </div>
                                        <div class="col-3 curriculum_exam_watch">           
                                            <button type="submit" class="startquiz"> رفع الملفين </button>         
                                        </div>
                                     </div>
                                </form>






                                <?php endif; ?>

                                
                                <?php if($user->user_stage->count()<0): ?>



                                           
                                
                                    <?php else: ?>

                                    <?php endif; ?>  
                                       

                                    
                             
                               
                                
                            <?php else: ?>
                                <div class="row">
                                <div class="col-1 curriculum_exam_type">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                                <div class="col-6 curriculum_exam_title">
                                <a href="<?php echo e(url(App('urlLang').'login')); ?>">سجل الدخول</a>
                                </div>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>    

                  


                    <?php if(isset($course->courses_study_case) && $course->courses_study_case->active): ?>
                    
                  
                        <h3 class="form-section div_toggle"  id="div_study_case" style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;"><span style="float: left;padding-left:10px;"> + </span> التقرير العلمي </h3>
                        <div class="content_header_one study_case_block" style="display: none ; border: none;">
                            <?php echo $course->description_study_party; ?>

                            

                            <?php if(!empty($user)): ?>

                               <?php if($user->lang()=="Fr"): ?>
                                <?php echo $__env->make('front.courses.course.study_case.version_fr', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                               <?php else: ?>
                               <?php echo $__env->make('front.courses.course.study_case.version_ar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                               <?php endif; ?>
                        
                            <?php else: ?>  
                              <p>
                                    إعداد تقرير علمي كتابي عن إحدى الحالات او المواضيع الرياضية المتعلقة باللياقة البدنية يتم اختياره بطريقة عشوائية من مجموعة عناوين وحالات معدة مسبقا من قبل الاكاديمية. ويتم مناقشته لمدة 15 دقيقة مع مشرف الدورة بعد تحديد موعد مسبق معه. نسبة نجاح الطالب في هذه المهمة 80%. يمكن ايجاد موضوع التقرير العلمي عند اختيار الحالة من الاسفل
                                    
                                    </p>
                            <p><a href="<?php echo e(route('login')); ?>">سجل الدخول</a></p>


                        <?php endif; ?>
                            

                          


                    
                         
                        </div>
                   
                    <!---end study party---->
                    <?php endif; ?>

                    <?php if( $exams->count() > 0 ): ?>

                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        

                        
                            <h3 class="form-section" style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;" id="div_exam_final">الإمتحانات النهائية <span style="float: left;padding-left:10px;"> + </span></h3>
                                <div class="content_header_one exam_final_block" style="display: none">
                                <?php echo $course->desciption_exam; ?>  
                                
                               
                                <?php if(!empty($user)): ?>
                                    <?php if($exams->count()>0): ?>
                                                   
                                        <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   
                                    <?php else: ?>
                                        <p>لا يوجد امتحانات</p> 
                                    <?php endif; ?> 

                                <?php else: ?> 

                                <p><a href="<?php echo e(route('login')); ?>">سجل الدخول</a></p>
                                <?php endif; ?>
                                
                               
                              
                            </div>

                    <?php else: ?> 


                    <?php endif; ?>   


                    <?php if($videoExams->count()>0): ?> 
                        <h3 class="form-section"  style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;" id="div_video"><span style="float: left;padding-left:10px;"> + </span>إمتحانات الفيديو</h3>
                        <div class="content_header_one video_block" style="display: none ">
                        <?php echo $course->description_exam_video; ?>

                       
                            <?php $__currentLoopData = $videoExams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $videoExam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$videoExam,"type"=>"video"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    <?php endif; ?> 

                </div> 

            </div>
        </div>
    </div>

</div>



