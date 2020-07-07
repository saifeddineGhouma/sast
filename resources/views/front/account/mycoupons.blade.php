@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.my_coupons')}}</title>
@stop
@section("styles")

@stop
@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp
@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:{{ $dir }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account') }}">{{trans('home.mon_compte_header')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.my_coupons')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container"  style="direction:{{ $dir }}">
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between row-account">
                        <div class="area-content col-xs-12">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab1" class="nav-link" data-toggle="tab">
                                        {{trans('home.unused_coupons')}}</a>
                                </li>
                                <li>
                                    <a href="#tab2" class="nav-link" data-toggle="tab">
                                        {{trans('home.used_coupons')}}</a>
                                </li>
                                <li>
                                    <a href="#tab3" class="nav-link" data-toggle="tab">
                                        {{trans('home.expired')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content mar-top">
                                <div id="tab1" class="tab-pane fade active show in">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel">
                                                <div class="panel-body" style="margin-top: 20px;text-align: justify;">
                                                    @if(!$nonUsedCoupons->isEmpty())
                                                        @include("front.account._coupon",array("coupons"=>$nonUsedCoupons))
                                                    @else
                                                        {{trans('home.no_coupons')}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab2" class="tab-pane fade">
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <div class="panel">
                                            <div class="panel-body" style="margin-top: 20px;text-align: justify;"">
                                                @if(!$usedCoupons->isEmpty())
                                                    @include("front.account._coupon",array("coupons"=>$usedCoupons))
                                                @else
                                                    {{trans('home.no_coupons')}}
                                                @endif
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                </div> 
                                <div id="tab3" class="tab-pane fade">
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <div class="panel">
                                            <div class="panel-body" style="margin-top: 20px;text-align: justify;"> 
                                                @if(!$expiredCoupons->isEmpty())
                                                    @include("front.account._coupon",array("coupons"=>$expiredCoupons))
                                                @else
                                                    {{trans('home.no_coupons')}}
                                                @endif
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    @include("front.account.js.active_link_js")
@stop


