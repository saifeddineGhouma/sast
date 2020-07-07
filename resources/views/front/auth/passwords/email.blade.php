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


@section('content')
<div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Go to Home Page" href="{{url(App('urlLang'))}}">{{trans('home.home')}}</a><span>&raquo;</span></li>
            <li><strong>{{trans('home.reset_password')}}</strong></li>
          </ul>
        </div>
      </div>
    </div>
</div>
<!-- Breadcrumbs End --> 


<section class="main-container col1-layout">
    <div class="main container">
    	<div class="page-content">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h4>{{trans('home.reset_password')}}</h4>
			        <div class="panel-body">
				    	@if (session('status'))
				            <div class="alert alert-success">
				                {{ session('status') }}
				            </div>
				        @endif 
				    <form method="POST" action="{{ url(App('urlLang').'password/email') }}" >
				    	 {!! csrf_field() !!}
				        <p>{{trans('home.please_enter_email_reset')}}</p>
				        <div>
				        	<input type="email" placeholder="{{trans('home.email_address')}}" name="email"  class="form-control" value="{{ old('email') }}">
				        	 @if ($errors->has('email'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('email') }}</strong>
				                </span>
				            @endif			        	
				        </div>
				        <button class="button" type="submit">{{trans('home.send')}}</span></button>
				    </form>
				   </div>
				  </div>
			</div>
		</div>
	</div>
</section>

@endsection
