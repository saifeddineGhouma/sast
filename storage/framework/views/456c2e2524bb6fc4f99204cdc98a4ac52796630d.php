<div class="col-lg-12 course_curriculum_exam courses_more_info_content">
    <div class="content_header_one">
        <p>الامتحانات</p>
        <?php echo $course->description_all_exam; ?>

     
    </div>
    <div id="accordion">
        <div class="card curriculum_exam_card card_deactive">
            <div class="card-header" id="headingTen">
                <h5 class="mb-0">
                    <p class=" btn-link ">
                        إجتياز الاختبارات التالية قبل البدأ في الاختبار النهائي للحصول على الشهادة
                    </p>
                </h5>
            </div>

            <div>
                

                <div class="card-body">
                    <h3 class="form-section">الكويزات</h3> 
                    <div class="content_header_one">
                    <?php echo $course->description_quiz; ?>

                    </div>

                    <?php if($quizzes->count()>0): ?> 
                        <?php if(in_array($courseType->id, [292, 298, 328])): ?> 
                            <?php if($user): ?>    
                                <?php if(!$user->user_lang()->exists()): ?>
                                <div> اختر لغة الدراسة  في المنهج الدراسي </div>
                                <?php else: ?>
                                <?php if($user->user_lang->lang_stud == "fr" ): ?>
                                        <?php $__currentLoopData = $quizzesTestFr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $quizzesTest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                    <?php else: ?>
                        <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <?php else: ?>
                        <p>لا يوجد امتحانات</p>
                    <?php endif; ?>

                    

                    <?php if(in_array($courseType->id, [54, 328])): ?>

                        <h3 class="form-section">الإختبار النهائي النظري</h3>
                        <div class="content_header_one">
                        <?php echo $course->desciption_exam; ?>

                        </div>
                        <?php if($courseType->id == 328): ?>
                            <?php if(!empty($user)): ?>
                                <?php if($examsTest->count()>0): ?>
                                        <?php if(!$user->user_lang()->exists()): ?> 
                                        <div> اختر لغة الدراسة  في المنهج الدراسي </div>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $examsTest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                <?php else: ?>
                                    <p>لا يوجد امتحانات</p> 
                                <?php endif; ?> 
                           <?php endif; ?> 

                        <?php else: ?>
                            <?php if($exams->count()>0): ?>
                                <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            <?php else: ?>
                                <p>لا يوجد امتحانات</p> 
                            <?php endif; ?>
                    <?php endif; ?> 
 
                        
                        
                        <?php
                        $messageValid = "";
                        //print_r($course);
                        $validQuiz = $course->validateExam("quiz",$messageValid);
                        
                        $validAttempts = true;
                        $expired = false;
                       
                     $validateExam = $course->validateExam("quiz",$messageValid);

                    ?>
                        
                        <h3 class="form-section"> التدريب العملي </h3>    
                        <div class="content_header_one">
                        <?php echo $course->description_stage; ?>

                        </div>
                        <?php if(!empty($user)): ?> 
                            <?php if($validateExam): ?>
                           
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
                                <?php if($courseType->id == 328): ?>
                                    <?php if($user->user_lang()->exists()): ?>
                                        <?php if($user->user_lang->lang_stud == "fr" ): ?>
                                            <p> <a href = "<?php echo e(route('downloadStage')); ?>"> استمارة مطلب التربص </a>  </p>
                                        <?php else: ?>
                                            <p> <a href = "<?php echo e(route('downloadDemandeStageArab')); ?>"> استمارة مطلب التربص </a>  </p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                 <p> <a href = "<?php echo e(route('downloadDemandeStageArab')); ?>"> استمارة مطلب التربص </a>  </p>
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
                                <?php if($courseType->id == 328): ?>
                                    <?php if($user->user_lang()->exists()): ?>
                                        <?php if($user->user_lang->lang_stud == "fr" ): ?>
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
                    
                    
                    <?php else: ?>
                    <?php echo $messageValid; ?>

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
                        
                
              
                        <h3 class="form-section">إمتحانات الفيديو</h3>
                        <div class="content_header_one">
                        <?php echo $course->description_exam_video; ?>

                        </div>
                        <?php if($videoExams->count()>0): ?> 
                            <?php $__currentLoopData = $videoExams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $videoExam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$videoExam,"type"=>"video"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p>لا يوجد امتحانات</p>
                        <?php endif; ?> 
                    <?php else: ?>                
                   <!---start study party--->
                   <hr/>
                    <h3 class="form-section" > : متطلبات الدورة</h3>
                    <div class="content_header_one">
                    <?php echo $course->description_study_party; ?>

                      <?php if($passed>0): ?>
                     <p style="p color: rgb(3, 227, 172);font-size: 20px;float:left">لقد اجتزت الاختبار</p>
                     <?php else: ?> 

                     <a  id="start" class="ui-btn ui-shadow ui-corner-all ui-icon-plus ui-btn-icon-notext ui-btn-inline" style="cursor: pointer; color: rgb(3, 227, 172);font-size: 20px;float:left">ابدء</a>
                  
                  
                    
                  
                  
                     <?php endif; ?>

                     <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
                      <script type="text/javascript">
                      $( document ).ready( function() {
    
                            $('#start').click(function(){
                            var link = $(this);
                            $('#study_case').slideToggle('slow', function() {
                                if ($(this).is(':visible')) {
                                    link.text('غلق'); 
                                    link.css('color','red')
                       
                                } else {
                                    link.text('ابدء');     
                                    $('#btCategoriaA').addClass('btn-success');
                                    link.css('color','green')
          
                                }        
                            });       
                          });



                        });

                      </script>
                      <!---form study case --->
                            <div id="study_case" style="display:none">
                                <h5>الموضوع  :  <?php echo e($sujet->description); ?> </h5>
                                <form action="<?php echo e(route('post.study.case')); ?>" method="post">
                                    <?php echo e(csrf_field()); ?>



                                    <input type="hidden" name="sujets_id" value="<?php echo e($sujet->id); ?>">
                                    <input type="hidden" name="courses_id" value="<?php echo e($course->id); ?>">
                                    
                                    <div class="custom-file">
                                        <input type="file" name="document" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="user_message" rows="5" id="comment"></textarea>
                                    </div>


                                    


                                    <button class="btn btn-success btn-block" type="submit">Save </button>
                                </form>                           
                                
                            </div>

                      <!------>
                     
                  
                    </div>
                   
                    <!---end study party---->

                    <h3 class="form-section">إمتحانات الفيديو</h3>
                    <div class="content_header_one">
                    <?php echo $course->description_exam_video; ?>

                    </div>
                    <?php if($videoExams->count()>0): ?> 
                        <?php $__currentLoopData = $videoExams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $videoExam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$videoExam,"type"=>"video"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p>لا يوجد امتحانات</p>
                    <?php endif; ?> 


      
                    <?php if(in_array($courseType->id, [292, 298])): ?> 

                 
                    <h3 class="form-section"> التدريب العملي </h3>  
                    <div class="content_header_one">
                    <?php echo $course->description_stage; ?>  
                    </div>
                    <?php if(!empty($user)): ?>
                    <form method="post"  action='<?php echo e(url(App("urlLang")."postAddStage",[$courseType->course->id, $user->id])); ?>' accept-charset="utf-8" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <?php if($user->user_lang()->exists()): ?>
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
  
                            <?php if($user->user_lang->lang_stud == "fr" ): ?>
                                <p> <a href = "<?php echo e(route('downloadStage')); ?>"> استمارة مطلب التربص </a>  </p>
                            <?php else: ?>
                                <p> <a href = "<?php echo e(route('downloadDemandeStageArab')); ?>"> استمارة مطلب التربص </a>  </p>
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
                                <?php if($validAttempts): ?>
                                    <?php if(!$expired): ?>
                                        <?php if($validQuiz): ?>
                                            <input type="file" name="demande_stage" >
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
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
                            

                            <?php if($user->user_lang->lang_stud == "fr" ): ?>
                            <p> <a href = "<?php echo e(url('download_eval')); ?>"> استمارة التقييم </a>  </p>  
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
 
                            <?php if($validAttempts): ?>
                                <?php if(!$expired): ?>
                                    <?php if($validQuiz): ?>

                                        <input type="file" name="evaluation_stage" >


                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>


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
                     <?php else: ?> 
                     <div class="row">
                        <div class="col-1 curriculum_exam_type">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                        <div class="col-6 curriculum_exam_title">
                            <p> اختر لغة الدراسة في المنهج الدراسي   </p>
                        </div>
                        <div class="col-2 curriculum_exam_question_number">
                         </div>

                        <div class="col-3 curriculum_exam_watch">
                        
                        </div>  
                    </div>
                   <?php endif; ?>
                </form>
                <?php endif; ?>
                <?php endif; ?>
                    <?php if(in_array($courseType->id, [54, 328])): ?>

                    <?php else: ?>

                    <h3 class="form-section">الإمتحانات النهائية</h3>
                    <div class="content_header_one">
                    <?php echo $course->desciption_exam; ?>  
                    </div>
                    <?php if(in_array($courseType->id, [292, 298, 328])): ?> 
                        <?php if(!empty($user)): ?>
                            <?php if($examsTest->count()>0): ?>
                                <?php if(!$user->user_lang()->exists()): ?> 
                                <div> اختر لغة الدراسة  في المنهج الدراسي </div>
                                <?php else: ?>
                                    <?php $__currentLoopData = $examsTest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>لا يوجد امتحانات</p> 
                            <?php endif; ?> 
                        <?php endif; ?>
                    
                    <?php else: ?>

                        <?php if($exams->count()>0): ?>
                            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php echo $__env->make("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p>لا يوجد امتحانات</p>
                        <?php endif; ?> 
                    <?php endif; ?>
                   <?php endif; ?>
                   
                   <!---5eme parti of certif--->
                   
                   
                  <!------end----->
                    
                <?php endif; ?>
                </div> 

            </div>
        </div>
    </div>

</div>