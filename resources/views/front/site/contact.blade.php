@extends('front/layouts/master')

@section('meta')
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $locale = session()->get('locale'); @endphp
<div class="modal" id="infos" style="direction:{{ $dir }}">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
        <h4 class="modal-title" style="text-align: justify">{{ trans('home.voir_plus') }}</h4>
        <button type="button" class="close" data-dismiss="modal">
        </button>            
      </div> 
      <div class="modal-body" style="text-align: justify;">
      {{ trans('home.voir_la_page') }} <a href="{{url(App('urlLang').'faq')}}">{{ trans('home.page_faq') }}   </a> {{ trans('home.avant_contact') }} 
      </div>

      <div class="modal-footer" style="display: {{ $locale === "ar" ? "" : "inline-flex"}}" >
        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('home.fermer_popup_contact') }}</button>
      </div>
    </div>
  </div>
</div>
 
<?php
	$setting_trans = $setting->settings_trans(Session::get('locale'));
	if(empty($setting_trans))
		$setting_trans = $setting->settings_trans('en');
?>
	<title>{{$metaData->title}}</title>
	<meta name="keywords" content="{{$metaData->keyword}}" /> 
	<meta name="description" content="{{$metaData->description}}">
@stop
@section('styles')
	<link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
@stop
@section('content')
	<div class="training_purchasing">
		<div class="container training_container">
			<div class="media" style="direction: {{$dir}};">
				<nav aria-label="breadcrumb"> 
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span>{{trans('home.contact')}}</span>
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>

<div class="contact-area" >
	<div class="container">

		<div class="row">
			<p>
				<img src="/uploads/kcfinder/upload/image/pages/contact.jpg" alt="" width="100%">
			</p>
			<div class="col-md-6 contact-info " style="text-align: {{ $locale === "ar" ? "right" : "left"}} ">
				<h4>{{trans('home.donnee_communication')}}</h4>
				<hr class="hr-contact" align= "{{ $locale === "ar" ? "right" : "left"}}" >
				<div class="col-md-12">
					<div class="contact-details" >
						<span><b> {{trans('home.bureau_suede')}} </b> <img src="{{ asset('assets/front/img/sweden.png') }}"  style="width: 30px;"/></span>
						<span style="direction: {{$dir}};"><i class="fa fa-home"></i> <b>{{$setting_trans->address}}</b></span>
						<span style="direction: {{$dir}};"><i class="fa fa-phone"></i> <b>{{ $setting->mobile }}</b></span>
						
						<span style="direction: {{$dir}};"><i class="fa fa-clock-o"></i> <b>{{trans('home.temps_suede')}}   : {{$setting_trans->time_work}} </b></span>
					</div>


				</div>
				<div class="col-md-12">
					<div class="contact-details">
						<span><b> {{trans('home.bureau_tunis')}}</b> <img src="{{ asset('assets/front/img/tunisia.png') }}" style="width: 30px;"/></span>
						<span style="direction: {{$dir}}"><i class="fa fa-home"></i> <b>Rue de la Feuille d'Erable, Les Berges du Lac 2 Tunis 1053,  Immeuble 'Tanit Business Center'  1ere étage app.101.</b></span>
						<span style="direction: {{$dir}}"><i class="fa fa-phone"></i><b > @lang('numerosw')</b> </span>
						<span style="direction: {{$dir}}"><i class="fa fa-clock-o"></i> <b> {{trans('home.temps_tunis')}} :  {{$setting_trans->time_work}}  </b></span>
						<span style="direction: {{$dir}}"><i class="fa fa-envelope"></i> <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></span>
					</div>
					<div class="social-icons">
						@foreach(App('setting')->socials as $social)
							<a href="{{ $social->link }}" target="_blank">
								<i id="social-fb" class="fa fa-{{ $social->name }} fa-2x social"></i>
							</a>
						@endforeach
					</div>

				</div>

			</div>
			<div class="col-md-6 contact-form"  style="text-align: {{ $locale === "ar" ? "right" : "left"}} ">
				<h4>{{trans('home.contact')}}</h4>
				<hr class="hr-contact" align="{{ $locale === "ar" ? "right" : "left"}}">

				<div id="displaycontact" class="display-none"></div>
				<form  id="contact_form" method="post" >
					{!! csrf_field() !!}
					<div class="form-group col-md-12"  style="text-align: {{ $locale === "ar" ? "right" : "left"}} ">
						<label for="User"> {{trans('home.full_name')}} <span>*</span></label>
						<input type="text" class="form-control" name="full_name">
					</div>
					

					<div class="form-group col-md-12" style="text-align: {{ $locale === "ar" ? "right" : "left"}} ">
						<label for="Email"> {{trans('home.email_address')}}<span>*</span></label>
						<input type="email" class="form-control" name="email">
					</div>

				<!-- 	<div class="form-group col-md-12">
						<label for="Phone"> الهاتف <span>*</span></label>
						<input type="tel" class="form-control" id="mobile" name="mobile" style="direction: ltr !important;">
					</div> -->

					<div class="form-group col-md-12" style="text-align: {{ $locale === "ar" ? "right" : "left"}} ">
						<label> {{trans('home.sujet_contact')}}<span>*</span></label>
						<input type="text" class="form-control" name="subject">
					</div>

					<div class="form-group col-md-12" style="text-align: {{ $locale === "ar" ? "right" : "left"}} ">
						<label for="Message"> {{trans('home.your_message')}} <span>*</span></label>
						<textarea  cols="20" rows="50" class="form-control form-textarea" name="message"></textarea>
					</div>
					<br/>
					<br/>
					<div class="form-group col-md-12" id="recaptcha" style="text-align: {{ $locale === "ar" ? "right" : "left"}} ">
						<label for="racaptacha">  </label>
						<br/>
						<br/>
						<br/>
						<br/>
						<br/>
						<br/>
						<br/>
						<br/>
						<div class="g-recaptcha" data-sitekey="6Lfzu1sUAAAAAGfHsC0I10V1NwCj40FhOLbUKjvf"></div>
					</div>

					<div class="clear"></div>
					
					<div class="col-md-12 text-center">
						<button type="submit" id="submit-btn" data-loading-text="{{trans('home.sending')}}" class="btn btn-contact">{{trans('home.send')}}</button>
					</div>
				</form>
			</div>


			

		</div>
	</div>
