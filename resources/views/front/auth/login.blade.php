@extends('front/layouts/master')

@section('styles')	
	<link href="{{asset('assets/front/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
@stop

@section('meta')
	<title>{{trans('home.login_register')}}</title>	
	<?php
		$setting = App('setting');
		$setting_trans = $setting->settings_trans(Session::get('locale'));
		if(empty($setting_trans))
			$setting_trans = $setting->settings_trans('en');
	?>
	<meta name="keywords" content="{{$setting_trans->meta_keyword}}" />
	<meta name="description" content="{{$setting_trans->meta_description}}">
@stop
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp

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
					<li class="breadcrumb-item active" aria-current="page">
						<span>{{trans('home.login_register')}}</span>
					</li>
				</ol>
			</nav>
		</div>

	</div>
</div>

<div class="login-area">
	<div class="container">
		<div class="row">
			<div class="col-md-6 login-form" style="direction:{{ $dir }}">
				<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">{{trans('home.you_have_account')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="profile" aria-selected="false">{{trans('home.new_user')}}</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent" style="text-align: justify">
					<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
						@include('common.errors')
						
						<form method="POST" id="login-form" action="{{ url(App('urlLang').'login') }}">
							<p>{{trans('home.login')}}</p>
							{!! csrf_field() !!}
							@if (session('status'))
								<div class="alert alert-success">
									{{ session('status') }}
								</div>
							@endif
							@if (isset($msg))
								<div class="alert alert-danger alert-noborder">
									<button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>

									<ul>
										<li>{{trans('home.close_account')}} <a href="https://swedish-academy.se/contact">{{trans('home.contact_us')}}</a></li>
									</ul>
								</div>
							@endif
							<div class="form-group {{ $errors->has('login') ? ' has-error' : '' }}">
								<label for="InputEmail"> {{trans('home.username_email_mobile')}} <span>*</span></label>
								<input type="text" class="form-control required" id="InputEmail"  name="login" value="{{ old('login') }}">
								@if ($errors->has('login'))
									<span class="help-block">
		                                <strong>{{ $errors->first('login') }}</strong>
		                            </span>
								@endif
							</div>

							<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
								<label for="InputPassword"> {{trans('home.password')}} <span>*</span></label>
								<input type="password" class="form-control required" name="password">
								@if ($errors->has('password'))
									<span class="help-block">
		                                <strong>{{ $errors->first('password') }}</strong>
		                            </span>
								@endif
							</div>

							<div class="form-check col-md-6">
								<input type="checkbox" class="form-check-input" name="remember">
								<label class="form-check-label" for="Check">{{trans('home.remember_me')}}</label>
							</div>

							<div class="form-check password-recover col-md-6">
								<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">{{trans('home.forget_pwd')}}</a>
									</li>
								</ul>

							</div>
							<div class="clear"></div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-login">{{trans('home.sign_up')}}</button>
							</div>
							<div class="clear"></div>
							<div class="login-or">
								<hr class="hr-or">
								<span class="span-or">{{trans('home.or')}}</span>
							</div>
							<div class="row text-center omb_socialButtons">
								<div class="col-xs-4">
									<a href="{{url(App('urlLang').'facebooklogin')}}" class="btn omb_btn-facebook">
										<i class="fa fa-facebook"></i>
									</a>
								</div>
								<div class="col-xs-4">
									<a href="{{url(App('urlLang').'twitterlogin')}}" class="btn omb_btn-twitter">
										<i class="fa fa-twitter"></i>
									</a> 
								</div>
								<div class="col-xs-4">
									<a href="{{url(App('urlLang').'googlelogin')}}" class="btn omb_btn-google">
										<i class="fa fa-google-plus"></i>
									</a>
								</div>
							</div>
						</form>
					</div>


					<div class="tab-pane fade" id="signin" role="tabpanel" aria-labelledby="profile-tab">
						<form method="POST" id="register-form" action="{{ url(App('urlLang').'register') }}">
							{!! csrf_field() !!}
							<div class="form-group">
								<label for="InputEmail"> {{trans('home.nom_user')}} <span>*</span></label>
								<input type="text" class="form-control" name="username" value="{{ old('username') }}">
							</div>

							<div class="form-group">
								<label for="InputEmail">  {{trans('home.your_email')}} <span>*</span></label>
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>

							<div class="form-group">
								<label>  {{trans('home.num_tel')}} <span>*</span></label>
								<input type="text" class="form-control" id="mobile1" name="mobile1" value="{{ old('mobile') }}">
							</div>

							<div class="form-group">
								<label for="InputPassword">{{trans('home.pwd')}}  <span>*</span></label>
								<input type="password" class="form-control" name="password">
							</div>

							<div class="form-group">
								<label for="InputPassword">{{trans('home.confirm_pwd')}}  <span>*</span></label>
								<input type="password" class="form-control" name="confirm_password">
							</div>

							<div class="form-check">
								<input type="checkbox" class="form-check-input" name="agreement">
								<label class="form-check-label" for="Check">
								{{trans('home.accepter_cond')}}	
									<a href="/pages/usage-policy">
									{{trans('home.condition_term')}} {{trans('home.and')}} {{trans('home.privacy_police')}}
									</a>
									{{-- {{trans('home.and')}} 
									<a href="/pages/privacy-policy">
									{{trans('home.privacy_police')}}	
									</a> --}}


								</label>
							</div>

							<div class="clear"></div>
							<div class="col-md-12 text-center">
								<button type="submit" id="signup_submit" data-loading-text="{{trans('home.signing_up')}}" class="btn btn-login">{{trans('home.sign_up')}}</button>
							</div>
						</form>
					</div>

					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
						<form method="POST" action="{{ url(App('urlLang').'password/email') }}" >
							{!! csrf_field() !!}
							<p>{{trans('home.please_enter_email_reset')}}</p>
							@if (session('status'))
								<div class="alert alert-success">
									{{ session('status') }}
								</div>
							@endif
							<div class="form-group">
								<label for="InputEmail">  {{trans('home.your_email')}} <span>*</span></label>
								<input type="email" class="form-control" name="email" value="{{  old('email') }}">
								@if ($errors->has('email'))
									<span class="help-block">
				                    <strong>{{ $errors->first('email') }}</strong>
				                </span>
								@endif
							</div>

							<div class="clear"></div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-login">{{trans('home.send')}}</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>




<div id="loadmodel_category" class="modal fade in" role="dialog"  style="display:none; padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
                <img src="{{asset('assets/admin/img/ajax-loading.gif')}}" alt="" class="loading">
                <span> &nbsp;&nbsp;{{trans('home.signing_up')}} </span>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
	<script src="{{asset('assets/front/vendors/build/js/intlTelInput.js')}}"></script>
	<script>
        $("#mobile1").intlTelInput({
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: "off",
            // dropdownContainer: "body",
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            hiddenInput: "mobile",
             initialCountry: "auto",
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            placeholderNumberType: "MOBILE",
            // preferredCountries: ['cn', 'jp'],
            // separateDialCode: true,
            utilsScript: "{{asset('assets/front/vendors/build/js/utils.js')}}"
        });

	</script>

	<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	@include("front.auth.js.login_js")
@stop