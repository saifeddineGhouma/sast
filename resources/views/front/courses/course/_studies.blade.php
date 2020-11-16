<style>
p{text-algin:center;}
</style>
    <div class=" course_curriculum courses_more_info_content">
        <div class="content_header_one">
            <p>@lang('navbar.courseWay')</p>
        </div>
        @if(in_array($courseType->id, [292, 298, 328])) 
          @if($user)
            @if(!$user->user_lang()->exists())
                <div> اختر لغة الدراسة </div>
                <form method="POST">
                <div>
                    <a href="{{url('/addStudLang/fr/' . $user->id)}}" onclick="return confirm('هل انت متأكد من لغة الدراسة ؟  لا يمكنك تغيير اللغة الا عن طريق الاتصال بنا ')"> فرنسية </a> 
                    
                    {{-- <a onclick='swal({
                        title: "هل أنت متأكد؟ ",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "نعم",
                        cancelButtonText: "لا",  
                        closeOnConfirm: false,
                        closeOnCancel: true 
                      },
                      function(isConfirm){
                        if (isConfirm) {
                          window.location="{{url('/addStudLang/fr/' . $user->id)}}"
                        }
                      });'class="dropdown-item" rel="tooltip" title="">فرنسية
                    </a> --}}
                </div>

                    {{-- <a href="{{url('/addStudLang/fr/' . $user->id)}}"> فرنسية </a>  --}}
                <div><a href="{{url('/addStudLang/ar/'. $user->id)}}" onclick="return confirm('هل انت متأكد من لغة الدراسة ؟  لا يمكنك تغيير اللغة الا عن طريق الاتصال بنا ')">   عربية </a></div>  
                </form>
            @else 
            <div id="accordion">
                @foreach($course->courseStudies as $courseStudy)
                    <div class="card curriculum_card card_deactive">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_{{ $courseStudy->id }}" aria-expanded="true" aria-controls="collapse_{{$courseStudy->id}}">
                                    <span>{{ $courseStudy->duration }} <sup>@lang('navbar.hours')</sup></span> | <b>{{$loop->iteration }}.</b>{{ $courseStudy->{'name_'.App('lang')} }} {{ $courseStudy->type }}
                                </button>
                            </h5>
                            <span class="showhide">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div id="collapse_{{$courseStudy->id}}" class="collapse" aria-labelledby="heading_{{$courseStudy->id}}" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-1 curriculum_type">
                                        @if( $courseStudy->type == "pdf")
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        @endif
                                        @if( $courseStudy->type == "video")
                                            <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                        @endif
                                        @if( $courseStudy->type == "html")
                                            <i class="fa fa-text-height" aria-hidden="true"></i> 
                                        @endif
                                    </div>
                                    <div class="col-8 curriculum_title">
                                        <p>{{ $courseStudy->{'name_'.App('lang')} }} </p>
                                    </div>
                                    <div class="col-3 curriculum_watch">
                                        @if($courseStudy->only_registered && Auth::guest())
                                            <button onclick="location.href='{{ url(App('urlLang').'login') }}'">للمسجلين فقط</button>
                                        @else
                                            @if($course->isRegistered())
                                                @if($courseStudy->type == "html"||$courseStudy->type == "pdf")
													@if($courseStudy->type == "html")
															<button onclick="location.href='{{ url(App('urlLang').'courses/studies?courseStudy_id='.$courseStudy->id) }}'" target="_blank">مشاهدة</button>
													@elseif($courseStudy->type == "pdf")
														@if($user->user_lang['lang_stud'] == "ar" )
															<button onclick="location.href='{{ url(App('urlLang').'/uploads/kcfinder/upload/file/'. $courseStudy->url ) }}'" target="_blank">مشاهدة</button>
														@else
															<button onclick="location.href='{{ url(App('urlLang').'/uploads/kcfinder/upload/file/new book/FITNESS INSTRUCTOR FR.pdf') }}'" target="_blank">مشاهدة</button>
														@endif 
													@endif
                                                    <a href="https://swedish-academy.se/telecharge.php?pdf={{$courseStudy->url}}" download="{{$courseStudy->url}}" target="_blank" style="float: left;">
                                                        <img src="{{asset('assets/front/img/icon-download.png')}}" /> 
                                                        تحميل
                                                    </a>
                                                @else
                                                    <button href="{{ url(App('urlLang').'uploads/kcfinder/upload/file/'.$courseStudy->url) }}" target="_blank">مشاهدة</button>
                                                @endif
                                            @else
                                                <button onclick="location.href='{{ url(App('urlLang').'login') }}'">للمسجلين فقط</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach  

            </div> 
        
            @endif 
          @endif
        @else
            @if(in_array($courseType->id, [299, 300, 301, 302]))
             <p>   انقر على هذه الصورة اذا اردت شراء احد كتبتنا  </p> <br>
             <a href="{{url(App('urlLang').'books')}}"> @lang('navbar.libraire')  </a>

            @else 
                <div id="accordion">
                    @foreach($course->courseStudies as $courseStudy)
                        <div class="card curriculum_card card_deactive">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_{{ $courseStudy->id }}" aria-expanded="true" aria-controls="collapse_{{$courseStudy->id}}">
                                        <span>{{ $courseStudy->duration }} <sup>@lang('navbar.hours')</sup></span> | <b>{{$loop->iteration }}.</b>{{ $courseStudy->{'name_'.app()->getLocale()} }} {{ $courseStudy->type }}
                                    </button>
                                </h5>
                                <span class="showhide">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div id="collapse_{{$courseStudy->id}}" class="collapse" aria-labelledby="heading_{{$courseStudy->id}}" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-1 curriculum_type">
                                            @if( $courseStudy->type == "pdf")
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            @endif
                                            @if( $courseStudy->type == "video")
                                                <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                            @endif
                                            @if( $courseStudy->type == "html")
                                                <i class="fa fa-text-height" aria-hidden="true"></i> 
                                            @endif
                                        </div>
                                        <div class="col-8 curriculum_title">
                                            <p>{{ $courseStudy->{'name_'.app()->getLocale()} }} </p>
                                        </div>
                                        <div class="col-3 curriculum_watch">
                                            @if($courseStudy->only_registered && Auth::guest())
                                                <button onclick="location.href='{{ url(App('urlLang').'login') }}'">@lang('navbar.pleaseLogIn')</button>
                                            @else
                                                @if($course->isRegistered())
                                                    @if($courseStudy->type == "html"||$courseStudy->type == "pdf")
                                                        @if($courseStudy->type == "html")
                                                            <button onclick="location.href='{{ url(App('urlLang').'courses/studies?courseStudy_id='.$courseStudy->id) }}'" target="_blank">@lang('navbar.view')</button>
                                                    @elseif($courseStudy->type == "pdf")
                                                        
                                                                <button onclick="location.href='{{ url(App('urlLang').'/uploads/kcfinder/upload/file/'. $courseStudy->url ) }}'" target="_blank">@lang('navbar.view')</button>
                                                            {{----}}
                                                            @endif
                                                        <a href="https://swedish-academy.se/telecharge.php?pdf={{$courseStudy->url}}" download="{{$courseStudy->url}}" target="_blank" style="float: left;">
                                                            <img src="{{asset('assets/front/img/icon-download.png')}}" /> 
																@lang('navbar.upload_file')
                                                        </a>
                                                    @else
                                                        <button onclick="location.href='{{ url(App('urlLang').'uploads/kcfinder/upload/file/'.$courseStudy->url) }}'" target="_blank">@lang('navbar.view')</button>
                                                    @endif
                                                @else
                                                    <button onclick="location.href='{{ url(App('urlLang').'login') }}'">@lang('navbar.pleaseLogIn')</button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif
        @endif
    </div>