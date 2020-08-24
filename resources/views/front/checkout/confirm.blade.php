@extends('front/layouts/master')

@section('meta')

	<title>{{trans('home.confirm')}}</title>
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
                            <span>صفحة الشراء</span>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.confirm')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="contact-area">
        <div class="container">
            <div class="row">
                <h4 class="checkout-sep">{{trans('home.checkout')}}</h4>
                <div class="box-border" style="display:block;">
                    @if(empty($msg))
                        <div id="confirm_success1" class="alert alert-success">
                            {{trans('home.order_sent_successfully')}}

                        </div>
                    @else
                        <div id="confirm_success1" class="alert alert-warning">
                            {{$msg}}

                        </div>
                    @endif
                    <!--button class="btn button" onclick="js:window.location.href='{{url(App('urlLang'))}}'">{{trans('home.continue_shopping')}}</button-->
					<button class="btn button" onclick="js:window.location.href='{{ url(App('urlLang').'account') }}'">{{trans('home.continue_shopping')}}</button>
                </div>
            </div>
        </div>
    </div>

@stop



@section('scripts')
<script>
	objMessage = jQuery("#confirm_success1");
	var offset = objMessage.offset();
	offset.left -= 20;
	offset.top -= 60;
	jQuery('html, body').animate({
		    scrollTop: offset.top,
		    scrollLeft: offset.left
	});	
</script>
@stop

