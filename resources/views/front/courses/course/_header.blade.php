@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $align = session()->get('locale') === "ar" ? "right" : "left" @endphp

<div class="training_purchasing">
    <div class="container training_container">
        <div class="media" style="direction: {{ $dir }}; text-align: {{ $align }}">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <img class="align-self-center mr-3" src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}"
                     alt="{{ $course_trans->name }}">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <div class="media-body align-self-center">
                    {{ $course_trans->name }} - {{ trans('home.'.$courseType->type) }}
                    <?php
                        $now = date("Y-m-d");
                        if($courseType->type=="online")
                            $courseType_variations = $courseType->couseType_variations;
                        else
                            $courseType_variations = $courseType->couseType_variations()
                                ->where('coursetype_variations.date_to', '>=', $now)->get();
                    ?>
                    @foreach($courseType_variations as $courseTypeVariation)
                        <p class="teachernm">@lang('navbar.coach')  : <span> 
                             {{ $courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')} }}</span>
                       
                            
                        @if(!empty($courseTypeVariation->government))
                            <span>{{ $courseTypeVariation->government->government_trans(session()->get('locale'))->name or null }}</span>
                            <span>{{ $courseTypeVariation->date_from ." - ".$courseTypeVariation->date_to }}</span>
                        @endif
                            <!-- <span>ﺷﻬﺎﺩﺓ :</span>
                            @if(!empty($courseTypeVariation->certificate))
                                <span>ﻧﻌﻢ</span>
                            @else
                                <span>ﻻ</span>
                            @endif -->
                        </p>
                    @endforeach
                    @if(Auth::check())
                        <?php
                        $certificateCount = \App\StudentCertificate::where("student_id",Auth::user()->id)
                            ->where("course_id",$course->id)->count();
                        ?>

                        @if($certificateCount>0)
                            @if(in_array($course->id, [496, 502]))
                            @else
                                <div class="alert alert-success alertweb"><i class="fa fa-exclamation-circle"></i>
                                    <strong> @lang('navbar.sucessCertification')</strong>
                                    <br> @lang('navbar.visitYourCertification') <a href="{{ url(App('urlLang').'account') }}"> @lang('navbar.account')</a>
                                </div>
                            @endif
                        @endif
                    @endif
                    {{-- categorie el tatwir el mehni el mostamar --}}
                    @if($course->categories()->exists())
                    @if($course->categories->first()->id ==  5)
                      @if(!$user)
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            @if($course->id == 505)
                                
                                <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                    {{-- @if($errors->any())
                                    <h4>{{$errors->first()}}</h4>
                                    @endif --}}
                                    <label>أرفق وثائق إثبات الخبرة </label> <br> <br>
                                    {{-- <input type='file' name='url_certif' id='url_certif' multiple required="" /> --}}
                                    <input type="file" name="url_certif"  required> <br> <br>
                                    <button  onclick="location.href='{{ url(App('urlLang').'account') }}'">  تأكيد    </button>
                                </div>
                            
                            @else 
                                <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                    {{-- @if($errors->any())
                                    <h4>{{$errors->first()}}</h4>
                                    @endif --}}
                                    <strong> ﻟﻠﺘﺴﺠﻴﻞ ﻓﻲ ﻫﺬﻩ اﻟﺪﻭﺭﺓ ﻳﺠﺐ عليك ادخال الرقم التسلسلي لشهادتك :  </strong><br> <br> 
                                    <input name="serial_number" required><br> <br>
                                    <button  onclick="location.href='{{ url(App('urlLang').'account') }}'">  تأكيد    </button> 
                                </div>
                            @endif    
                        
                      @else
                        @if(!$user->user_verify()->exists())
                        <form method="post"  action='{{url(App("urlLang")."addVerify",[$user->id, $course->id])}}' accept-charset="utf-8" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                @if($course->id == 505)
                                    
                                    <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                        {{-- @if($errors->any())
                                        <h4>{{$errors->first()}}</h4>
                                        @endif --}}
                                        <label>أرفق وثائق إثبات الخبرة </label> <br> <br>
                                        {{-- <input type='file' name='url_certif' id='url_certif' multiple required="" /> --}}
                                        <input type="file" name="url_certif"  required> <br> <br>
                                        <button type="submit">  تأكيد    </button>
                                    </div>
                                
                                @else 
                                    <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                        {{-- @if($errors->any())
                                        <h4>{{$errors->first()}}</h4>
                                        @endif --}}
                                        <strong> ﻟﻠﺘﺴﺠﻴﻞ ﻓﻲ ﻫﺬﻩ اﻟﺪﻭﺭﺓ ﻳﺠﺐ عليك ادخال الرقم التسلسلي لشهادتك :  </strong><br> <br> 
                                        <input name="serial_number" required><br> <br>
                                        <button type="submit">  تأكيد    </button> 
                                    </div>
                                @endif   
                            </form>
                        @else 
                           @if($user->user_verify->course_id == 505)
                                @if($user->user_verify->verify == 0)
                                    {{-- <form action="{{ url(App('urlLang').'addVerify/'.$user->id . '/'. $course->id) }}"  enctype='multipart/form-data'> --}}

                                    <form method="post"  action='{{url(App("urlLang")."addVerify",[$user->id, $course->id])}}' accept-charset="utf-8" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                            {{-- @if($errors->any())
                                            <h4>{{$errors->first()}}</h4> 
                                            @endif --}}
                                           
                                            <label>لقد تم تحميل الوثيقة بنجاح سيتم إرسال التأكيد عبر الميل</label> <br> <br>
                                            {{-- <input type='file' name='url_certif' id='url_certif' multiple required="" /> --}}
                                            <input type="file" name="url_certif"  required > <br> <br>
                                            <button type="submit">  تأكيد    </button>
                                        </div> 
                                    </form>  
                                @endif
                               
                            @else
                              @if($course->id ==  505)
                              <form method="post"  action='{{url(App("urlLang")."addVerify",[$user->id, $course->id])}}' accept-charset="utf-8" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                                        <label>أرفق وثائق إثبات الخبرة  partie 3</label> <br> <br>
                                        <input type="file" name="url_certif" required> <br> <br>
                                        <button type="submit">  تأكيد    </button>
                                    </div>
                                </form>
                              @endif 
                            @endif

                        @endif
                      @endif  
                    @endif
                    @endif
                    {{-- end categorie tatwir --}}
                    @if((!is_null($course->parent_course)&&!($course->isRegisteredParent()&&$course->isSuccessParent()))&&!$course->isRegistered())
                        <?php
                        $parent_courseType = $course->parent_course->courseTypes()->first();
                        $parentCourse = $course->parent_course;
                        $parentCourse_trans = $parentCourse->course_trans(session()->get('locale'));
                        if(empty($parentCourse_trans))
                            $parentCourse_trans = $parentCourse->course_trans("en");
                        ?>
                        <div class="alert alert-warning alertweb"><i class="fa fa-exclamation-circle"></i>
                            <strong> @lang('navbar.toRegisterYouhaveTo') :  </strong>
                            <br> <a href="{{ url(App('urlLang').'courses/'.$parent_courseType->id) }}">{{ $parentCourse_trans->name }}</a>
                            @if($course->needsExperience == true)
                            <br>
                            @lang('navbar.or')
                            <br>
                            <a href="#" id="needsExperienceBTN" data-toggle="collapse" data-target="#change-search"> @lang('navbar.confirmYourExperiance')   </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

              <!----code edit ticket ta3dil chera --->
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="meta-price media-body align-self-center">
                    @if($courseType->points >0)
                        <span class="points-on-course"><span><i class="fa fa-gift"></i> {{ $courseType->points }}  @lang('navbar.poitGratuitParSession')</span>
						   <i class="repls">@lang('navbar.changePointToHaveDiscount')</i>
						   <a href="{{ url(App('urlLang').'pages/points-program') }}" target="_blank">@lang('navbar.discoverOurPointsystem')</a>
						</span>
					@endif
                    <?php
                        $first_Variation = $courseType->couseType_variations()->orderBy("price","asc")->first();
                        $setting = App('setting');
                        $vat = $setting->vat*$first_Variation->price/100;
                        $vat2 = $setting->vat*$first_Variation->pricesale/100;
                           

                    ?>
{{-- start  new code 
                    @if((is_null($course->parent_course)||($course->isRegisteredParent()&&$course->isSuccessParent()))&&!$course->isRegistered())

                        <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  {{ floor($first_Variation->price+$vat) }}$ </span></button>
                    @else
                        <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                    @endif --}}
                    {{-- if active  --}}
                    @if($course->active == 0)
                     <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                    @else
                    @if((is_null($course->parent_course)||($course->isRegisteredParent()&&$course->isSuccessParent()))&&!$course->isRegistered())

                        @if($courseType->id == 296)  
                            @if($course->isPayCourse())  
                                <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  {{ floor(($first_Variation->price+$vat)/2) }}$ </span></button>
                            @else
                                @if($course->isPayCourseLevel2()) 
                                <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  {{ floor(($first_Variation->price+$vat)/2) }}$ </span></button>
                                @else
                                    @if($course->isPayPackThree())  
                                    <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  {{ floor(($first_Variation->price+$vat)/2) }}$ </span></button>
                                    @else
                                    <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  {{ floor($first_Variation->price+$vat) }}$ </span></button>
                                    @endif
                                @endif
                            @endif
                        @else
                            @if($course->categories->first()->id ==  5)
                              @if(!$user)
                              <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                              @else
                                @if($user->user_verify()->exists())
                                  @if($user->user_verify->course_id == 505)

                                    @if($user->user_verify->verify == 1)
                                      <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  {{ floor($first_Variation->price+$vat) }}$ </span></button>        
                                  
                                      @else 
                                      <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                                    @endif

                                  @else
                                        @if($course->id ==  505)  
                                            <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                                        @endif

                                    {{-- @if($user->user_verify->verify == 1)
                                    <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">  {{ floor($first_Variation->price+$vat) }}$ </span></button>        
                                    @else 
                                    <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                                    @endif --}}
                                  @endif



                                @else
                                <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                                @endif
                              @endif
                            @else
                            {{-- <form id="cart-form" class="search_form incourse" method="post" action="{{ url(App('urlLang').'cart/add-to-cart') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <p class="price btnadd">
                            <button type="submit" class="btn btn-primary  btn-md"> <span style="margin-right: 10px;">   @lang('navbar.buy') {{ floor($first_Variation->price+$vat) }}$ </span> </button>
                            <input type="hidden" value="1" name="quantity" class="form-control select_form">
                        <input type = "hidden" value= {{ $courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')}  }} name="coursetypevariation_id">

                        </p> --}}
                            {{-- </form> --}}
                            <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;"> {{ floor($first_Variation->price+$vat) }}$ </span></button>        
                            @endif
                        @endif


                    @else
                    <!----------if course  paid ------>
                    <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
                    @endif
                    @endif
                {{-- end add new code system --}}
                </div>
            </div>
        </div>
        <div id="change-search" class="collapse" aria-expanded="false" style="">
            <div class="ccontrn">
                <div class="change-search-wrapper">

                    <div class="row gap-20">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="row gap-0">

                                <div class="col-xs-12 col-sm-12 col-md-12 groups-box">
                                    <div class="gbox">
                                        
                                        @if($courseType->type=="online")
                                          {{-- <p>@lang('navbar.specialDiscount')</p>
                                          <p>@lang('navbar.registerWithFreinds')</p>
                                          <p>@lang('navbar.aftersucessPayement')</p> --}}
                                  @else
                                          {{-- <p>@lang('navbar.specialDiscount')</p>
                                          <p>@lang('navbar.registerWithFreinds')</p>
                                          <p>@lang('navbar.aftersucessPayement')</p>
                                          <p>@lang('navbar.chooseCoachanCity')</p> --}}
                                  @endif
                                      
                                        <form id="cart-form" class="search_form incourse" method="post" action="{{ url(App('urlLang').'cart/add-to-cart') }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group select_group">
                                                <input type ="hidden" name="quantity" value="1">
                                                {{-- <select name="quantity" class="form-control select_form">
                                                    <option value="" > @lang('navbar.chooseNumberStudent')</option>
                                                    @foreach(\App\Course::numStudents() as $stdnum) --}}
                                                        
                                                            {{-- <php>$discount = $courseType->getDiscount($stdnum); --}}
                                                    
                                                       
                                                        {{-- <option value="{{ $stdnum }}" data-discount="{{ $discount }}" @if ($stdnum == '1'){{'selected="selected"'}}@endif >
                                                            {{ $stdnum }} <span class="mrgmrg">@lang('navbar.student')</span>
                                                            <span>{{ $discount }}%<b class="mrgmrg">@lang('navbar.disscount')</b></span>
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                            </div>
                                            
                                            <div class="form-group select_group">
                                                @if($courseType->type=="online")
                                                {{-- <label>@lang('navbar.choosecoachandDate')</label> --}}
                                                <div class="radio-list">
                                                    @foreach($courseType->couseType_variations as $courseTypeVariation)
                                                    <label>
                                                        <input type="hidden" class="select_form" name="coursetypevariation_id" value="{{ $courseTypeVariation->id }}" data-price="{{$courseTypeVariation->price }}" checked="checked" >
                                                        {{-- <span>@lang('navbar.coach') : </span><span>{{ $courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')} }}</span> --}}
                                                        @if($courseType->type!="online")
                                                            {{-- <span>( {{ $courseTypeVariation->government->government_trans(session()->get('locale'))->name or null }}</span>
                                                            <span>{{ trans('home.start_at') }}</span><span>{{ $courseTypeVariation->date_from }}<span>@lang('navbar.until')</span>{{ $courseTypeVariation->date_to }} )</span> --}}
                                                        @endif

                                                        {{-- start new code  <span>{{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$</span>  --}}
                                                         @if($courseType->id == 296)  
                                                            @if($course->isPayCourse())                                                      
                                                                <span>{{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$</span>
                                                            @else
                                                                @if($course->isPayCourseLevel2()) 
                                                                    <span>{{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$</span>
                                                                @else
                                                                    @if($course->isPayPackThree())  
                                                                        <span>{{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$</span>
                                                                    @else
                                                                     <span>{{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$</span>  
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @else
                                                           {{-- <span>{{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$</span>  --}}
                                                        @endif
                                                        {{-- end new code  --}}
                                                    </label>
                                                    
                                                    @endforeach
                                                </div>
                                                   <!--  <label>اﺧﺘﺮ اﻟﻤﺪﺭﺏ</label> -->
                                                @else
                                                    <label>@lang('navbar.choosecoachandDate')</label>
                                                <div class="radio-list">
                                                    @foreach($courseType->couseType_variations as $courseTypeVariation)
                                                    <label>
                                                        <input type="radio" class="select_form" name="coursetypevariation_id" value="{{ $courseTypeVariation->id }}" data-price="{{ $courseTypeVariation->price }}" checked="checked" >
                                                        <span>@lang('navbar.coach') : </span><span>{{ $courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')} }}</span>
                                                        @if($courseType->type!="online")
                                                            <span>( {{ $courseTypeVariation->government->government_trans(session()->get('locale'))->name or null }}</span>
                                                            <span>{{ trans('home.start_at') }}</span><span>{{ $courseTypeVariation->date_from }}<span>@lang('navbar.until')</span>{{ $courseTypeVariation->date_to }} )</span>
                                                        @endif


                                                         {{-- start new code <span>{{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$</span>  --}}
                                                     @if($courseType->id == 296)  
                                                         @if($course->isPayCourse())                                                    
                                                          <span>{{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$</span>
                                                         @else
                                                             @if($course->isPayCourseLevel2())                                                    
                                                             <span>{{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$</span>
                                                             @else
                                                                @if($course->isPayPackThree()) 
                                                                    <span>{{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$</span>
                                                                @else
                                                                    <span>{{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$</span>  
                                                                @endif
                                                             @endif
                                                         @endif
                                                     @else
                                                      <span>{{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$</span> 
                                                     @endif
                                               {{-- end new code  --}}
                                                    </label>
                                                    
                                                    @endforeach
                                                </div>
                                                @endif
                                          
                                            </div>
                                            <!--div class="form-group select_group">
                                                <select name="date" class="form-control select_form">
                                                    <option value="" selected>اﺧﺘﺮ ﺗﺎﺭﻳﺦ اﻟﺪﻭﺭﺓ</option>
													@foreach($courseType->couseType_variations as $courseTypeVariation)
														<option value="">{{$courseTypeVariation->date_from}}</option>
													@endforeach 
                                                </select>
                                            </div-->
                                            @if( !$course->isSuccessParent() && $course->needsExperience == true)
                                                <div class="form-group" id="experience_files_group" >
                                                    <label>@lang('navbar.uploadExpirianceDocument')</label>
                                                    <input type='file' name='experience_files[]' id='experience_files' multiple required="" />
                                                </div>
                                            @endif


                                            @if($courseType->id == 296)  
                                                @if($course->isPayCourse())
                                                
                                                <div class="form-group" id="certif_file_296" > 
                                                    <label>أرفق الشهادة</label>
                                                    <input type='file' name='certif_file_296' id='certif_file_296' />
                                                </div>
                                                @else
                                                    @if($course->isPayCourseLevel2()) 
                                                    <div class="form-group" id="certif_file_296" >
                                                        <label>أرفق الشهادة</label>
                                                        <input type='file' name='certif_file_296' id='certif_file_296' />
                                                    </div>
                                                    @else
                                                        @if($course->isPayPackThree())   
                                                        <div class="form-group" id="certif_file_296" >
                                                            <label>أرفق الشهادة</label>
                                                            <input type='file' name='certif_file_296' id='certif_file_296' />
                                                        </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif


                                            <p class="price btnadd">
                                                <button type="submit" class="btn btn-primary  btn-md"> @lang('navbar.buy')<span id="ttlprc"></span>
                                                    {{-- <span class="ttl-stdn">@lang('navbar.for') :  --}}
                                                        <b><span id="quantity_span">
                                                            {{-- {{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$ --}}
                                                        
                                                            @if($courseType->id == 296)  
                                                                @if($course->isPayCourse())
                                                                  {{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$
                                                                @else
                                                                    @if($course->isPayCourseLevel2())  
                                                                     {{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$
                                                                     @else
                                                                        @if($course->isPayPackThree())  
                                                                              {{ floor(($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100)/2) }}$
                                                                         @else
                                                                    {{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$
                                                                         @endif
                                                                    @endif
                                                                @endif
                                                            @else
                                                             {{-- {{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$ --}}
                                                                {{-- @if($stdnum == 5)
                                                                    1
                                                                @else    
                                                                    {{ $stdnum }}
                                                                @endif --}}
                                                                {{ floor($courseTypeVariation->price+App('setting')->vat*$courseTypeVariation->price/100) }}$

                                                            @endif
                                                        </span> 
                                            {{-- {{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$ --}}
                                                      {{-- @lang('navbar.students')</b></span></button> --}}
                                            </p> 

                                         

                                        </form>

                                    </div>


                                </div>

                            </div>

                        </div>



                    </div>

                </div></div>
        </div><!--g-->
    </div>
</div>