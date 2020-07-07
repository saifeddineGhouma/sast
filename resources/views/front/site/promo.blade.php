@extends('front/layouts/master')

@section('meta')

	<title>الترويجي</title>
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
                            <span>الترويجي لـ {{ $promoUser->username }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="row">
                <p>أنت الآن على برومو {{ $promoUser->username }}</p>
                 <p>عند شراء أي منتج سيتم إضافة نقاط ترويجيه لحسابه</p>
            </div>
        </div>
    </div>


@stop




