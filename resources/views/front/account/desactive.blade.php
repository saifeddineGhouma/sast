@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.close_account')}}</title>
@stop
@section("styles")
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
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
                            <span>{{trans('home.close_account')}}</span>
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
                    <div class="row justify-content-between row-account" style="text-align: {{$alignText}}">
                         <form  id="info_form" name="formedes" method="post" action='{{url(App("urlLang")."account/desactivee/")}}' style="width: 100%;">
							{{ csrf_field() }}
							<div class="col-md-12">
								<input type="radio" name="cause" value="إنه مؤقت. سأعود." /> {{trans('home.close_temporary')}}
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="أتلقى الكثير من رسائل البريد الإلكتروني." /> {{trans('home.close_lot_email')}}
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="أقضي الكثير من الوقت على الموقع." />{{trans('home.close_lot_time')}} 
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="لاأجد هذا الموقع مفيدًا." />{{trans('home.close_site_not_useful')}}
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="أنا لا أعرف كيفية استخدام هذا الموقع." />{{trans('home.close_use_site')}}
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="لا أشعر بالأمان على هذا الموقع." /> {{trans('home.close_feel_not_save')}}
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="لدي شكوك حول الخصوصية." />{{trans('home.close_doubts_privacy')}}
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="لدي حساب آخر على هذا الموقع." /> {{trans('home.close_another_account')}}
							</div>
							<div class="col-md-12">
								<input type="radio" name="cause" value="0" /> {{trans('home.close_other_cause')}}
								<textarea class="form-control" name="causeautre"></textarea>
							</div>
							<div class="clearfix"></div>
                            <a class="btn btn-md btn-success svme example-p-7">{{trans('home.send_desc')}}</a>
						 </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/jquery-confirm.css')}}"/>
    <script type="text/javascript" src="{{asset('assets/front/js/jquery-confirm.js')}}"></script>
	<script>
		// key strokes
		$('.example-p-7').on('click', function () {
			var cause = document.querySelector('input[name=cause]:checked').value;
			var causeautre = document.querySelector('textarea[name=causeautre]').value;
			if(causeautre!=""){
				causeautre="0";
			}
			$.confirm({
				title: '{{trans("home.question_desc_or_not")}}',
				escapeKey: true, // close the modal when escape is pressed.
				content: '{{trans("home.message_desact_pop")}}',//حذف اسمك وصورتك.',
				backgroundDismiss: true, // for escapeKey to work, backgroundDismiss should be enabled.
				buttons: {
				'{{trans("home.agree_desc")}}': {
						keys: [
							'enter'
						],
						action: function () {
							document.forms['formedes'].submit();
						}
					},
				'{{trans("home.reject_desc")}}': {
						keys: [
							'ctrl',
							'shift'
						],
						action: function () {
							$.alert('<strong>{{trans("home.desc_cancel")}}</strong>.');
						}
					}
				},
			});
		});
	</script>
@stop


