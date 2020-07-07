@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.verify_mobile')}}</title>
@stop
@section("styles")

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
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account') }}">حسابي</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.verify_mobile')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container">
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>{{trans('home.verify_mobile')}}</h2>
                        </div>
                        <div class="wishlist-item table-responsive">
                            <div class="area-content col-xs-12">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="marb-60">
                                    <tbody><tr>
                                        <td width="135" align="center">
                                            <img src="{{asset('assets/front/images/email_verification_code.gif')}}" alt="">
                                        </td>
                                        <td valign="top">
                                            <div class="mart-10 marb-10">
                                                <div class="txt18  mart-10"><strong>{{trans('home.pls_verify_mobile')}}.</strong></div>
                                                <div class="mart-10 marb-5"> {{trans('home.we_emailed_you')}} "<span class="text-orange">{{$user->mobile}}</span>"<br><br>
                                                    {{trans('home.now_activate_mobile_click')}},<br/>
                                                    {{trans('home.or_activation_code')}}
                                                </div>
                                                <form name="verify_mobile" id="verify_mobile" action="{{url(App('urlLang').'mobile-verification')}}" method="get">
                                                    <div class="marb-5"><strong>{{trans('home.activation_code')}}:</strong></div>
                                                    <div>
                                                        <input class="form-input-field width-120" name="mail" id="mail" type="text" value="">
                                                        <input type="hidden" name="mobile" value="{{$user->mobile}}">
                                                        <!--<input type="submit" class="button button-send-small"   value="فعّل البريد الالكتروني" />-->
                                                        <input type="submit" value="confirm mobile" class="button-style-gray">
                                                    </div>
                                                </form>

                                                <div class="mart-10">
                                                    <form name="send_verify_mobile" id="send_verify_mobile" action="{{url(App('urlLang').'account/send-verify-message-mobile')}}" method="post">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                        {{trans('home.if_donot_receive')}}, <a href="javascript:void(0);" id="submit_send_verify_mobile" style='color: #23a1d1;'>{{trans('home.resend_message')}}</a> </b>
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
    <script>
        jQuery("#submit_send_verify_mobile").click(function() {
            jQuery( "#send_verify_mobile" ).submit();
        });
        $("#verify_mobile").bootstrapValidator({
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


