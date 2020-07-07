<div class="col-lg-12 course_curriculum_exam courses_more_info_content">
    <div class="content_header_one">
        <p>الامتحانات</p>
        {!! $course->description_all_exam !!}
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
                    {!! $course->description_quiz	 !!}
                    </div>

                    @if($quizzes->count()>0) 
                        @if(in_array($courseType->id, [292, 298, 328])) 
                            @if($user)    
                                @if(!$user->user_lang()->exists())
                                <div> اختر لغة الدراسة  في المنهج الدراسي </div>
                                @else
                                @if($user->user_lang->lang_stud == "fr" )
                                        @foreach($quizzesTestFr as $quiz)
                                            @include("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"])
                                        @endforeach
                                    @else
                                        @foreach($quizzesTest as $quiz)
                                            @include("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"])  
                                        @endforeach
                                    @endif

                                @endif
                            @endif
                    @else
                        @foreach($quizzes as $quiz)
                            @include("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"])
                        @endforeach
                    @endif
                    @else
                        <p>لا يوجد امتحانات</p>
                    @endif

                    {{-- course liya9a badania , id 54 328 --}}

                    @if(in_array($courseType->id, [54, 328]))

                        <h3 class="form-section">الإختبار النهائي النظري</h3>
                        <div class="content_header_one">
                        {!! $course->desciption_exam	!!}
                        </div>
                        @if($courseType->id == 328)
                            @if(!empty($user))
                                @if($examsTest->count()>0)
                                        @if(!$user->user_lang()->exists()) 
                                        <div> اختر لغة الدراسة  في المنهج الدراسي </div>
                                        @else
                                            @foreach($examsTest as $exam)

                                                @include("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"])

                                            @endforeach
                                        @endif
                                @else
                                    <p>لا يوجد امتحانات</p> 
                                @endif 
                           @endif 

                        @else
                            @if($exams->count()>0)
                                @foreach($exams as $exam)

                                    @include("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"])

                                @endforeach 
                            @else
                                <p>لا يوجد امتحانات</p> 
                            @endif
                    @endif 
 
                        
                        {{-- stage id 54 328 --}}
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
                        {!! $course->description_stage	!!}
                        </div>
                        @if(!empty($user)) 
                            @if($validateExam)
                           
                        <form method="post"  action='{{url(App("urlLang")."postAddStage",[$courseType->course->id, $user->id])}}' accept-charset="utf-8" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                @if($courseType->id == 328)
                                    @if($user->user_lang()->exists())
                                        @if($user->user_lang->lang_stud == "fr" )
                                            <p> <a href = "{{route('downloadStage')}}"> استمارة مطلب التربص </a>  </p>
                                        @else
                                            <p> <a href = "{{route('downloadDemandeStageArab')}}"> استمارة مطلب التربص </a>  </p>
                                        @endif
                                    @endif
                                @else
                                 <p> <a href = "{{route('downloadDemandeStageArab')}}"> استمارة مطلب التربص </a>  </p>
                                @endif
                            </div>
                
                            <div class="col-2 curriculum_exam_question_number">
                                @if(!empty($user))   
                                <?php
                                    $messageValid = "";                               
                                    $validQuiz = $course->validateQuiz("stage", $messageValid);
                                    $validAttempts = true;
                                    $expired = false;                               
                                ?>
            
                                    <input type="file" name="demande_stage" >
                                @endif 
                             </div>
                            <div class="col-3 curriculum_exam_watch">
                            
                            </div>  
                        </div>   
                        <div class="row">
                            <div class="col-1 curriculum_exam_type">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                            
                            <div class="col-6 curriculum_exam_title">   
                                @if($courseType->id == 328)
                                    @if($user->user_lang()->exists())
                                        @if($user->user_lang->lang_stud == "fr" )
                                        <p> <a href = "{{ url('download_eval') }}"> استمارة التقييم </a>  </p>  
                                        @else
                                        <p> <a href = "{{ url('download_eval_arab') }}"> استمارة التقييم </a>  </p>  
                                        @endif
                                    @endif
                                @else
                                 <p> <a href = "{{ url('download_eval_arab') }}"> استمارة التقييم </a>  </p>  
                                @endif
                            </div>


    
                            <div class="col-2 curriculum_exam_question_number">
                                 @if(!empty($user))
                                <?php
                                    $messageValid = "";
                                    //print_r($course);
                                    $validQuiz = $course->validateQuiz("stage", $messageValid);
                                    $validAttempts = true;
                                    $expired = false;
                                    
                                ?>
     
                                            <input type="file" name="evaluation_stage" >   
    
    
                            @endif 
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
                    {{-- valide exam --}}
                    @else
                    {!! $messageValid !!}
                     @endif
                    {{-- attempt --}}
                    @else
                    <div class="row">
                    <div class="col-1 curriculum_exam_type">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                    <div class="col-6 curriculum_exam_title">
                    <a href="{{ url(App('urlLang').'login') }}">سجل الدخول</a>
                    </div>
                    </div>
                    @endif
                        {{-- end stage --}}
                {{-- exam vdo id 328 54  , 17--}}

                        <h3 class="form-section">إمتحانات الفيديو</h3>
                        <div class="content_header_one">
                        {!! $course->description_exam_video	!!}
                        </div>
                        @if($videoExams->count()>0) 
                            @foreach($videoExams as $videoExam)
                                @include("front.courses.course._exam_row",["quiz"=>$videoExam,"type"=>"video"])
                            @endforeach
                        @else
                            <p>لا يوجد امتحانات</p>
                        @endif 
                    @else                
                   


                    <h3 class="form-section">إمتحانات الفيديو</h3>
                    <div class="content_header_one">
                    {!! $course->description_exam_video	!!}
                    </div>
                    @if($videoExams->count()>0) 
                        @foreach($videoExams as $videoExam)
                            @include("front.courses.course._exam_row",["quiz"=>$videoExam,"type"=>"video"])
                        @endforeach
                    @else
                        <p>لا يوجد امتحانات</p>
                    @endif 



                    @if(in_array($courseType->id, [292, 298])) 

                 
                    <h3 class="form-section"> التدريب العملي </h3>  
                    <div class="content_header_one">
                    {!! $course->description_stage	!!}  
                    </div>
                    @if(!empty($user))
                    <form method="post"  action='{{url(App("urlLang")."postAddStage",[$courseType->course->id, $user->id])}}' accept-charset="utf-8" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if($user->user_lang()->exists())
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
  
                            @if($user->user_lang->lang_stud == "fr" )
                                <p> <a href = "{{route('downloadStage')}}"> استمارة مطلب التربص </a>  </p>
                            @else
                                <p> <a href = "{{route('downloadDemandeStageArab')}}"> استمارة مطلب التربص </a>  </p>
                            @endif
                        </div>
                        <div class="col-2 curriculum_exam_question_number">
                            @if(!empty($user)) 
                            <?php
                                $messageValid = "";                               
                                $validQuiz = $course->validateQuiz("stage", $messageValid);
                                $validAttempts = true;
                                $expired = false;                               
                            ?>
                                @if($validAttempts)
                                    @if(!$expired)
                                        @if($validQuiz)
                                            <input type="file" name="demande_stage" >
                                        @endif
                                    @endif
                                @endif
                            @endif 
                         </div>
                        <div class="col-3 curriculum_exam_watch">
                        
                        </div>  
                    </div>
                

                    <div class="row">
                        <div class="col-1 curriculum_exam_type">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </div>

                        <div class="col-6 curriculum_exam_title">   
                            {{-- {{ url('downloadEval/'.$user->id) }} --}}

                            @if($user->user_lang->lang_stud == "fr" )
                            <p> <a href = "{{ url('download_eval') }}"> استمارة التقييم </a>  </p>  
                            @else
                            <p> <a href = "{{ url('download_eval_arab') }}"> استمارة التقييم </a>  </p>  
                            @endif
                        </div>

                        <div class="col-2 curriculum_exam_question_number">
                             @if(!empty($user))
                            <?php
                                $messageValid = "";
                                //print_r($course);
                                $validQuiz = $course->validateQuiz("stage", $messageValid);
                                $validAttempts = true;
                                $expired = false;
                                
                            ?>
 
                            @if($validAttempts)
                                @if(!$expired)
                                    @if($validQuiz)

                                        <input type="file" name="evaluation_stage" >


                                    @endif
                                @endif
                            @endif


                        @endif 
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
                     @else 
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
                   @endif
                </form>
                @endif
                @endif
                    @if(in_array($courseType->id, [54, 328]))
                    @else

                    <h3 class="form-section">الإمتحانات النهائية</h3>
                    <div class="content_header_one">
                    {!! $course->desciption_exam	!!}  
                    </div>
                    @if(in_array($courseType->id, [292, 298, 328])) 
                        @if(!empty($user))
                            @if($examsTest->count()>0)
                                @if(!$user->user_lang()->exists()) 
                                <div> اختر لغة الدراسة  في المنهج الدراسي </div>
                                @else
                                    @foreach($examsTest as $exam)

                                        @include("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"])

                                    @endforeach
                                @endif
                            @else
                                <p>لا يوجد امتحانات</p> 
                            @endif 
                        @endif
                    
                    @else
                        @if($exams->count()>0)
                            @foreach($exams as $exam)

                                @include("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"])

                            @endforeach
                        @else
                            <p>لا يوجد امتحانات</p>
                        @endif 
                    @endif
                   @endif
                   {{-- end if course_id = 54 328  --}}
                @endif


                </div> 

            </div>
        </div>
    </div>

</div>