<?php
$course = $courseType->course;
$course_trans = $course->course_trans(Session::get('locale'));
if(empty($course_trans))
    $course_trans = $course->course_trans('en');

$countRatings = 0;
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

$variationCount = $courseType->couseType_variations()->count();
$first_Variation = $courseType->couseType_variations()->orderBy("price","asc")->first();
$user=null;
if(!empty($first_Variation)){
    $user = $first_Variation->teacher->user;
}
$card = "one";
switch ($loop->index%8){
    case 1;
        $card = "two";
        break;
    case 2;
        $card = "three";
        break;
    case 3;
        $card = "four";
        break;
    case 4;
        $card = "five";
        break;
    case 5;
        $card = "six";
        break;
    case 6;
        $card = "seven";
        break;
    case 7;
        $card = "eight";
        break;
}
?>

@if(!empty($first_Variation))
  
    <div class="col-lg-{{ isset($more) ? 6 : 4 }} col-md-{{ isset($more) ? 6 : 4 }} col-sm-{{ isset($more) ? 6 : 4 }} col-xs-{{ isset($more) ? 6 : 4 }} col-margin zoom">
        
        <div class="card  card_style_{{ $card }}">
            <a href="{{ url(App('urlLang').'courses/'.$courseType->id) }}"><img class="card-img-top" src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" alt="{{ $course_trans->name }}"></a>
             @if($variationCount>1)
                            <sup>تبدأ من</sup>
                        @endif
                        <?php
                            $setting = App('setting');
                            $vat = $setting->vat*$first_Variation->price/100;
                            $vat2 = $setting->vat*$first_Variation->pricesale/100;
                           
                        ?>

                        @if(!empty($first_Variation->pricesale))
                        <div class="ribbon"><span>sale</span></div>
                        <span class="badge badge-pill badge-warning-sale">
                               
                                
                                  <p style="text-decoration: line-through;color:yellow">{{ floor($first_Variation->pricesale+$vat2) }} <b>$</b></p>
                                  {{ floor($first_Variation->price+$vat) }} <b>$</b>
                                
                        </span>
                        @else
                        <span class="badge badge-pill badge-warning">
                            <span>
                            {{ floor($first_Variation->price+$vat) }} <b>$</b><br>
                            {{ $first_Variation->id }}
                            </span>
                        </span>
                        @endif
                  
            <span class="badge badge-pill badge-warning2">{{ trans('home.'.$courseType->type) }}</span>
            <div class="card-body ">
                 <a href="{{ url(App('urlLang').'courses/'.$courseType->id) }}">
                <section class="rate rtgcrc">
                    {!! $course->rating(($countRatings!=0)?$sumRatings/$countRatings:0) !!}

                </section>

                @if(!empty($user))
                    <div class="circle_profile">
                        <img src="{{ asset("uploads/kcfinder/upload/image/users/".$user->image) }}" />
                    </div>

                    <h5 class="card-title">
                        @if(false && $variationCount>1)
                        {{ trans('home.plus_que_coach') }} 
                        @else
                            {{trans('home.coach')}} /
                            @if(Session::get('locale') == "ar")
                                {{ $user->full_name_ar }}
                            @else
                                {{ $user->full_name_en }}
                            @endif
                        @endif 
                      </h5>
                @endif
                <p class="card-text"><a href="{{ url(App('urlLang').'courses/'.$courseType->id) }}">{{ $course_trans->name }}</a></p>

                <div class="more_info">
                    @if($courseType->type=="presence")
                        @if($variationCount<=1)
                            <div class="row">
                                <div class="col">
                                    <i class="fa fa-calendar-alt"></i>
                                    <p>{{ $first_Variation->date_from }}</p>
                                </div>
                                <div class="col">
                                    <i class="fa fa-map-marker-alt"></i>
                                    @if(!empty($first_Variation->government))
                                        <p>{{ $first_Variation->government->government_trans(Session::get('locale'))->name or $first_Variation->government->government_trans("en")->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            @foreach($courseType->couseType_variations as $couseType_variation1)
                                <div class="row">
                                    <div class="col">
                                        <i class="fa fa-calendar-alt"></i>
                                        <p>{{ $couseType_variation1->date_from }}</p>
                                    </div>
                                    <div class="col">
                                        <i class="fa fa-map-marker-alt"></i>
                                        @if(!empty($couseType_variation1->government))
                                            <p>{{ $couseType_variation1->government->government_trans(Session::get('locale'))->name or $couseType_variation1->government->government_trans("en")->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                    <div class="row">
                        <div class="col train_prograrm">
                            <img src="{{asset('assets/front/img/verified_list.svg')}}" />
                            <a href="{{ url(App('urlLang').'courses/'.$courseType->id) }}">الدورة</a>
                            <i class="fa fa-caret-left"></i>
                        </div>
                    </div>

                </div>
            </a>
            </div>
        </div>
        </a>
    </div>


@endif