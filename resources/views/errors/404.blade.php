@extends('front/layouts/master')

@section('meta')
<?php
	$setting = App("setting");
	$setting_trans = $setting->settings_trans(App('lang'));
	if(empty($setting_trans))
		$setting_trans = $setting->settings_trans('en');
?>
	<title>{{trans('home.404_page')}}</title>
	<meta name="keywords" content="{{$setting_trans->meta_keyword}}" />
	<meta name="description" content="{{$setting_trans->meta_description}}">
@stop

@section('styles')
@stop

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
                            <span>{{trans('home.404_page')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

  
<!--Container -->
  <div class="error-page">
    <div class="container">
	 <div class="row">
                            <div class="col-md-12 text-center div404">
        <h2>4 <span style="color: #ffcb05;">0</span> 4</h2>
		  <hr class="hr-contact">
        <h4>الصفحة التي تبحث عنها يبدو انها غير موجودة. قد تكون أتبعت رابط خطأ او قد تكون تمت أزالتها</h4>
       
        <a href="{{URL::previous()}}" class="btn-contact">&nbsp; {{trans('home.back_previous_page')}}</a> 
		</div>
      <!-- end error page notfound --> 
      
    </div>
  </div></div>
  <!-- Container End -->

@stop


@section('scripts')
@stop

