@extends('front/layouts/master')

@section('meta')
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
<?php
    $page_trans = $page->page_trans(session()->get('locale'));
	if(empty($page_trans))
		$page_trans = $page->page_trans("en");
?>
	<title>{{!empty($page_trans->meta_title)?$page_trans->meta_title:$page_trans->title}}</title>
	<meta name="keywords" content="{{$page_trans->meta_keyword}} " />
	<meta name="description" content="{{$page_trans->meta_description}} ">
@stop

@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction: {{ $dir }} ">
                <nav aria-label="breadcrumb"> 
                    <ol class="breadcrumb"> 
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page" style="direction:{{ $dir }}">
                            <span>{{$page_trans->title}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area" style="direction:{{ $dir }}; text-align: justify ;">
        <div class="container">
            <div class="row"> 
                <p>
                    {!! $page_trans->content !!}
                </p>
            </div>
        </div>
    </div>


@stop

@section('scripts')

@stop


