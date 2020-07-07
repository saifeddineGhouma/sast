<div class="training_purchasing">
    <div class="container training_container">
        <div class="media">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <img class="align-self-center mr-3" src="{{asset('uploads/kcfinder/upload/image/'.$packs->image)}}"
                     alt="{{ $packs->name }}">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <div class="media-body align-self-center">
                    {{ $packs->name }} - {{ trans('home.'.$courseType->type) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="meta-price media-body align-self-center">
                    @if($courseType->points >0)
                        <span class="points-on-course"><span><i class="fa fa-gift"></i> {{ $courseType->points }} ﻧﻘﻄﺔ ﻣﺠﺎﻧﻴﺔ ﻋﻠﻰ ﻫﺬﻩ اﻟﺪﻭﺭﺓ</span>
						   <i class="repls">ﻳﻤﻜﻨﻚ ﺇﺳﺘﺒﺪاﻝ اﻟﻨﻘﺎﻁ اﻟﻤﺠﻤﻌﺔ ﻭاﻟﺤﺼﻮﻝ ﻋﻠﻰ ﻛﻮﺑﻮﻥ ﺧﺼﻢ</i>
						   <a href="{{ url(App('urlLang').'pages/points-program') }}" target="_blank">ﺗﻌﺮﻑ ﻋﻠﻰ ﺑﺮﻧﺎﻣﺞ اﻟﻨﻘﺎﻁ ﻭاﻟﻤﻜﺎﻓﺌﺎﺕ</a>
						</span>
					@endif
                    <?php
                        $first_Variation = $courseType->couseType_variations()->orderBy("price","asc")->first();
                        $setting = App('setting');
                        $vat = $setting->vat*$first_Variation->price/100;

                    ?>

                    @if((is_null($course->parent_course)||($course->isRegisteredParent()&&$course->isSuccessParent()))&&!$course->isRegistered())
                        <button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">( {{ floor($first_Variation->price+$vat) }} $ )</span></button>
                    @else
                        <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">( {{ floor($first_Variation->price+$vat) }} $ )</span></button>
                    @endif
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
                                        <p>ﻧﻘﺪﻡ ﺧﺼﻮﻣﺎﺕ ﺧﺎﺻﺔ ﻟﻠﻤﺠﻤﻮﻋﺎﺕ</p>
                                        <p>اﺫا ﻛﻨﺖ ﺗﺮﻏﺐ اﻧﺖ ﻭاﺻﺪﻗﺎﺋﻚ ﺑﺎﻟﺘﺴﺠﻴﻞ ﺑﻬﺬﻩ اﻟﺪﻭﺭﺓ ﺇﺧﺘﺎﺭﻭا اﻟﻌﺪﺩ اﻟﻤﻨﺎﺳﺐ ﻟﻜﻢ</p>
                                        <p>ﺑﻌﺪ ﺇﺗﻤﺎﻡ ﻋﻤﻠﻴﺔ اﻟﺪﻓﻊ ﺑﻨﺠﺎﺡ ﻭﺷﺮاء اﻟﺪﻭﺭﺓ ﺳﻨﻘﻮﻡ ﺑﺘﺤﻮﻳﻠﻚ اﻟﻲ ﺻﻔﺤﺔ ﺑﺤﺴﺎﺑﻚ ﻟﺘﻌﻴﺌﺔ اﺳﻤﺎء اﻟﻄﻠﺒﺔ ﻭﺑﺮﻳﺪﻫﻢ اﻻﻟﻜﺘﺮﻭﻧﻲ ﻭﺳﻮﻑ ﺗﺼﻠﻬﻢ ﺭﺳﺎﺋﻞ ﺗﺎﻛﻴﺪ اﻻﺷﺘﺮاﻙ ﺑﻨﺠﺎﺡ</p>
                                        <p>ﻫﺬﻩ اﻟﺪﻭﺭﺓ ﻳﻘﺪﻣﻬﺎ ﺃﻛﺜﺮ ﻣﻦ ﻣﺪﺭﺏ ﻓﻲ ﺃﻛﺜﺮ ﻣﻦ ﺑﻠﺪ ﻭﻣﺪﻳﻨﺔ - ﺑﺮﺟﺎء ﺗﺤﺪﻳﺪ ﺇﺣﺘﻴﺎﺭ اﻟﺒﻠﺪ / اﻟﻤﺪﻳﻨﺔ ﻭاﻟﻤﺪﺭﺏ</p>
                                        <form id="cart-form" class="search_form incourse" method="post" action="{{ url(App('urlLang').'cart/add-to-cart') }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group select_group">
                                                <select name="quantity" class="form-control select_form">
                                                    <option value="" selected>اﺧﺘﺮ اﻟﻌﺪﺩ</option>
                                                    @foreach(\App\Course::numStudents() as $stdnum)
                                                        <?php
                                                            $discount = $courseType->getDiscount($stdnum);
                                                        ?>
                                                        <option value="{{ $stdnum }}" data-discount="{{ $discount }}" >{{ $stdnum }}<span class="mrgmrg">ﻃﺎﻟﺐ</span>
                                                            <span>{{ $discount }}%<b class="mrgmrg">ﺧﺼﻢ</b></span>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group select_group">
                                                @if($courseType->type=="online")
                                                    <label>اﺧﺘﺮ اﻟﻤﺪﺭﺏ</label>
                                                @else
                                                    <label>ﺇﺧﺘﺮ اﻟﻤﺪﺭﺏ ﻭﺗﺎﺭﻳﺦ اﻟﺪﻭﺭﺓ ﻭاﻟﻤﻜﺎﻥ</label>
                                                @endif
                                                <div class="radio-list">
                                                    @foreach($courseType->couseType_variations as $courseTypeVariation)
                                                    <label>
                                                        <input type="radio" class="select_form" name="coursetypevariation_id" value="{{ $courseTypeVariation->id }}" data-price="{{ $courseTypeVariation->price }}">
                                                        <span>اﻟﻤﺪﺭﺏ : </span><span>{{ $courseTypeVariation->teacher->user->{'full_name_'.App("lang")} }}</span>
														@if($courseType->type!="online")
															<span>( {{ $courseTypeVariation->government->government_trans(App('lang'))->name or null }}</span>
															<span>{{ trans('home.start_at') }}</span><span>{{ $courseTypeVariation->date_from }}<span>ﺣﺘﻰ</span>{{ $courseTypeVariation->date_to }} )</span>
                                                        @endif
														<span>{{ floor($courseTypeVariation->price + App('setting')->vat*$courseTypeVariation->price/100) }}$</span>
                                                    </label>
													
                                                    @endforeach
                                                </div>
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
                                                    <label>أرفق وثائق إثبات الخبرة</label>
                                                    <input type='file' name='experience_files[]' id='experience_files' multiple required="" />
                                                </div>
                                            @endif

                                            <p class="price btnadd">
                                                <button type="submit" class="btn btn-primary  btn-md"> ﺷﺮاء<span id="ttlprc"></span><span class="ttl-stdn">ﻟﻌﺪﺩ : <b><span id="quantity_span">0</span> ﻃﻠﺒﺔ</b></span></button>
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