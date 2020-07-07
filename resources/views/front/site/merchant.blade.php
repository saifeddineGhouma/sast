@extends('front/layouts/master')

@section('meta')
	<title>{{$metaData->title}}</title>
	<meta name="keywords" content="{{$metaData->keyword}}" />
	<meta name="description" content="{{$metaData->description}}">
@stop
@section('styles')

@stop
@section('content')

 <!-- Breadcrumbs -->  
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul>
            <li class="home"> <a title="Go to Home Page" href="{{url(App('urlLang'))}}">{{trans('home.home')}}</a><span>&raquo;</span></li>
            <li><strong>
            	@if($type=="merchant")
            		{{trans('home.register_merchant')}}
            	@else
            		{{trans('home.register_shipping')}}
            	@endif
            </strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumbs End --> 
  
 <!-- Main Container -->
<section class="main-container col1-layout">
	<div class="main container">
	  <div class="row">
	    <section class="col-main col-sm-12">
	      
	      <div id="contact" class="page-content page-contact">
	      <div class="page-title">
	        <h2>@if($type=="merchant")
            		{{trans('home.register_merchant')}}
            	@else
            		{{trans('home.register_shipping')}}
            	@endif</h2>
	      </div>
	        <div class="row col-xs-12">
	          
	            <h3 class="page-subheading">{{trans('home.make_enquiry')}} </h3>
	            <div class="contact-form-box">
	            	<div id="displaycontact" class="display-none"></div>	
	            	<form  id="merchant_form" name="merchant_form" method="post" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<input type="hidden" name="type" value="{{$type}}"/>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
					                <label>{{trans('home.first_name')}}<span style="color:red;">*</span></label>
					                <input type="text" class="form-control input-sm" name="first_name" />
					            </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
					                <label>{{trans('home.last_name')}}<span style="color:red;">*</span></label>
					                <input type="text" class="form-control input-sm" name="last_name" />
					            </div>
							</div>
							
						</div>						
						<div class="row">
						<div class="col-md-6">
								<div class="form-selector form-group">
					                <label>{{trans('home.email_address')}}<span style="color:red;">*</span></label>
					                <input type="text" class="form-control input-sm" name="email" />
					            </div>
							</div>
							<div class="col-md-6">
								<div class="form-selector form-group">
					                <label>{{trans('home.shop_country')}}<span style="color:red;">*</span></label>
					                <select name="country_id" class="form-control input-sm">
					                	@foreach($countries as $country)
					                		<option value="{{$country->id}}">{{$country->country_trans(App('lang'))->name or $country->country_trans("en")->name}}</option>
					                	@endforeach
					                </select>
					            </div>
							</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-selector form-group">
						                <label>{{trans('home.shop_name')}}<span style="color:red;">*</span></label>
						                <input type="text" class="form-control input-sm" name="shop_name" />
						            </div>
								</div>
								<div class="col-md-6">
									<label>{{trans('home.shop_logo')}}</label>
									<input type="file" name="shop_logo">
								</div>
							</div>
							<div class="row">
							<div class="col-md-6">
								 <div class="form-selector form-group">
					                <label>{{trans('home.work_field')}}<span style="color:red;">*</span></label>
					                <textarea class="form-control input-sm mrchnt" name="work_field" ></textarea>
					            </div>
							</div>
							
						</div>
							<div class="row">
							<div class="col-md-6">
								<div class="form-selector form-group">
					                <label>{{trans('home.phone')}}<span style="color:red;">*</span></label>
					                <input type="text" class="form-control input-sm" name="phone" />
					            </div>
							</div>
							<div class="col-md-6">
								<div class="form-selector form-group">
					                <label>{{trans('home.mobile')}}<span style="color:red;">*</span></label>
					                <input type="text" class="form-control input-sm" name="mobile" />
					            </div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								 <div class="form-selector form-group">
					                <label>{{trans('home.manager_name')}}<span style="color:red;">*</span></label>
					                <input type="text" class="form-control input-sm" name="manager" />
					            </div>
							</div>
							<div class="col-md-6">
								<div class="form-selector form-group">
					                <label>{{trans('home.manager_mobile')}}<span style="color:red;">*</span></label>
					                <input type="text" class="form-control input-sm" name="manager_mobile" />
					            </div>
							</div>
						</div>
			            
			            <div class="form-selector form-group">
							<label class="inline formerchant " for="rememberme">
								<input name="remember" type="checkbox">{{trans('home.i_agree_on')}} 
									@if($type=='merchant')
								  		<a href="{{url(App('urlLang').'pages/merchants-agreement')}}">{{trans('home.merchants_agreement')}} </a> ,
								  	@else
								  	
								  	@endif 
								  
								  <a href="{{url(App('urlLang').'pages/terms')}}"> {{trans('home.terms_conditions')}}  </a> {{trans('home.and')}}  <a href="{{url(App('urlLang').'pages/privacy')}}">  {{trans('home.privacy_policy')}} </a>{{trans('home.for_tojar')}} 
							</label>
			                <button class="button" type="submit" id="submit-btn" data-loading-text="{{trans('home.sending')}}"><i class="fa fa-send"></i>&nbsp; <span>{{trans('home.send')}}</span></button>
			              </div>
					</form>
	              
	          </div>
	      </div>
	    </section>
	  </div>
	</div>
