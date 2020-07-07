@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.modif_pwd')}}</title>
@stop
@section("styles")
<style>
    .diplay-none{
        display: none;
    }
</style>
@stop
@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp
@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:{{ $dir }}" >
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account') }}">حسابي</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.modif_pwd')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container" style="direction:{{ $dir }}">
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between row-account" style="text-align: justify;">
                        <div id="settings_message" class="alert alert-success display-none"></div>
                        <form  id="password_form" method="post" action="{{ url(App('urlLang').'account/save-password') }}">
                        {!! csrf_field() !!}
                            <div class="alert alert-danger display-none" id="info_message"></div>
                            <div class="form-group col-xs-12">
                                <input type="email"  class="form-control" placeholder="{{trans('home.email')}}" value="{{$user->email}}" disabled/>
                            </div>
                            <div class="form-group col-xs-12">
                                <input type="password" class="form-control" name="old_password" placeholder="{{trans('home.old_password')}}"/>
                            </div>
                            <div class="form-group col-xs-12">
                                <input type="password" class="form-control" name="password" placeholder="{{trans('home.new_password')}}"/>
                            </div>
                            <div class="form-group col-xs-12">
                                <input type="password" class="form-control" name="confirm_password" placeholder="{{trans('home.confirm_new_password')}}"/>
                            </div>
                            <div class="clearfix"></div>
                            
                            <div style="text-align:center">
                            <input type="submit" id="wish-submit" data-loading-text="{{trans('home.saving')}}" class="btn btn-contact" value="{{trans('home.save_modif')}}"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    @include("front.account.js.active_link_js")
    <script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
<script>
    $("#password_form").bootstrapValidator({
        fields: {
            old_password: {
                validators: {
                    notEmpty: {
                        message: '{{trans("home.old_password_required")}}'
                    }
                },
                required: true
            },
            password : {
                validators: {
                    notEmpty: {
                        message: '{{trans("home.password_required")}}'
                    },
                    identical: {
                        field: 'confirm_password',
                        message: '{{trans("home.password_confirm_not_same")}}'
                    }
                }
            },
            confirm_password : {
                validators: {
                    notEmpty: {
                        message: '{{trans("home.confirm_required")}}'
                    },
                    identical: {
                        field: 'password'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        var data = $("#password_form").serializeArray();
        $.ajax({
            url: $("#password_form").attr('action'),
            data:data,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend:function(){
                $("#wish-submit").button('loading');
            },
            success: function( msg ) {
                if(msg=="success"){
                    $("#settings_message").html("{{trans('home.password_changed_successfully')}}");
                    $("#settings_message").slideDown();
                    var offset = $("#settings_message").offset();
                    offset.left -= 20;
                    offset.top -= 80;
                    $('html, body').animate({
                        scrollTop: offset.top,
                        scrollLeft: offset.left
                    });
                    setTimeout(function(){
                        $("#settings_message").fadeOut("slow", function(){
                        });
                    }, 5000);

                }else{
                    $("#info_message").html(msg);
                    $("#info_message").slideDown();
                    setTimeout(function(){
                        $("#info_message").fadeOut("slow", function(){
                        });
                    }, 5000);
                }

                $("input[name='old_password']").val("");
                $("input[name='password']").val("");
                $("input[name='confirm_password']").val("");
            },
            complete: function(){
                $("#wish-submit").button('reset');
            }
        });
    });
</script>
@stop


