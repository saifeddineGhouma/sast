

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
				@if(Lang::locale()=="en")
                    <style type="text/css">
			   h3{
				   text-align:left;
				   padding-left:15px;
				   
			   }
			   h3 span{
				   float:right
			   }
			  
			   
</style>       

				@else
                   <style type="text/css">
			  
			   h3 span{
				   float:left
			   }
</style>       

                @endif
               

<div class="col-lg-12 course_curriculum_exam courses_more_info_content">
    <div class="content_header_one">
        <p>
		@lang('navbar.exams') 
		</p>
		@if(Lang::locale()=="en")
                     {!! $course->description_all_exam_en !!} 

                    @else
                    {!! $course->description_all_exam !!} 

                    @endif
        @if(Session::has('message'))
            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
            <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <script>
                toastr.success("{{ Session::get('message') }}");
                swal({
                  title: "{{ Session::get('message') }}",
                  text: "",
                  icon: "success",
                  button: "Ok",
                });
            </script>
          
        @endif
		
     
    </div>
    <div id="accordion">
        <div class="card curriculum_exam_card card_deactive">
            <div class="card-header" id="headingTen">
                <h5 class="mb-0">
                    <p class=" btn-link ">
                        @lang('navbar.header_exams')
                </h5>
            </div>
            <div>
                <div class="card-body">
                  
                        
               @if( $quizzes->count()>0)
                    <h3 class="form-section"  style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100% ; cursor: pointer;" id="div_quiz"> <span style="padding-left:10px;"> + </span>@lang('navbar.quizs')</h3> 
                    <div class="content_header_one quiz_block" style="display: none">
					 @if(Lang::locale()=="en")
                     {!! $course->description_quiz_en    !!}

                    @else
                    {!! $course->description_quiz    !!}

                    @endif
                   
                   
                   
                    @if($quizzes->count()>0) 

                        @foreach($quizzes as $quiz)
                            @include("front.courses.course._exam_row",["quiz"=>$quiz,"type"=>"quiz"])
                        @endforeach
                    @else
                        <p>@lang('navbar.no_exam')</p>
                    @endif
                    
                    </div>
                    

                    <?php
                        $messageValid = "";
                        $validQuiz = $course->validateExam("quiz",$messageValid);
                            
                        $validAttempts = true;
                        $expired = false;
                           
                        $validateExam = $course->validateExam("quiz",$messageValid);
                    ?>
                    
                 @endif
                    
                    @if(isset($course->stage))
                        
                        @if($course->stage->active)

                        <h3 class="form-section "style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100% ; cursor: pointer;" id="div_stage"> <span style="padding-left:10px;"> + </span> @lang('navbar.pratical_training')  </h3>    
                        <div class="content_header_one stage_block" style="display:none">
                        @if(Lang::locale()=="en")
                                 {!! $course->description_stage_en  !!}

                                @else
                                {!! $course->description_stage  !!}

                               @endif
                        
                            @if(!empty($user)) 
								
							@if($course->isRegistered())
								
								
							   
								

                                @if($course->students_stage()->where('user_id',$user->id)->count())

                                    <p class="text-danger"> لقد قمت برفع الملف  </p>

                                    <p class="text-success">{{($course->students_stage()->where('user_id',$user->id)->first()->valider==1)? 'ناجح' : 'إنتظار'}}</p>
                                    <ul class="list-group" style="width: 500px;margin:auto;">
                                        @foreach($user->user_stage()->where('course_id',$course->id)->get() as $stage)
                                      <li class="list-group-item"> التقرير<span style="float: left" onclick="return confirm('Are you sure you want to delete this file?');"><a href="{{route('delete.stage',$stage->id)}}"><i class="fa fa-trash"></i></a></span>

                                      </li>
                                       @endforeach
                                     
                                    </ul>

                                   @else


                                   <form method="post"  action='{{url(App("urlLang")."postAddStage",[$courseType->course->id, $user->id])}}' accept-charset="utf-8" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row">
                                            <div class="col-1 curriculum_exam_type">                                    
                                            </div>
                                            <div class="col-6 curriculum_exam_title">
                                                @lang('navbar.download_file')

                                            </div>
                                            <div class="col-2 curriculum_exam_question_number">
                                                @lang('navbar.upload_from_pc')
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
                                                      @if($course->is_lang)
                                                        
                                                        @if($user->user_lang()->exists())
                                                            @if($user->user_lang->lang_stud == "Fr" )
                                                                <p> <a href = "{{route('downloadStage')}}"> @lang('navbar.Training_application_form') </a>  </p>
                                                            @else
                                                                <p> <a href = "{{route('downloadDemandeStageArab')}}"> @lang('navbar.Training_application_form') </a>  </p>
                                                            @endif
                                                          @endif
                                                        @else
                                                       <p> <a href = "{{route('downloadDemandeStageArab')}}">  @lang('navbar.Training_application_form') </a>  </p>
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
                                                                                                           
 
                                                    @if($course->is_lang )
                                                        @if($user->user_lang()->exists())
                                                            @if($user->user_lang->lang_stud == "Fr" )
                                                            <p> <a href = "{{ url('download_eval') }}"> @lang('navbar.Evaluation_form') </a>  </p>  
                                                            @else
                                                            <p> <a href = "{{ url('download_eval_arab') }}"> @lang('navbar.Evaluation_form') </a>  </p>  
                                                            @endif
                                                        @endif
                                                    @else
                                                     <p> <a href = "{{ url('download_eval_arab') }}"> @lang('navbar.Evaluation_form') </a>  </p>  
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
                                            <button type="submit" class="startquiz"> @lang('navbar.upload_file') </button>         
                                        </div>
                                     </div>
                                </form>






                                @endif
								
							  @else   
								  <p class="failed">@lang('navbar.youarenotstudent')</p>
							  @endif

                                
                                 
                                       

                                    
                             
                               
                                {{-- attempt --}}
                            @else
                                <div class="row">
                                <div class="col-1 curriculum_exam_type">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                                <div class="col-6 curriculum_exam_title">
                                <a href="{{ url(App('urlLang').'login') }}">@lang('navbar.pleaseLogIn')</a>
                                </div>
                                </div>
                            @endif
                            
                        </div>
                        @endif
                    @endif    

                  


                    @if(isset($course->courses_study_case) && $course->courses_study_case->active)
                    
                  
                        <h3 class="form-section div_toggle"  id="div_study_case" style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;"><span style="padding-left:10px;"> + </span> @lang('navbar.scientific_report') </h3>
                        <div class="content_header_one study_case_block" style="display: none ; border: none;">
							  @lang('navbar.header_study_case')
                            

                            @if(!empty($user))
								@if($course->isRegistered())

								   @if($user->lang()=="Fr")
									@include('front.courses.course.study_case.version_fr')

								   @else
								   @include('front.courses.course.study_case.version_ar')

								   @endif
								@else
									<p class="failed">
										@lang('navbar.youarenotstudent')
										</p>
                                @endif                        
                            @else  
                              
                            <p><a href="{{route('login')}}">@lang('navbar.pleaseLogIn')</a></p>


                        @endif
                            

                          


                    
                         
                        </div>
                   
                    <!---end study party---->
                    @endif

                    @if( $exams->count() > 0 )

                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        

                        
                            <h3 class="form-section" style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;" id="div_exam_final">@lang('navbar.final_exams') <span style="padding-left:10px;"> + </span></h3>
                                <div class="content_header_one exam_final_block" style="display: none">
                                 @if(Lang::locale()=="en")
                                     {!! $course->desciption_exam_en    !!}

                                 @else
                                     {!! $course->desciption_exam    !!}

                                 @endif  
								 
                               
                                @if(!empty($user))
                                    @if($exams->count()>0)
                                                   
                                        @foreach($exams as $exam)

                                            @include("front.courses.course._exam_row",["quiz"=>$exam,"type"=>"exam"])

                                        @endforeach
                                                   
                                    @else
                                        <p>@lang('navbar.no_exam')</p> 
                                    @endif 

                                @else 

                                <p><a href="{{route('login')}}">@lang('navbar.pleaseLogIn')</a></p>
                                @endif
                                
                               
                              
                            </div>

                    @else 


                    @endif   


                    @if($videoExams->count()>0) 
                        <h3 class="form-section"  style="line-height:50px;padding-right:15px;background-color: #006aa8 ;color:white; height: 60px; width:100%;cursor: pointer;" id="div_video"><span style="padding-left:10px;"> + </span>@lang('navbar.video_exams')</h3>
                        <div class="content_header_one video_block" style="display: none ">
                        @if(Lang::locale()=="en")
                                     {!! $course->description_exam_video_en !!}

                                 @else
                                     {!! $course->description_exam_video !!}

                                 @endif
                       
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



