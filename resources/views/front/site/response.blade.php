@extends('front/layouts/master')

@section('meta')

	<title>حالة الدفع</title>
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
                            <span>{{trans('home.payment_status')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="row">
                @if(Session::has('payment_status'))
                    {!! Session::get('payment_status') !!}
                    {{trans('home.return_account')}}  <a href="{{url('/account')}}"> {{trans('home.click_here')}}</a>
                @endif
            </div>
        </div>
    </div>


@stop




