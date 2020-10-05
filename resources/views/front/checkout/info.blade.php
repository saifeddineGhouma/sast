@extends('front/layouts/master')

@section('meta')
    <title>step 1</title>
@stop
@section("styles")
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
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
                            <span>المعلومات</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="row setup-content" id="step-1">
                    <div class="col-xs-12">
                        <div class="col-xs-12 well text-center">
                            @include('common.errors')
                            @if(session()->has('cart'))
                                <h1>@lang('navbar.info')</h1>
                                @if(session()->has('promo'))
                                    <?php
                                    $promoUser = \App\User::findOrFail(session()->get('promo'));
                                    ?>
                                    <p>@lang('navbar.youareinpromotion') {{ $promoUser->username }}</p>
                                @endif
                                @include('common.errors')
                                <form  id="info_form" method="post" action="{{ url(App('urlLang').'checkout/info') }}" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                @include("front.checkout._info")
                                <!--        @foreach($countries as $country)
                                    @if($country->id ==220  )
                                        <div class="col-md-6">
                                            <label class="form-label">رقم مقاس الملابس </label>
                                            <select class="form-control" name="clothing_size">
                                                <option value="S" {{ $user->clothing_size=="S"?"selected":null }}>S</option>
                                                <option value="M" {{ $user->clothing_size=="M"?"selected":null }}>M</option>
                                                <option value="L" {{ $user->clothing_size=="L"?"selected":null }}>L</option>
                                                <option value="XL" {{ $user->clothing_size=="XL"?"selected":null }}>XL</option>
                                            </select>
                                        </div>
                                     @endif
                                @endforeach  -->
                                    <div class="col-sm-12">
                                        @if($userpoints>=App('setting')->points&&$userpoints>0)

                                            <div id="points_div" style="margin-top: 20px;">
                                                <input type="checkbox" name="points_check" id="points_check">{{trans('home.use_reward_points')}}{{$userpoints}})
                                                <div class="form-group display-none" id="points_input" style="margin-top: 10px;">
                                                    <label class="control-label">{{trans('home.points_to_use')}}{{App('setting')->max_points_replace}}):</label>
                                                    <input type="text" name="points" id="points" class="form-control"/>
                                                </div>
                                            </div>
                                        @endif

                                        <div id="coupon_div" style="margin-top: 20px;">
                                            <input type="checkbox" name="coupon_check" id="coupon_check">{{trans('home.use_coupon')}}
                                            <div class="form-group display-none" id="coupon_input" style="margin-top: 10px;">
                                                <label class="control-label">{{trans('home.coupon')}} :</label>
                                                <input type="text" name="coupon_number" class="form-control"/>
                                            </div>
                                        </div>

                                    </div><!-- points -->

                                    <input type="submit" class="btn btn-md btn-success nxtnt" value="@lang('navbar.next')">
                                </form>
                            @else
                                <h1>@lang('navbar.emptycard')</h1>
                                <a class="btn btn-md btn-success" href="{{url(App('urlLang').'all-courses')}}" >@lang('navbar.previous')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    @include("front.checkout.js.info_js")
    <script>
        $("#points_check").change(function(){
            if($(this).is(":checked")){
                $("#points_input").slideDown();
            }else{
                $("#points_input").slideUp();
            }
        });
        $("#points").change(function(){
            var points = $("#points").val().replace(/[^0-9]/g, '');
            $(this).val(points);
        });
        $("#coupon_check").change(function(){
            if($(this).is(":checked")){
                $("#coupon_input").slideDown();
            }else{
                $("#coupon_input").slideUp();
            }
        });


        
        $("#info_form").bootstrapValidator({
			
            excluded: [':disabled'],
            fields: {
               
                full_name_en: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                /*date_of_birth: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: false
                },*/
                gender: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                address: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                streat: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                house_number: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                mobile: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.email_required")}}'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        },
                        remote: {
                            message: 'The Email is not available',
                            url: "{{url('/home/unique-email')}}",
                            type: 'GET',
                            data: function(validator) {
                                return {
                                    id: '{{$user->id}}'
                                };
                            }
                        }
                    }
                },
                country_id: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                government_id: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                mobile: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
            }
        }).on('success.form.bv', function(e) {
            var points = $("#points").val();
            var max_points_replace = {{App('setting')->max_points_replace}};
            var userpoints = {{$userpoints}};
            if(points!="" && (points>max_points_replace||points>userpoints)){
                e.preventDefault();
                $("#points").closest(".form-group").find(".help-block").remove();
                $("#points").closest(".form-group").addClass("has-error");
                $("#points").closest(".form-group").append("<span class='help-block'>{{trans('home.points_invalid')}}</span>");
            }else{
                $("#points").closest(".form-group").removeClass("has-error");
                $("#points").closest(".form-group").find(".help-block").remove();
            }
        });


    </script>
@stop


