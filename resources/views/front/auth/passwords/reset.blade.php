@extends('front/layouts/master')

@section('styles')
	
@stop

@section('meta')
	<title>{{trans('home.reset_password')}}</title>	
	<?php
		$setting = App('setting');
		$setting_trans = $setting->settings_trans(App('lang'));
		if(empty($setting_trans))
			$setting_trans = $setting->settings_trans('en');
	?>
	<meta name="keywords" content="{{$setting_trans->meta_keyword}}" />
	<meta name="description" content="{{$setting_trans->meta_description}}">
@stop

<!-- Main Content -->
@section('content')
	<div class="training_purchasing">
		<div class="container training_container">
			<div class="media">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">

						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span>{{trans('home.reset_password')}}</span>
						</li>
					</ol>
				</nav>
			</div>

		</div>
	</div>

	<div class="login-area">
		<div class="container">
			<div class="row">
					<div class="col-md-6 login-form">
						<h4>{{trans('home.reset_password')}}</h4>
						<div class="panel-body">
							@if (session()->has('status'))
								<div class="alert alert-success">
									{{ session()->get('status') }}
								</div>
							@endif
							<form method="POST" role="form" action="{{ url(App('urlLang').'password/reset') }}" class="form-horizontal">
								{!! csrf_field() !!}
								<input type="hidden" name="token" value="{{ $token }}">
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<input type="email" placeholder="{{trans('home.email_address')}}" name="email"  class="form-control" value="{{ $email or old('email') }}">
									@if ($errors->has('email'))
										<span class="help-block">
					                    <strong>{{ $errors->first('email') }}</strong>
					                </span>
									@endif
								</div>
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<input type="password" class="form-control" name="password"  placeholder="{{trans('home.password')}}">

									@if ($errors->has('password'))
										<span class="help-block">
					                        <strong>{{ $errors->first('password') }}</strong>
					                    </span>
									@endif
								</div>
								<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									<input type="password" class="form-control" name="password_confirmation" placeholder="{{trans('home.confirm_password')}}">
									@if ($errors->has('password_confirmation'))
										<span class="help-block">
					                    <strong>{{ $errors->first('password_confirmation') }}</strong>
					                </span>
									@endif
								</div>
								<button class="btn btn-login" type="submit">{{trans('home.reset_password')}}</span></button>
							</form>
						</div>
					</div>
			</div>
		</div>
	</div>


@endsection