</section>
<!-- Main Container End -->  

@stop



@section('scripts')
	<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	 
	 <!--Begin Comm100 Live Chat Code-->
<div id="comm100-button-300"></div>
<script type="text/javascript">
  var Comm100API=Comm100API||{};(function(t){function e(e){var a=document.createElement("script"),c=document.getElementsByTagName("script")[0];a.type="text/javascript",a.async=!0,a.src=e+t.site_id,c.parentNode.insertBefore(a,c)}t.chat_buttons=t.chat_buttons||[],t.chat_buttons.push({code_plan:300,div_id:"comm100-button-300"}),t.site_id=227263,t.main_code_plan=300,e("https://chatserver.comm100.com/livechat.ashx?siteId="),setTimeout(function(){t.loaded||e("https://hostedmax.comm100.com/chatserver/livechat.ashx?siteId=")},5e3)})(Comm100API||{})
</script>
<!--End Comm100 Live Chat Code-->
	 
	<script>
		$("#merchant_form").bootstrapValidator({
			excluded: [':disabled'],
		    fields: {
		        first_name: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.this_field_required")}}'
		                }
		            },
		            required: true
		        },
		        last_name: {
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
		                    message: '{{trans("home.the_email_not_valid")}}'
		                }
		            },
		            required: true
		        },
		        country_id: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.this_field_required")}}'
		                }
		            },
		            required: true
		        },
		        shop_name: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.this_field_required")}}'
		                }
		            },
		            required: true
		        },
		        phone: {
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
		         manager: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.this_field_required")}}'
		                }
		            },
		            required: true
		        },
		         manager_mobile: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.this_field_required")}}'
		                }
		            },
		            required: true
		        },
		        work_field: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.this_field_required")}}'
		                }
		            },
		            required: true
		        },
		        remember: {
		            validators: {
		                notEmpty: {
		                    message: '{{trans("home.you_should_agree")}}'
		                }
		            },
		            required: true
		        }
		    }
		}).on('success.form.bv', function(e) {
			e.preventDefault();	
			var form = document.forms.namedItem("merchant_form");
			var formData = new FormData(form);
			jQuery.ajax({
				url:"{{url(App('urlLang').'merchant')}}",
				type: 'post',
				headers: {
			        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			    },
			    processData: false,
	      	    contentType: false,
				data: formData,
				beforeSend: function(){
					$('#submit-btn').text("{{trans('home.sending')}}");
				},
		        success: function( message ) {		        	
		        	$("#merchant_form input,#merchant_form textarea").not('#submit-btn').val('');	        	
	        		$('#merchant_form')
		            	.bootstrapValidator('resetField', "first_name")
		            	.bootstrapValidator('resetField', "last_name")
		            	.bootstrapValidator('resetField', "country_id")
		            	.bootstrapValidator('resetField', "shop_name")
		            	.bootstrapValidator('resetField', "email")
		            	.bootstrapValidator('resetField', "mobile")
		            	.bootstrapValidator('resetField', "phone")
		            	.bootstrapValidator('resetField', "manager")
		            	.bootstrapValidator('resetField', "manager_mobile")
		            	.bootstrapValidator('resetField', "work_field");
		            
		           jQuery("#displaycontact").html(message);
		          
		          var offset = jQuery("#displaycontact").offset();
					offset.left -= 20;
					offset.top -= 80;
					jQuery('html, body').animate({
						    scrollTop: offset.top,
						    scrollLeft: offset.left
					});	
					 jQuery("#displaycontact").slideDown();
		           /*setTimeout(function(){
						jQuery("#displaycontact").fadeOut("slow", function(){
						});
					}, 5000); */
		        },
		        error: function( data ) {
		            
		        },
		        complete: function(){
		        	 $('#submit-btn').text("{{trans('home.send')}}");
		        }
			});
		});
	</script>
@stop

