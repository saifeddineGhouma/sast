@extends('front/layouts/master')

@section('meta')
    <title>دليل البرنامج التدريبي</title>

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
                        <span>دليل البرنامج التدريبي</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div> 
 
    <div class="container padding-50">
        <div class="row">
            <p>
                <iframe src="{{asset('uploads/kcfinder/upload/file/summaries/دليل-البرنامج-التدريبي-لمدرب-اللياقة.pdf')}}" style="width: 100%;height: 100%;"></iframe>
                <a href="{{asset('uploads/kcfinder/upload/file/summaries/دليل-البرنامج-التدريبي-لمدرب-اللياقة.pdf')}}"> دليل البرنامج التدريبي لمدرب اللياقة </a> 
            </p>
        </div>

    </div>

@stop
 



