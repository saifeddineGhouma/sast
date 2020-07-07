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
		<p style="text-align: justify; direction: {{ $dir }};">
		{{ trans('navbar.studentratePerSession') }} </p>
    </div>
	<?php $aff=false; ?>
	@if($exams->count()>0) 
		@foreach($exams as $exam)
			<div class="col-12 curriculum_exam_watch" style="text-align: justify; direction:{{ $dir }};">  
				@if(!empty($user))
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
					@if($validAttempts)
						@if(!$expired)
							@if($validQuiz)
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
								@if(!empty($student))
									@if($completedcount>0)
										@if(!empty($currentQuiz))
												<button class="startquiz" data-id="{{ $quiz->id }}" data-type="{{ $type }}">استكمال الاختبار</button>
										@else
											@if(!empty($studentQuiz)||$type!="video")
												@if($studentQuizTmp->successfull)
													<?php $aff=true; ?>
												@else
													@lang('navbar.youcantrateThisExam')
												@endif
													<a class="startquiz" href="{{ url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuizTmp->id.'&type='.$type) }}">عرض النتائج</a>
											@endif
										@endif
									@endif
								@endif
							@else
								@lang('navbar.youcantrateThisExam')
							@endif
						@endif
					@endif
				@else
					<a href="{{ url(App('urlLang').'login') }}">@lang('navbar.pleaseLogIn')</a>
				@endif
			</div>
		@endforeach
	@else
	@endif
    <div class="container rate-section">
        <div class="row text-right ">
			<?php if($aff==true){ ?>
				<div class="col-md-3">
					<h6>@lang('navbar.rateing')</h6>
					<p style="margin-top: 20px;"><span class="rate-value">{{ $sumRatings }}</span> / 5 </p>
					<div class="rate">
						{!! $course->rating($sumRatings) !!}
					</div>
					<span>({{ $countRatings }} @lang('navbar.evaluate'))</span>
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
							<td style="width: 20%">({{ $sumFive }})</td>
							<td style="width: 40%">
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="{{ $fivePercent }}"
										 aria-valuemin="0" aria-valuemax="100" style="width:{{ $fivePercent }}%">
										<span class="sr-only">{{ $fivePercent }}% Complete</span>
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
							<td>({{ $sumFour }})</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="{{ $fourPercent }}"  aria-valuemin="0"
										 aria-valuemax="100" style="width:{{ $fourPercent }}%">
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
							<td>({{ $sumThree }})</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="{{ $threePercent }}"  aria-valuemin="0" aria-valuemax="100" style="width:{{ $threePercent }}%">
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
							<td>({{ $sumTwo }})</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="{{ $twoPercent }}"
										 aria-valuemin="0" aria-valuemax="100" style="width:{{ $twoPercent }}%">
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
							<td>({{ $sumOne }})</td>
							<td>
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="{{ $onePercent }}"
										 aria-valuemin="0" aria-valuemax="100" style="width:{{ $onePercent }}%">
									</div>
								</div>
							</td>
						</tr>
						</tbody>
					</table>

				</div>
				<div class="col-md-3">
					<h6>@lang('navbar.middleevoluate')</h6>
					<table class="table borderless">
						<tbody>
						<tr>
							<td style="width: 70%">
								<span>@lang('navbar.qualitedematiere')</span>
							</td>
							<td style="width: 30%">{{ $sumSubject }}</td>
						</tr>
						<tr>
							<td style="width: 70%">
								<span></span>
							</td>
							<td style="width: 30%">{{ $sumPrice }}</td>
						</tr>
						<tr>
							<td style="width: 70%">
								<span>منصة التعليم</span>
							</td>
							<td style="width: 30%">{{ $sumTeacher }}</td>
						</tr>
						<tr>
							<td style="width: 70%">
								<span>الامتحان</span>
							</td>
							<td style="width: 30%">{{ $sumExam }}</td>
						</tr>
						</tbody>
					</table>

				</div>
			<?php } ?>

        </div>
    </div>

	<?php if($aff==true){ ?>
    @if(!$course->trashed() && $course->active)
        <div class="container text-right rate-section">
            <form method="post" id="form-review" action='{{url(App("urlLang")."courses/save-course-review/".$course->id)}}'>
                {!! csrf_field() !!}
                <input type="hidden" name="currentRating" id="currentRating" value="{{$myrating}}">
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
                                <td><input type="radio" name="value_subject" value="1" {{$mysubject==1?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_subject" value="2" {{$mysubject==2?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_subject" value="3" {{$mysubject==3?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_subject" value="4" {{$mysubject==4?'checked':null}}><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_subject" value="5" {{$mysubject==5?'checked':null}}><span class="opninrt"> </span></td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <span>السعر</span>
                                </td>
                                <td style="width: 5%">:</td>
                                <td><input type="radio" name="value_price" value="1" {{$myprice==1?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_price" value="2" {{$myprice==2?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_price" value="3" {{$myprice==3?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_price" value="4" {{$myprice==4?'checked':null}}><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_price" value="5" {{$myprice==5?'checked':null}}><span class="opninrt"> </span></td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <span>منصة التعليم</span>
                                </td>
                                <td style="width: 5%">:</td>
                                <td><input type="radio" name="value_teacher" value="1" {{$myteacher==1?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_teacher" value="2" {{$myteacher==2?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_teacher" value="3" {{$myteacher==3?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_teacher" value="4" {{$myteacher==4?'checked':null}}><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_teacher" value="5" {{$myteacher==5?'checked':null}}><span class="opninrt"> </span></td>
                            </tr>
                            <tr>
                                <td style="width: 30%">
                                    <span>الامتحان</span>
                                </td>
                                <td style="width: 5%">:</td>
                                <td><input type="radio" name="value_exam" value="1" {{$myexam==1?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_exam" value="2" {{$myexam==2?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_exam" value="3" {{$myexam==3?'checked':null}}><span class="opninrt"> </span></td>
                                <td><input type="radio" name="value_exam" value="4" {{$myexam==4?'checked':null}}><span class="opninrt">  </span></td>
                                <td><input type="radio" name="value_exam" value="5" {{$myexam==5?'checked':null}}><span class="opninrt"> </span></td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                    @if(Auth::check())

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>اكتب تعليقك<em>*</em></label>
                                <textarea name="comment" style="width: 100%;">{{$mycomment}}</textarea>
                            </div>
                        </div>

                        <div class="buttons-set">
                            <button class="submit-rate" title="Submit Review" type="submit">ارسال </button>
                        </div>
                    @else
                        <div class="notes-msg">
                            <p> {{trans('home.you_must_logged_rate')}} <br>
                                <a href="{{url(App('urlLang').'login')}}" class="rev-log">{{trans('home.login_register')}}</a></p>
                        </div>
                    @endif

                </div>
            </form>
        </div>
    @endif
	<?php } ?>


    <div class="container user-add-rate">
        @foreach($course->ratings()->where('course_rating.approved',1)->get() as $rating)
            <div class="card-body row" style="background: rgba(233, 236, 239, 0.5); margin-top: 15px;">
                <div class="col-md-1 body_img">
                    <h5 class="mb-0">
                        <div class=" link_img">
                            @if(!empty($rating->user->image))
                                <img src="{{ asset("uploads/kcfinder/upload/image/users/".$rating->user->image) }}" >
                            @else
                                <img src="{{asset('assets/front/img/user1.jpg')}}" >
                            @endif
                        </div>
                    </h5>
                </div>
                <div class="col-md-11 body_content">
                    <span class="body_content_name">{{(!empty($rating->user))?$rating->user->username:null }}</span>
                    <span class="body_content_date">{{date("Y-m-d",strtotime($rating->created_at))}}</span>
                    <div class="clear"></div>
                    <p>{{$rating->comment}}</p>
                    <table>
                        <tbody>
                         <tr>
                            <th>جودة المادة</th>
                            <td><div class="rate"> {{ $course->rating($rating->value_subject) }} </div></td>
                        </tr>
						<tr>
                            <th>السعر</th>
                            <td><div class="rate"> {{ $course->rating($rating->value_price) }} </div></td>
                        </tr>
                        <tr>
                            <th>منصة التعليم</th>
                            <td><div class="rate"> {{ $course->rating($rating->value_teacher) }} </div></td>
                        </tr>
                       
                        
                        <tr>
                            <th>الامتحان</th>
                            <td><div class="rate"> {{ $course->rating($rating->value_exam) }} </div></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
			@foreach($comment as $comments)
				@if($comments->rating_id == $rating->id)
				<div class="card-body row" style="background: rgba(0, 112, 175, 0.15);">
					<div class="col-md-1 body_img">
						<h5 class="mb-0">
							<div class=" link_img">
								<img src="{{asset('assets/front/img/user1.jpg')}}" >
							</div>
						</h5>
					</div>
					<div class="col-md-11 body_content">
						<span class="body_content_name">أدمين</span>
						<span class="body_content_date">{{date("Y-m-d",strtotime($comments->date_create))}}</span>
						<div class="clear"></div>
						<p>{{$comments->comment}}</p>
					</div>
				</div>
				@endif
				
			@endforeach
            @if(!$loop->last)
                <div class="line_spetare"></div>
            @endif
        @endforeach
    </div>
</div>
<div class="col-md-3 courses_ad">
    <div class="ad">
        {!! $course_trans->ad !!}
    </div>

</div>
