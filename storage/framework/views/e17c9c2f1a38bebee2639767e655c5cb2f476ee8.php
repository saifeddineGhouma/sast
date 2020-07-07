<?php
 $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ;
$myrating = 0;
$mysubject = 0;
$myprice = 0;
$myteacher = 0;
$myexam = 0;
$mytitle = "";
$mycomment ="";

if(Auth::check()){
    $userRating = $course->ratings()->where("user_id",Auth::user()->id)->first();

    if(!empty($userRating)){
        $myrating = $userRating->value;
        $mysubject = $userRating->value_subject;
        $myprice = $userRating->value_price;
        $myteacher = $userRating->value_teacher;
        $myexam = $userRating->value_exam;

        $mytitle = $userRating->title;
        $mycomment = $userRating->comment;
    }
} 

$countRatings = 0;
$sumRatings = 0;
$sumSubject = 0;
$sumPrice = 0;
$sumTeacher = 0;
$sumExam = 0;

$sumFive = $course->sumRating(5);
$sumFour = $course->sumRating(4);
$sumThree = $course->sumRating(3);
$sumTwo = $course->sumRating(2);
$sumOne = $course->sumRating(1);


$fivePercent = ($countRatings!=0)?round($sumFive/$countRatings*100):0 ;
$fourPercent = ($countRatings!=0)?round($sumFour/$countRatings*100):0 ;
$threePercent = ($countRatings!=0)?round($sumThree/$countRatings*100):0 ;
$twoPercent = ($countRatings!=0)?round($sumTwo/$countRatings*100):0 ;
$onePercent = ($countRatings!=0)?round($sumOne/$countRatings*100):0 ;

