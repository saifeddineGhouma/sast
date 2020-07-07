@extends('front/layouts/master')

@section('meta')

	<title>{{ $packs->titre }}</title>
	<meta name="keywords" content="{{ $packs->titre }}" />
	<meta name="description" content="{{ $packs->titre }}">
@stop

@section('styles')

	<style>
		.display-none{
			display: none;
		}
	</style>
@stop


@section('content')
<?php
	$course1 = \App\Course::findOrFail($packs->cours_id1);
	$course_trans1 = $course1->course_trans(App('lang'));
	$coursee1 = DB::table('course_types')->where('course_id', '=', $packs->cours_id1)->first();
	
	$course2 = \App\Course::findOrFail($packs->cours_id2);
	$course_trans2 = $course2->course_trans(App('lang'));
	$coursee2 = DB::table('course_types')->where('course_id', '=', $packs->cours_id2)->first();
	 
	if(!empty($user->id)){
		$pack_achat = DB::table('order_products')
						->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
						->where("order_products.pack_id",$packs->id)
						->where("orderproducts_students.student_id",$user->id)->count();
	}else{
		$pack_achat=0;
	}
?>
<div class="container-fluid breadcrumbct">
	<div class="container training_container">
		<div class="media">
			<div class="media-body align-self-center">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a title="Go to Home Page" href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						<li class="breadcrumb-item">
							<a title="Go to Home Page" href="{{url(App('urlLang'))}}/packs"><span>باقة</span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span>
								{{ $packs->titre }}
							</span>
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="training_purchasing">
    <div class="container training_container">
        <div class="media">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <img class="align-self-center mr-3" src="{{asset('uploads/kcfinder/upload/image/packs/'.$packs->image)}}" alt="دورة الاصابات الرياضية المستوى الاول">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <div class="media-body align-self-center">
					{{ $packs->titre }}
				</div>
				<div>
					<a href="{{ url(App('urlLang').'courses/'.$coursee1->id) }}">
						{{ $course_trans1->name }}
					</a>
				</div>
				<div>
					<a href="{{ url(App('urlLang').'courses/'.$coursee2->id) }}">
						{{ $course_trans2->name }}
					</a>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <?php
					$setting = App('setting');
					$vat = $setting->vat*$packs->prix/100;

				?>
				<div class="meta-price media-body align-self-center">
					<?php if(($pack_achat==1)){ ?>
                        <button class="btn btn-disabled btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" disabled="disabled"><span style="margin-right: 10px;">( {{ $packs->prix+$vat }} $ )</span></button>
					<?php }else{ ?>
						<button class="btn btn-primary btn-block btn-toggle collapsed btn-form btn-inverse btn-sm" data-toggle="collapse" data-target="#change-search"><span style="margin-right: 10px;">( {{ $packs->prix+$vat }} $ )</span></button>
					<?php } ?>
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
                                        <form id="cart-form" class="search_form incourse bv-form" method="post" action="{{ url(App('urlLang').'cart/add-to-cart') }}" enctype="multipart/form-data" novalidate="novalidate"><button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
                                            {{ csrf_field() }}
                                            <div class="form-group select_group">
                                                <select name="quantity" class="form-control select_form" data-bv-field="quantity">
                                                    <option value="" selected="">اﺧﺘﺮ اﻟﻌﺪﺩ</option>
													<option value="1" data-discount="0">1ﻃﺎﻟﺐ</option>
													<option value="2" data-discount="4">2ﻃﺎﻟﺐ</option>
													<option value="3" data-discount="6">3ﻃﺎﻟﺐ</option>
													<option value="4" data-discount="8">4ﻃﺎﻟﺐ</option>
													<option value="5" data-discount="10">5ﻃﺎﻟﺐ</option>
												</select>
												<small class="help-block" data-bv-validator="notEmpty" data-bv-for="quantity" data-bv-result="NOT_VALIDATED" style="display: none;">برجاء إختيار الكمية</small>
												<input type="hidden" name="prix_id" value="{{ $packs->prix }}" />
											</div>
											<input type="hidden" name="pack_id" value="{{ $packs->id }}" />
											<p class="price btnadd">
												<button type="submit" class="btn btn-primary  btn-md"> ﺷﺮاء<span id="ttlprc"></span><span class="ttl-stdn">ﻟﻌﺪﺩ : <b><span id="quantity_span">0</span> ﻃﻠﺒﺔ</b></span></button>
											</p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div><!--g-->
    </div>
</div>

<div class="courses_selection">
	<div class="container">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item active">
				<a class="nav-link  " data-toggle="tab" href="#information" role="tab"  >{{ $course_trans1->name }}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#curriculum" role="tab"  >{{ $course_trans2->name }}</a>
			</li>

		</ul>
	</div>
</div>
<div class="courses_more_info">
	<div class="container">
		<div class="row more_info_one justify-content-between tab-content">
			<div class="tab-pane fade in active show" role="tabpanel" id="information">
				{!! $course_trans1->content_online !!}
			</div>
			<div role="tabpanel" class="wide-tb  col-lg-12 tab-pane fade " id="curriculum">
				{!! $course_trans2->content_online !!}
			</div>
        </div>
    </div>
</div>



@stop

@section('scripts')
	<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	@include("front.packs.js.view_js")
@stop
