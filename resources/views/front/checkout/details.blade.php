@extends('front/layouts/master')

@section('meta')
	<title>step 3</title>

@stop
@section("styles")

@stop
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $textalign = session()->get('locale') === "ar" ? "right" : "left" @endphp

@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
        <div class="media" style="direction: {{ $dir }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>@lang('navbar.purchasepage')</span>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>@lang('navbar.reviewdemande')</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="row setup-content" id="step-3">
                    <div class="col-xs-12">
                        <div class="col-md-12 well text-center" style="direction: {{$dir}}">
                            <h1 class="text-center">@lang('navbar.reviewdemande')</h1>
                            <div class="col-md-8 col-md-offset-2">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="info" style="text-align: {{$textalign}}">@lang('navbar.name')</th>
                                            <td>{{ $user->full_name_en }}</td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: {{$textalign}}">@lang('navbar.country')</th>
                                            <td>{{ $user->nationality }}</td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: {{$textalign}}" >@lang('navbar.mail')</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: {{$textalign}}" >@lang('navbar.phonenumber')</th>
                                            <td>{{ $user->mobile }}</td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: {{$textalign}}" >@lang('navbar.purchaseway')</th>
                                            <td>
                                                {{ trans('home.'.$checkout['payment_method']) }}
                                                @if(!empty($agent))
                                                    <br/>{{ $agent->name }}
                                                @endif
                                                @if(isset($checkout["banktransfer_image"])&&($checkout["payment_method"]=="banktransfer"||
                                                    $checkout["payment_method"]=="agent"))
                                                    <img src="{{ asset('uploads/kcfinder/upload/image/bank_transfers/'.$checkout["banktransfer_image"]) }}" width="200px"/>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-12 nnnn table-responsive">
                                @include('front.checkout._cart')
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

       $("#pay_form").bootstrapValidator({
           excluded: [':disabled'],
           fields: {

           }
       }).on('success.form.bv', function(e,data) {

		e.preventDefault();
           $.ajax({
               url: $(this).attr("action"),
               type: 'post',
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: $(this).serialize(),
               beforeSend: function(){
                   $("#content_loading").modal("show");
               },
               success: function( message ) {
                   //var indexhttp = message.search("http");
                   //console.log("ss "+message);
                   if(message[0]=="success")
                       location.href = message[1];
                   else{
                       $("#error_message").html("<div class='alert alert-danger'>"+json.parse(message[1])+"</div>");
                   }
               },
               error: function(message){
					$("#error_message").html("<div class='alert alert-danger'>An error occured please try again later or <a href='/contact'>contact us</a></div>");
               },
               complete: function() {
                   $("#content_loading").modal("hide");
               }
           });
       });

    </script>
@stop


