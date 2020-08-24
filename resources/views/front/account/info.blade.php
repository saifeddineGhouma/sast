@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.modifier_coordonne')}}</title>
@stop
@section("styles")
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
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
                            <span> {{trans('home.modifier_coordonne')}} </span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div> 
 
    <div class="account-area">
        <div class="container filter_container" style="direction:{{ $dir }}"  >
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    @include('common.errors')
                    <div class="row justify-content-between row-account" style="text-align: justify;">
                        <form  id="info_form" method="post" action="{{ url(App('urlLang').'account/info') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                            @include("front.checkout._info")
                            

                       
                            <input type="submit" class="btn btn-md btn-success svme" value="{{trans('home.save_modif')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    @include("front.checkout.js.info_js")
    <script>
        $("#info_form").bootstrapValidator({
            excluded: [':disabled'],
            fields: {
      /*          full_name_ar: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },*/
                full_name_en: {
                    validators: {
                        notEmpty: {
                            message: '{{trans("home.this_field_required")}}'
                        }
                    },
                    required: true
                },
                date_of_birth: {
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
                /*streat: {
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
                },*/
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

        });
    </script>
@stop


