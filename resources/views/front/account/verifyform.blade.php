@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.verify_email')}}</title>
@stop
@section("styles")

@stop
@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp 
@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:{{ $dir }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account') }}">{{trans('home.mon_compte_header')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.verify_email')}}</span>
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
                    <div class="my-account">
                        <div class="page-title" style="text-align: {{$alignText}}">
                            <h2>{{trans('home.verify_email')}}</h2>
                        </div>
                        <div class="wishlist-item table-responsive">
                            <div class="area-content col-xs-12">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="marb-60">
                                    <tbody><tr>
                                        <td width="135" align="center">
                                            <img src="{{asset('assets/front/img/email_verification_code.gif')}}" alt="">
                                        </td>
                                        <td valign="top">
                                            <div class="mart-10 marb-10">
                                                <div class="txt18  mart-10"><strong>{{trans('home.pls_verify_email')}}.</strong></div>
                                                <div class="mart-10 marb-5"> {{trans('home.we_emailed_you')}} "<span class="text-orange">{{$user->email}}</span>"<br><br>
                                                    {{trans('home.now_activate_email_click')}} <br/>
                                                    {{trans('home.or_activation_code')}}
                                                </div>
                                                <form name="verify_email" id="verify_email" action="{{url(App('urlLang').'user-verification')}}" method="get">
                                                   
                                                    <div>
                                                       
                                                        <input type="hidden" name="email" value="{{$user->email}}">
                                                        <!--<input type="submit" class="button button-send-small"   value="فعّل البريد الالكتروني" />-->
                                                        
                                                    </div>
                                                </form>

                                                <div class="mart-10">
                                                    <form name="send_verify_email" id="send_verify_email" action="{{url(App('urlLang').'account/send-verify-message')}}" method="post">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                        {{trans('home.if_donot_receive')}} , <a href="javascript:void(0);" id="submit_send_verify_email" style='color: #23a1d1;'>{{trans('home.resend_message')}}</a> </b>
                                                    </form>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    <script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery("#submit_send_verify_email").click(function() {
            jQuery( "#send_verify_email" ).submit();
        });
        $("#verify_email").bootstrapValidator({
            excluded: [':disabled'],
            fields: {
                mail: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },

            }
        }).on('success.form.bv', function(e) {

        });
    </script>
    @include("front.account.js.active_link_js")
@stop


