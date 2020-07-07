@extends('front/layouts/master')

@section('meta')
<?php
	$setting = App('setting');
	$setting_trans = $setting->settings_trans(App('lang'));
	if(empty($setting_trans))
		$setting_trans = $setting->settings_trans('en');
?>
	<title>{{$setting_trans->meta_title}}</title>
	<meta name="keywords" content="{{$setting_trans->meta_keyword}}" />
	<meta name="description" content="{{$setting_trans->meta_description}}">
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
                            <span>تأكيد النشرة البريدية</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="alert alert-success">
                @if($oldActive)
                    أنت مشترك من قبل في النشرة البريدية
                @else
                    لقد تم إشتراكك بنجاح في الشنرةالبريدية...
                @endif
            </div>
        </div>
    </div>

@stop


