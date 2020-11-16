<?php
	 $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ;
$sumRatings = 0;
if(!is_null($course->ratings()->where("approved",1))){
    $countRatings = $course->ratings()->where("approved",1)->count();
    $sumRatings = $course->ratings()->where("approved",1)
        ->select(DB::raw('sum(value) as sumRating'))->groupBy("course_id")->first();
    if(!empty($sumRatings))
        $sumRatings = $sumRatings->sumRating;
    else
        $sumRatings = 0;
}
?>
<div class="courses_info">
    <div class="row">
        <div class="col-lg-6 video_show">
            <video class="video" id="video1" src="{{ asset('uploads/kcfinder/upload/file/'.$course->video) }}" poster="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" loop>
            </video>
            <div class="video_control_poster">
                <a class="video-control js-video-control paused" href="#" data-video="video1"></a>
            </div>
        </div>
    <div class="col-lg-6 video_info" style="direction: {{ $dir }}">
            <h3>{{ $course_trans->name ." ". trans('home.'.$courseType->type) }}</h3>
            <p>{{ $course_trans->short_description }}</p>

            <div class="rate">
                <span>@lang('navbar.evaluation')   :</span>
                {!! $course->rating(($countRatings!=0)?$sumRatings/$countRatings:0) !!}
                <span>({{ $countRatings }} @lang('navbar.evaluate'))</span>
            </div>
            <div class="row course_rate_info">
                <div class="col-6 rate_align">
                    <div class="rate_info" style="direction: {{ $dir }}; text-align: {{ $textalign }}">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        <p>@lang('navbar.langue') :</p>
                        <span>{{ trans('home.'.$course->language) }}</span>
                    </div>
                    <div class="rate_info" style="direction: {{ $dir }}; text-align: {{ $textalign }}" >
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        <p>@lang('navbar.exams') :</p>
                        <span>{{ $course->courses_quizzes()->where("active",1)->count()+
                         $course->courses_videoexams()->where("active",1)->count()}} @lang('navbar.exams')</span>
                    </div>
                </div>
                <div class="col-6 rate_align">
                    <div class="rate_info" style="direction: {{ $dir }}; text-align: {{ $textalign }}" >
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <p>@lang('navbar.dure') :</p>
                        <span>{{ $course->period }}</span>
                    </div>


                </div>
            </div>
            <!--<div>
                <i class="fa fa-file"></i> 
                <i class="fa fa-video"></i> 
                <i class="fa fa-html5"></i> 
            </div>-->
        </div>
    </div>
</div>
@if(Lang::locale()=="en")
                    <style type="text/css">
								   p,ul>li,ol>li{
									   text-align:left;
									   padding-left:15px;
									   
										direction: ltr;

									   
								   }
								   
								   
								  
								   
					</style>    
@endif					

{!! $course_trans->{'content_'. $courseType->type } !!}
