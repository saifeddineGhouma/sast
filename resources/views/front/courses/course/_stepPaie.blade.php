<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                    <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">{{ floor(($first_Variation->price+$vat)/2) }}$ </span></button>
                @else
                    @if($course->isPayCourseLevel2()) 
                    <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;"> {{ floor(($first_Variation->price+$vat)/2) }}$ </span></button>
                    @else
                        @if($course->isPayPackThree())  
                        <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;"> {{ floor(($first_Variation->price+$vat)/2) }}$ </span></button>
                        @else
                        <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;"> {{ floor($first_Variation->price+$vat) }}$ </span></button>
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
                          <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$ </span></button>        
                      
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
                <button  class="btn btn-primary btn-test btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;"><!--button correct---> {{ floor($first_Variation->price+$vat) }}$ </span></button>        
                @endif
            @endif


        @else
        <button class="btn btn-disabled btn-block btn-toggle  collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">{{ floor($first_Variation->price+$vat) }}$</span></button>
        @endif
        @endif
    {{-- end add new code system --}}
    </div>
</div>

<div class="message "style="display: none">

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
      $(".btn-test").click(function(){
       //   alert('test')
      //  $(".message").toggle();
      });
    });
    </script>