</div>
<!-- End contact Form -->
<!-- #################### -->
<div class="map">
	{!! $setting->map !!}
</div>


@stop



@section('scripts')

	<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/front/vendors/build/js/intlTelInput.js')}}"></script>

	<script>
	
			//modal script
		$(document).ready(function ()
	    {
	    	$('#infos').modal('show')
		   
	    })
		//mobile script
        $("#mobile").intlTelInput({
            // allowDropdown: false,
            // autoHideDialCode: false, 
            // autoPlaceholder: "off",
            // dropdownContainer: "body",
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            hiddenInput: "mobilefull",
            // initialCountry: "auto",
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            placeholderNumberType: "MOBILE",
            // preferredCountries: ['cn', 'jp'],
            // separateDialCode: true,
            utilsScript: "{{asset('assets/front/vendors/build/js/utils.js')}}"
        });

        //submit script

        $("#contact_form").bootstrapValidator({
			excluded: [':disabled'],
		    fields: {
		        full_name: {
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
		                    message: '{{trans("home.this_field_required")}}'
		                },
		                emailAddress: {
		                    message: 'The email is not a valid email address'
		                }
		            },
		            required: true
		        },
		        subject: {
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
		        message: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.this_field_required")}}'
		                }
		            },
		            required: true
		        }
		    }
		}).on('success.form.bv', function(e) {
			var response = grecaptcha.getResponse();

			if(response.length == 0){
			    $('#recaptcha').css('border','2px solid red')
			    $('#submit-btn').prop('disabled',false);
			    e.preventDefault();	
			}else{
				$('#recaptcha').css('border','none')
				e.preventDefault();	
				jQuery.ajax({
					url:"{{url(App('urlLang').'contact')}}",
					type: 'post',
					headers: {
				        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				    },
					data: $("#contact_form").serialize(),
					beforeSend: function(){
						$('#submit-btn').text("{{trans('home.sending')}}");
					},
			        success: function( message ) {		        	
			        	$("#contact_form input,#contact_form textarea").not('#submit-btn').val('');	        	
		        		$('#contact_form')
			            	.bootstrapValidator('resetField', "full_name")
			            	.bootstrapValidator('resetField', "email")
			            	.bootstrapValidator('resetField', "subject")
			            	.bootstrapValidator('resetField', "message");
			            
			           jQuery("#displaycontact").html(message);
			           jQuery("#displaycontact").slideDown();
			          
			           setTimeout(function(){
							jQuery("#displaycontact").fadeOut("slow", function(){
							});
						}, 5000);

	                    var offset = jQuery("#displaycontact").offset();
	                    offset.left -= 20;
	                    offset.top -= 80;
	                    jQuery('html, body').animate({
	                        scrollTop: offset.top,
	                        scrollLeft: offset.left
	                    });
	                },
			        error: function( data ) {
			            
			        },
			        complete: function(){
			        	 $('#submit-btn').text('إرسال');
			        }
				});
			}
		});
	</script>
@stop

