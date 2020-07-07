<div class="row">
    <div class="col-1 curriculum_exam_type">
        <i class="fa fa-check" aria-hidden="true"></i>
    </div>
    <div class="col-6 curriculum_exam_title">
    
        <?php if($type!="video"): ?>
            <?php if($type == "pdf"): ?>
               
            <?php else: ?>
            <p><?php echo e(isset($quiz->quiz_trans(session()->get('locale'))->name) ? $quiz->quiz_trans(session()->get('locale'))->name : null); ?></p>
            <?php endif; ?>
        <?php else: ?>
        
            <p><?php echo e(isset($quiz->videoexam_trans(session()->get('locale'))->name) ? $quiz->videoexam_trans(session()->get('locale'))->name : null); ?></p>
      
        <?php endif; ?>
       
    </div>
    <div class="col-2 curriculum_exam_question_number">
        <?php if($type!="video"): ?>
             <?php if($type=="pdf"): ?>
            
           <?php else: ?>

            <p><?php echo e($quiz->num_questions); ?> <?php echo app('translator')->getFromJson('navbar.question'); ?></p>
            <?php if($type=="exam"): ?>
                <?php echo app('translator')->getFromJson('navbar.numrepetition'); ?>
                <?php if(Auth::check()): ?>
                    <?php echo e($quiz->students_quizzes()->where("student_id",Auth::user()->id)->count()); ?>
                <?php else: ?>
                    0
                <?php endif; ?> 
            <?php else: ?>
            
            <?php endif; ?>
        <?php endif; ?> 
        <?php endif; ?>
    </div>
    <div class="col-3 curriculum_exam_watch">
        <?php if(!empty($user)): ?>
            <?php
                $messageValid = "";
				//print_r($course);
                $validQuiz = $course->validateQuiz($type,$messageValid);
                $validAttempts = true;
                $expired = false;
                if($type == "exam" && !$course->isFree()){
                    $validAttempts  = $course->validQuizAttempts($quiz);
                    $expired        = $exam->isExpired($course);
                }
            ?>
            <?php if($validAttempts): ?> 
                <?php if(!$expired): ?>
                    <?php if($validQuiz): ?>
                        <?php
                        $student = $user->student;
                        $completedcount = 0;
                        if(!empty($student)){
                            $currentQuiz = null;
                            if($type == "video"){
                                $completedcount = $student->student_videoexams()->where("videoexam_id",$quiz->id)->where("course_id",$course->id)->where("status","!=","not_completed");
                                $studentQuiz = $student->student_videoexams()->where("videoexam_id",$quiz->id)->where("course_id",$course->id);
                                $studentQuizTmp = $student->student_videoexams()->where("videoexam_id",$quiz->id)->where("course_id",$course->id)->where("status","!=","not_completed");
                            }else{
                                $completedcount = $student->student_quizzes()->where("quiz_id",$quiz->id)->where("course_id",$course->id);
                                $studentQuiz = $student->student_quizzes()->where("quiz_id",$quiz->id)->where("course_id",$course->id);
                                $studentQuizTmp = $student->student_quizzes()->where("quiz_id",$quiz->id)->where("course_id",$course->id);

                                $startTime = date("Y-m-d H:i:s");
                                $stopTime = date("Y-m-d H:i:s", strtotime("+".$quiz->duration." minutes"));
                                $currentQuiz = $student->student_quizzes()->where("quiz_id",$quiz->id)->where("course_id",$course->id)
                                    ->where("startime","<=",$startTime)->where("startime",">",$stopTime)
                                   ->first();
                            }

                            $completedcount = $completedcount->count();
                            $studentQuiz = $studentQuiz
                                ->where("status","=","completed")->orderBy("successfull","desc")->orderBy("id")->first();
                            $studentQuizTmp = $studentQuizTmp
                                ->orderBy("successfull","desc")->orderBy("id","desc")->first();
							
							

                        }else{
                            echo '<p class="failed">'.__lang('navbar.youarenotstudent').'</p>';
                        }
                        ?>
                        <?php if(!empty($student)): ?>
                            <?php if($completedcount>0): ?>
                                <?php if(!empty($currentQuiz)): ?>
                                        <button class="startquiz" data-id="<?php echo e($quiz->id); ?>" data-type="<?php echo e($type); ?>"><?php echo app('translator')->getFromJson('navbar.completetest'); ?></button>
                                <?php else: ?>
                                    <?php if(!empty($studentQuiz) || $type!="video"): ?>
                                        <?php if($studentQuizTmp->successfull): ?>
                                            <p class="success"><?php echo app('translator')->getFromJson('navbar.succeded'); ?></p>
                                        <?php else: ?>
                                            <p class="failed"><?php echo app('translator')->getFromJson('navbar.notsucceded'); ?></p>
                                        <?php endif; ?>
                                        <a class="startquiz" href="<?php echo e(url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuizTmp->id.'&type='.$type)); ?>"><?php echo app('translator')->getFromJson('navbar.showresult'); ?></a>

                                        <?php if(!($studentQuizTmp->successfull || $type=="video")): ?>
                                                <?php if($type!="video" && $quiz->num_questions==0): ?>
                                                    <p><?php echo app('translator')->getFromJson('navbar.noquestionPleaseWait'); ?></p> 
                                                <?php else: ?>
													<button class="startquiz" data-id="<?php echo e($quiz->id); ?>" data-type="<?php echo e($type); ?>"><?php echo app('translator')->getFromJson('navbar.repassexam'); ?></button>
													<!--?php
														$quizzzz=$quiz->students_quizzes->where("quiz_id",$quiz->id)->where("course_id",$course->id)->where("student_id",Auth::user()->id)
														->last();
														$stopTimes = date("Y-m-d H:i:s");
														//echo $quizzzz["stoptime"];
														$currentDate = strtotime($quizzzz["stoptime"]);
														$futureDate = $currentDate+(60*5);
														$formatDate = date("Y-m-d H:i:s", $futureDate);
														//echo $stopTimes."<br>".$formatDate;
														if($stopTimes>$formatDate){
													}else{ 
														
														<a style="color: #fff;background-color: #ce0000;border: none;width: 100px;font-family: 'helva';font-size: 9pt;margin-bottom: 5px;border-radius: 30px;transition: all ease-out 0.3s;cursor: pointer;height: 34px; display: inline-block; padding-top:5px;" onclick="alerttt()">إعادة الاختبار</a>
													 } ?-->
													
                                                <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="processing"><?php echo app('translator')->getFromJson('navbar.waitingPreview'); ?>
                                        <?php if(!empty($studentQuizTmp)): ?>
                                            <a class="startquiz" href="<?php echo e(url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuizTmp->id.'&type='.$type)); ?>"><?php echo app('translator')->getFromJson('navbar.showresult'); ?></a>
                                        <?php endif; ?>
                                        </p> 
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($type!="video"&&$quiz->num_questions==0): ?>
                                    <p><?php echo app('translator')->getFromJson('navbar.noquestionPleaseWait'); ?></p>
                                <?php else: ?>
                                    <button class="startquiz" data-id="<?php echo e($quiz->id); ?>" data-type="<?php echo e($type); ?>"><?php echo app('translator')->getFromJson('navbar.starttest'); ?></button>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo $messageValid; ?>
                    <?php endif; ?>
                <?php else: ?>
                        <div class="alert alert-danger">
                         <?php echo app('translator')->getFromJson('navbar.timeIsOver'); ?>
                            <form id="cart-form" class="search_form incourse" method="post" action="<?php echo e(url(App('urlLang').'cart/add-to-cart')); ?>">
                                <?php echo e(csrf_field()); ?>
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>">
                                <input type="hidden" name="quiz_id" value="<?php echo e($quiz->id); ?>">
                                <p>
                                    <button type="submit" class="buy_book_now"> <?php echo app('translator')->getFromJson('navbar.addToCart'); ?></button>
                                </p>
                            </form>
                        </div>
                <?php endif; ?>
            <?php else: ?>
                    <div class="alert alert-danger">
                      <?php echo app('translator')->getFromJson('navbar.passedmaxtestpleaseBuy'); ?>
                        <form id="cart-form" class="search_form incourse" method="post" action="<?php echo e(url(App('urlLang').'cart/add-to-cart')); ?>">
                            <?php echo e(csrf_field()); ?>
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="quiz_id" value="<?php echo e($quiz->id); ?>">
                            <p>
                                <button type="submit" class="buy_book_now"> <?php echo app('translator')->getFromJson('navbar.addToCart'); ?></button>
                            </p>
                        </form>
                    </div>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?php echo e(url(App('urlLang').'login')); ?>"><?php echo app('translator')->getFromJson('navbar.pleaseLogIn'); ?></a>
        <?php endif; ?>
    </div>
</div>
