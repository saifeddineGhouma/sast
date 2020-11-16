<div class="row">

    <div class="col-1 curriculum_exam_type">

        <i class="fa fa-check" aria-hidden="true"></i>

    </div>

    <div class="col-6 curriculum_exam_title">

    

        @if($type!="video")

            @if($type == "pdf")

               {{-- <p> <a href = "{{url(App('urlLang').'download_stage')}}"> استمارة مطلب التربص </a>  </p>

               <p>  استمارة التقييم</p>   --}}

            @else

            <p>{{ $quiz->quiz_trans(session()->get('locale'))->name or null }}</p>

            @endif

        @else

        

            <p>{{ $quiz->videoexam_trans(session()->get('locale'))->name or null }}</p>

      

        @endif

       

    </div>

    <div class="col-2 curriculum_exam_question_number">

        @if($type!="video")

            @if($type=="pdf")

                {{-- <p> <a href = "{{url(App('urlLang').'download_stage')}}"> استمارة مطلب التربص </a>  <br/>

                استمارة التقييم</p>   --}}

            @else



                <p>{{ $quiz->num_questions }} @lang('navbar.question')</p>

                @if($type=="exam")

                    @lang('navbar.numrepetition')

                    @if(Auth::check())

                        {{ $quiz->students_quizzes()->where("student_id",Auth::user()->id)->count() }} 

                    @else

                        0  

                    @endif 

                @else

            

                @endif

            @endif 

        @endif

    </div>

    <div class="col-3 curriculum_exam_watch">

        @if(!empty($user))

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

            @if($validAttempts) 

                @if(!$expired)

                    @if($validQuiz)

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

                        @if(!empty($student))

                            @if($completedcount>0)

                                @if(!empty($currentQuiz))
                             
                                    <button class="startquiz" data-id="{{ $quiz->id }}" data-type="{{ $type }}">@lang('navbar.completetest')</button>

                                @else

                                    @if(!empty($studentQuiz) || $type!="video")

                                        @if($studentQuizTmp->successfull && $studentQuizTmp->status=="completed")

                                            <p class="success">@lang('navbar.succeded')</p>

                                        @else

                                            <p class="failed">@lang('navbar.notsucceded')</p>

                                        @endif

                                        <a class="startquiz" href="{{ url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuizTmp->id.'&type='.$type) }}">@lang('navbar.showresult')</a>



                                        @if(!(($studentQuizTmp->successfull && $studentQuizTmp->status=="completed")|| $type=="video"))

                                                @if($type!="video" && $quiz->num_questions==0)

                                                    <p>@lang('navbar.noquestionPleaseWait')</p> 

                                                @else

													<button class="startquiz" data-id="{{ $quiz->id }}" data-type="{{ $type }}">@lang('navbar.repassexam')</button>

												

													

                                                @endif

                                        @endif

                                    @else

                                        <p class="processing">@lang('navbar.waitingPreview')

                                        @if(!empty($studentQuizTmp))

                                            @if($type!="video")
                                                <a style="margin-right: 10px;" class="startquiz" href="{{ url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuizTmp->id.'&type='.$type) }}">@lang('navbar.showresult')</a>
                                            @else
                                                <a style="margin-right: 10px;" class="startquiz" href="{{ url(App('urlLang').'courses/quiz-result?studentQuiz_id='.$studentQuizTmp->id.'&type='.$type) }}">   أعد المحاولة   </a>
                                            @endif
                                        @endif

                                        </p> 

                                    @endif

                                @endif

                            @else

                                @if($type!="video"&&$quiz->num_questions==0)

                                    <p>@lang('navbar.noquestionPleaseWait')</p>

                                @else
                                    @if($type=="video" && !$course->isFinishedFinalExam())
                                        <p class="failed">للابد من إتمام إمتحان النظري النهائي   </p>
                                    @else    
                                        <button class="startquiz" data-id="{{ $quiz->id }}" data-type="{{ $type }}">@lang('navbar.starttest')</button>

                                    @endif
                                @endif

                            @endif

                        @endif

                    @else

                        {!! $messageValid !!}

                    @endif

                @else

                        <div class="alert alert-danger">

                         @lang('navbar.timeIsOver')

                            <form id="cart-form" class="search_form incourse" method="post" action="{{ url(App('urlLang').'cart/add-to-cart') }}">

                                {{ csrf_field() }}

                                <input type="hidden" name="quantity" value="1">

                                <input type="hidden" name="course_id" value="{{$course->id}}">

                                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                                <p>

                                    <button type="submit" class="buy_book_now"> @lang('navbar.addToCart')</button>

                                </p>

                            </form>

                        </div>

                @endif

            @else
				@if(!empty($course->gettentative()))
				
					
				@endif

                    <div class="alert alert-danger">

                      @lang('navbar.passedmaxtestpleaseBuy')

                        <form id="cart-form" class="search_form incourse" method="post" action="{{ url(App('urlLang').'cart/add-to-cart') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="quantity" value="1">

                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                            <p>

                                <button type="submit" class="buy_book_now"> @lang('navbar.addToCart')</button>

                            </p>

                        </form>

                    </div>

            @endif

        @else

            <a href="{{ url(App('urlLang').'login') }}">@lang('navbar.pleaseLogIn')</a>

        @endif

    </div>

</div>

