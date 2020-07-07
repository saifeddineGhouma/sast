@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.demande_aide')}}</title>
@stop
@section("styles")

@stop 

@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
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
                            <span>{{trans('home.demande_aide')}}</span>
                        </li>
                    </ol>
                </nav> 
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container" style="direction:{{ $dir }}">
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between row-account">
						<div class="area-content col-xs-12">
							<form  id="info_form" method="post" action="{{ url(App('urlLang').'account/ticket/create') }}" enctype="multipart/form-data">
								{!! csrf_field() !!}
								<div class="form-group" style="text-align: {{$alignText}}">
									<label class="form-label">{{trans('home.title')}} <span>*</span></label>
									<input type="text" class="form-control" name="titre" />
								</div>
								<div class="form-group" style="text-align: {{$alignText}}">
									<label class="form-label">  {{trans('home.text_probleme')}} <span>*</span></label>
									<textarea class="form-control" name="message" ></textarea>
								<input type="submit" class="btn btn-md btn-success svme" value="{{trans('home.save')}}">
							</form>
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


