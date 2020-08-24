

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
        {!! $course->description_all_exam !!}
     
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
                    {!! $course->description_quiz	 !!}
				   
				   
				   
                    @if($quizzes->count()>0) 

                        @foreach($quizzes as $quiz)
                            @include("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"])
                        @endforeach
                    @else
                        <p>لا يوجد امتحانات</p>
                    @endif
                    
                    </div>
					

                    <?php
                        $messageValid = "";
                        $validQuiz = $course->validateExam("quiz",$messageValid);
                            
                        $validAttempts = true;
                        $expired = false;
                           
                        $validateExam = $course->validateExam("quiz",$messageValid);
                    ?>

                    @if(isset($course->stage))
                        @if($course->stage->active)

                        <h3 class="form-section "style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100% ; cursor: pointer;" id="div_stage"> <span style="float: left;padding-left:10px;"> + </span> التدريب العملي  </h3>    
                        <div class="content_header_one stage_block" style="display:none">
                        {!! $course->description_stage	!!}
                        
                            @if(!empty($user)) 

                                @if($course->students_stage()->where('user_id',$user->id)->count())

                                    <p class="text-danger"> لقد قمت برفع الملف  </p>

                                    <p class="text-success">{{($course->students_stage()->where('user_id',$user->id)->first()->valider==1)? 'ناجح' : 'إنتظار'}}</p>


                                @endif

            					
                                
                                           
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
                                                                                                            <p> <a href = "{{ url('download_eval_arab') }}"> استمارة التقييم </a>  </p>  
 
                                                    @if($course->is_langue )
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
                            
                        </div>
                        @endif
			  		@endif	  

                    @php 
                        $course_Study_CaseActive=\App\CourseStudyCase::where('course_id',$course->id)->first() ;
                    @endphp


                    @if(isset($course_Study_CaseActive) && $course_Study_CaseActive->active)
                    
                  
                        <h3 class="form-section div_toggle"  id="div_study_case" style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;"><span style="float: left;padding-left:10px;"> + </span> متطلبات الدورة</h3>
                        <div class="content_header_one study_case_block" style="display: none">
                            {!! $course->description_study_party	!!}
                             
                            @if($passed==0)
                           
                                <form method="POST" action="{{route('submit.get.sujet')}}" id="form_get_sujets">
                                    {{ csrf_field() }}
                                  
                                    <input type="hidden" name="sujets_id" value="{{ $sujet->id }}" id="sujets_id">
                                    <input type="hidden" name="courses_id" value="{{ $course->id }}" id="courses_id">

                                    <button class="btn btn-info" type="button" id="submit-sujet">اختار موضوع</button>
                                </form>
                            
                           
                         

                         
                           
                                <div id="form_sujet_upload" style="display: none">
                                    <h5 >الموضوع  : <span id="sujets_description"></span> </h5>
                                     <hr/>
                                    <form action="{{route('post.study.case')}}" method="post" enctype="multipart/form-data" >
                                        {{ csrf_field() }}


                                        <input type="hidden" name="sujets_id" value="{{ $sujet->id }}">
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                         <div class="col-md-2">رفع الملفات من جهازك :</div>
                                        <div class="custom-file col-md-10 " style="float: left">
                                            <label class="custom-file-label" for="customFile">Upload</label>
                                            <input type="file" name="document" class="custom-file-input" id="customFile">
                                            
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="user_message" rows="5" id="comment"></textarea>
                                        </div>

                                        <button class="btn btn-success btn-block" type="submit">Save </button>
                                    </form>                           
                                    
                                </div>
                         
                            @else 

                                <p style="p color: rgb(3, 227, 172);font-size: 20px;float:left">لقد اجتزت الاختبار</p>

                            @endif


                    
                         
                        </div>
                    @endif
                    <!---end study party---->
					

                    @if( $exams->count() > 0 )

                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        				

        				
                            <h3 class="form-section" style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;" id="div_exam_final">الإمتحانات النهائية <span style="float: left;padding-left:10px;"> + </span></h3>
                                <div class="content_header_one exam_final_block" style="display: none">
                                {!! $course->desciption_exam	!!}  
                                
                               
                                @if(!empty($user))
                                    @if($exams->count()>0)
                                                   
                                        @foreach($exams as $exam)

                                            @include("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"])

                                        @endforeach
                                                   
                                    @else
                                        <p>لا يوجد امتحانات</p> 
                                    @endif 
                                @endif
                                
                               
                              
                            </div>
                    @endif   


                    @if($videoExams->count()>0) 
                        <h3 class="form-section"  style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;" id="div_video"><span style="float: left;padding-left:10px;"> + </span>إمتحانات الفيديو</h3>
                        <div class="content_header_one video_block" style="display: none ">
                        {!! $course->description_exam_video !!}
                       
                            @foreach($videoExams as $videoExam)
                                @include("front.courses.course._exam_row",["quiz"=>$videoExam,"type"=>"video"])
                            @endforeach

                        </div>
                    @endif 

                </div> 

            </div>
        </div>
    </div>

</div>