if(!is_null($course->ratings()->where("approved",1))){
    $countRatings = $course->ratings()->where("approved",1)->count();
    $sumRatings = $course->ratings()->where("approved",1)
        ->select(DB::raw('sum(value) as sumRating,
   sum(value_subject) as sumSubject,sum(value_price) as sumPrice,sum(value_teacher) as sumTeacher,
    sum(value_exam) as sumExam'))->groupBy("course_id")->first();
    if(!empty($sumRatings)){
        $sumSubject = ($sumRatings->sumSubject!=0)?round($sumRatings->sumSubject/$countRatings,1):0;
        $sumPrice = ($sumRatings->sumPrice!=0)?round($sumRatings->sumPrice/$countRatings,1):0;
        $sumTeacher = ($sumRatings->sumTeacher!=0)?round($sumRatings->sumTeacher/$countRatings,1):0;
        $sumExam = ($sumRatings->sumExam!=0)?round($sumRatings->sumExam/$countRatings,1):0;
        $sumRatings = ($sumRatings->sumRating!=0)?round($sumRatings->sumRating/$countRatings,1):0;
    }else{
        $sumRatings = 0;
    }

 
}
?>
<div class="col-md-9 course_teacher courses_more_info_content student-rate">
    <div class="content_header_one">
		<p style="text-align: justify; direction: <?php echo e($dir); ?>;">
		<?php echo e(trans('navbar.studentratePerSession')); ?> </p>
    </div>
	<?php $aff=false; ?>
	<?php if($exams->count()>0): ?> 
		<?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="col-12 curriculum_exam_watch" style="text-align: justify; direction:<?php echo e($dir); ?>;">  
				<?php if(!empty($user)): ?>
					<?php
						$type="exam";
						$messageValid = "";
						//print_r($course);
						$validQuiz = $course->validateQuiz($type,$messageValid);
						$validAttempts = true;
						$expired = false;
						if($type == "exam" && !$course->isFree()){
							$validAttempts  = $course->validQuizAttempts($exam);
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
									
									$completedcount = $student->student_quizzes()->where("quiz_id",$exam->id)->where("course_id",$course->id);
									$studentQuiz = $student->student_quizzes()->where("quiz_id",$exam->id)->where("course_id",$course->id);
									$studentQuizTmp = $student->student_quizzes()->where("quiz_id",$exam->id)->where("course_id",$course->id);

									$startTime = date("Y-m-d H:i:s");
									$stopTime = date("Y-m-d H:i:s", strtotime("+".$exam->duration." minutes"));
									$currentQuiz = $student->student_quizzes()->where("quiz_id",$exam->id)->where("course_id",$course->id)
										->where("startime","<=",$startTime)->where("startime",">",$stopTime)
									   ->first();
									
									$completedcount = $completedcount->count();
									$studentQuiz = $studentQuiz
										->where("status","=","completed")->orderBy("successfull","desc")->orderBy("id")->first();
									$studentQuizTmp = $studentQuizTmp
										->orderBy("successfull","desc")->orderBy("id","desc")->first();
									
									

								}else{
									echo '<p class="failed">'.__('navbar.youarenotstudent').'</p>';
								}
								?>
								<?php if(!empty($student)): ?>
									<?php if($completedcount>0): ?>
										<?php if(!empty($currentQuiz)): ?>
												<button class="startquiz" data-id="<?php echo e($quiz->id); ?>" data-type="<?php echo e($type); ?>">استكمال الاختبار</button>
										<?php else: ?>
											<?php if(!empty($studentQuiz)||$type!="video"): ?>
												<?php if($studentQuizTmp->successfull): ?>
													<?php $aff=true; ?>
												<?php else: ?>
													<?php echo app('translator')->getFromJson('navbar.youcantrateThisExam'); ?>
												<?php endif; ?>
													<a class="startquiz" href="<?php echo e(url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuizTmp->id.'&type='.$type)); ?>">عرض النتائج</a>
											<?php endif; ?>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
							<?php else: ?>
								<?php echo app('translator')->getFromJson('navbar.youcantrateThisExam'); ?>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php else: ?>
					<a href="<?php echo e(url(App('urlLang').'login')); ?>"><?php echo app('translator')->getFromJson('navbar.pleaseLogIn'); ?></a>
				<?php endif; ?>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
	<?php endif; ?>
    <div class="container rate-section">
        <div class="row text-right ">
			<?php if($aff==true){ ?>
				<div class="col-md-3">
					<h6><?php echo app('translator')->getFromJson('navbar.rateing'); ?></h6>
					<p style="margin-top: 20px;"><span class="rate-value"><?php echo e($sumRatings); ?></span> / 5 </p>
					<div class="rate">
						<?php echo $course->rating($sumRatings); ?>

					</div>
					<span>(<?php echo e($countRatings); ?> <?php echo app('translator')->getFromJson('navbar.evaluate'); ?>)</span>
				</div>
				<div class="col-md-6 col-table">
					<table class="table borderless">
						<tbody>
						<tr>
							<td style="width: 40%">
								<div class="rate">
									<span>(5)</span>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
								</div>
							</td>
							<td style="width: 20%">(<?php echo e($sumFive); ?>)</td>
							<td style="width: 40%">
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo e($fivePercent); ?>"
										 aria-valuemin="0" aria-valuemax="100" style="width:<?php echo e($fivePercent); ?>%">
										<span class="sr-only"><?php echo e($fivePercent); ?>% Complete</span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="rate">
									<span>(4)</span>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
								</div>
							</td>
							<td>(<?php echo e($sumFour); ?>)</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo e($fourPercent); ?>"  aria-valuemin="0"
										 aria-valuemax="100" style="width:<?php echo e($fourPercent); ?>%">
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="rate">
									<span>(3)</span>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
								</div>
							</td>
							<td>(<?php echo e($sumThree); ?>)</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo e($threePercent); ?>"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo e($threePercent); ?>%">
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="rate">
									<span>(2)</span>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
								</div>
							</td>
							<td>(<?php echo e($sumTwo); ?>)</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo e($twoPercent); ?>"
										 aria-valuemin="0" aria-valuemax="100" style="width:<?php echo e($twoPercent); ?>%">
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="rate">
									<span>(1)</span>
									<i class="fa fa-star checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
									<i class="fa fa-star-o checked" aria-hidden="true"></i>
								</div>
							</td>
							<td>(<?php echo e($sumOne); ?>)</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo e($onePercent); ?>"
										 aria-valuemin="0" aria-valuemax="100" style="width:<?php echo e($onePercent); ?>%">
									</div>
								</div>
							</td>
						</tr>
						</tbody>
					</table>

				</div>
				<div class="col-md-3">
					<h6><?php echo app('translator')->getFromJson('navbar.middleevoluate'); ?></h6>
					<table class="table borderless">
						<tbody>
						<tr>
							<td style="width: 70%">
								<span><?php echo app('translator')->getFromJson('navbar.qualitedematiere'); ?></span>
							</td>
							<td style="width: 30%"><?php echo e($sumSubject); ?></td>
						</tr>
						<tr>
							<td style="width: 70%">
								<span></span>
							</td>
							<td style="width: 30%"><?php echo e($sumPrice); ?></td>
						</tr>
						<tr>
							<td style="width: 70%">
								<span>منصة التعليم</span>
							</td>
							<td style="width: 30%"><?php echo e($sumTeacher); ?></td>
						</tr>
						<tr>
							<td style="width: 70%">
								<span>الامتحان</span>
							</td>
							<td style="width: 30%"><?php echo e($sumExam); ?></td>
						</tr>
						</tbody>
					</table>

				</div>
			<?php } ?>

        </div>
    </div>

	<?php if($aff==true){ ?>
    <?php if(!$course->trashed() && $course->active): ?>
        <div class="container text-right rate-section">
            <form method="post" id="form-review" action='<?php echo e(url(App("urlLang")."courses/save-course-review/".$course->id)); ?>'>
                <?php echo csrf_field(); ?>

                <input type="hidden" name="currentRating" id="currentRating" value="<?php echo e($myrating); ?>">
                <h5 class="user-rate">قيم هذة الدورة</h5>
                <div class="row add-rate">
                    <div class="col-md-7">
                        <table class="table borderless text-center rtg-table ">
                            <tbody>
<tr>
<td style="width: 30%">
                                    <span></span>
                                </td>
								<td style="width: 5%"></td>
                                <td >سيئ</td>
								 <td >مقبول</td>
								  <td >جيد</td>
								   <td >جيد جدا</td>
								    
									 <td >ممتاز</td>
</tr>

                            <tr>
                                <td style="width: 30%">
                                    <span>جودة المادة</span>
                                </td>
                                <td style="width: 5%">:</td>
                                <td><input type="radio" name="value_subject" value="1" <?php echo e($mysubject==1?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_subject" value="2" <?php echo e($mysubject==2?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_subject" value="3" <?php echo e($mysubject==3?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_subject" value="4" <?php echo e($mysubject==4?'checked':null); ?>><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_subject" value="5" <?php echo e($mysubject==5?'checked':null); ?>><span class="opninrt"> </span></td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <span>السعر</span>
                                </td>
                                <td style="width: 5%">:</td>
                                <td><input type="radio" name="value_price" value="1" <?php echo e($myprice==1?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_price" value="2" <?php echo e($myprice==2?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_price" value="3" <?php echo e($myprice==3?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_price" value="4" <?php echo e($myprice==4?'checked':null); ?>><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_price" value="5" <?php echo e($myprice==5?'checked':null); ?>><span class="opninrt"> </span></td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <span>منصة التعليم</span>
                                </td>
                                <td style="width: 5%">:</td>
                                <td><input type="radio" name="value_teacher" value="1" <?php echo e($myteacher==1?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_teacher" value="2" <?php echo e($myteacher==2?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_teacher" value="3" <?php echo e($myteacher==3?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_teacher" value="4" <?php echo e($myteacher==4?'checked':null); ?>><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_teacher" value="5" <?php echo e($myteacher==5?'checked':null); ?>><span class="opninrt"> </span></td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <span>الامتحان</span>
                                </td>
                                <td style="width: 5%">:</td>
                                <td><input type="radio" name="value_exam" value="1" <?php echo e($myexam==1?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_exam" value="2" <?php echo e($myexam==2?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_exam" value="3" <?php echo e($myexam==3?'checked':null); ?>><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_exam" value="4" <?php echo e($myexam==4?'checked':null); ?>><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_exam" value="5" <?php echo e($myexam==5?'checked':null); ?>><span class="opninrt"> </span></td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <?php if(Auth::check()): ?>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>اكتب تعليقك<em>*</em></label>
                                <textarea name="comment" style="width: 100%;"><?php echo e($mycomment); ?></textarea>
                            </div>
                        </div>

                        <div class="buttons-set">
                            <button class="submit-rate" title="Submit Review" type="submit">ارسال </button>
                        </div>
                    <?php else: ?>
                        <div class="notes-msg">
                            <p> <?php echo e(trans('home.you_must_logged_rate')); ?> <br>
                                <a href="<?php echo e(url(App('urlLang').'login')); ?>" class="rev-log"><?php echo e(trans('home.login_register')); ?></a></p>
                        </div>
                    <?php endif; ?>

                </div>
            </form>
        </div>
    <?php endif; ?>
	<?php } ?>


    <div class="container user-add-rate">
        <?php $__currentLoopData = $course->ratings()->where('course_rating.approved',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card-body row" style="background: rgba(233, 236, 239, 0.5); margin-top: 15px;">
                <div class="col-md-1 body_img">
                    <h5 class="mb-0">
                        <div class=" link_img">
                            <?php if(!empty($rating->user->image)): ?>
                                <img src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$rating->user->image)); ?>" >
                            <?php else: ?>
                                <img src="<?php echo e(asset('assets/front/img/user1.jpg')); ?>" >
                            <?php endif; ?>
                        </div>
                    </h5>
                </div>
                <div class="col-md-11 body_content">
                    <span class="body_content_name"><?php echo e((!empty($rating->user))?$rating->user->username:null); ?></span>
                    <span class="body_content_date"><?php echo e(date("Y-m-d",strtotime($rating->created_at))); ?></span>
                    <div class="clear"></div>
                    <p><?php echo e($rating->comment); ?></p>
                    <table>
                        <tbody>
                         <tr>
                            <th>جودة المادة</th>
                            <td><div class="rate"> <?php echo e($course->rating($rating->value_subject)); ?> </div></td>
                        </tr>
						<tr>
                            <th>السعر</th>
                            <td><div class="rate"> <?php echo e($course->rating($rating->value_price)); ?> </div></td>
                        </tr>
                        <tr>
                            <th>منصة التعليم</th>
                            <td><div class="rate"> <?php echo e($course->rating($rating->value_teacher)); ?> </div></td>
                        </tr>
                       
                        
                        <tr>
                            <th>الامتحان</th>
                            <td><div class="rate"> <?php echo e($course->rating($rating->value_exam)); ?> </div></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
			<?php $__currentLoopData = $comment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($comments->rating_id == $rating->id): ?>
				<div class="card-body row" style="background: rgba(0, 112, 175, 0.15);">
					<div class="col-md-1 body_img">
						<h5 class="mb-0">
							<div class=" link_img">
								<img src="<?php echo e(asset('assets/front/img/user1.jpg')); ?>" >
							</div>
						</h5>
					</div>
					<div class="col-md-11 body_content">
						<span class="body_content_name">أدمين</span>
						<span class="body_content_date"><?php echo e(date("Y-m-d",strtotime($comments->date_create))); ?></span>
						<div class="clear"></div>
						<p><?php echo e($comments->comment); ?></p>
					</div>
				</div>
				<?php endif; ?>
				
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(!$loop->last): ?>
                <div class="line_spetare"></div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<div class="col-md-3 courses_ad">
    <div class="ad">
        <?php echo $course_trans->ad; ?>

    </div>

</div>
