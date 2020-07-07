@extends('front/layouts/master')

<script> var expanded = false;

		function showCheckboxes() {
		  var checkboxes = document.getElementById("checkboxes");
		  if (!expanded) {
			checkboxes.style.display = "block";
			expanded = true;
		  } else {
			checkboxes.style.display = "none";
			expanded = false; 
		  }
		} 
		function afficher(etat)
			{   
				document.getElementById("cat_academy").style.display=etat;   
			}
<script>

<div class="form-group autocomplete"  >
                         <input type="text" placeholder="email" class="form-control search-name"  id="myInput" name="email"/>
                     </div>
                     <div class="form-group autocomplete"  >
                        <input type="text" placeholder="phone" class="form-control search-name"  id="myInput" name="phone"/>
                    </div>
                    <div class="form-group autocomplete"  >
                        <input type="file" placeholder="phone" class="form-control search-name"  id="myInput" name="resume"/>
                    </div>
                 
                 <div class="col-md-4">
                     <div class="form-group">
                         <input type="submit" class="btn btn-md btn-success svme" value="postuler">
                     </div>
                 </div>
             </div>



@section('meta')
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $locale = session()->get('locale')==="ar" ? "right" :"left" @endphp
@stop
@section('styles')
	<link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
@stop
@section('content')
	<div class="training_purchasing">
		<div class="container training_container">
			<div class="media" style="direction:{{$dir}};">
				<nav aria-label="breadcrumb"> 
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span>partnership</span>
						</li>
					</ol>
				</nav>
			</div> 
		</div> 
	</div> 

<div class="contact-area" >
	<div class="container">
 
		<div class="row">
			<p style="text-align: justify;direction: {{$dir}};">
                    {{trans('home.paragraphe_partnership')}}
			</p>

-
			<form   method="POST" action="{{route('postPartnerShip') }}" enctype="multipart/form-data"  files ="true" >
			
				{{ csrf_field() }}
			<div class="col-md-6 contact-info " style="text-align: {{$locale}}">
				@if(Session::get("locale") == "en")
				<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
					<label for="category">1. Written recommendations by two persons accredited in the field.  </label> <br/>
						<span> - First Person : </span> <br/>		
                        <input type="file" placeholder="phone" class="form-control"  id="myInput" name="first_person"/>
					

						<span> - Second person :</span> <br/>
                        <input type="file" placeholder="phone" class="form-control"  id="myInput" name="second_person"/>
						 
				</div>
				
				<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
					<label for="category"> 2. What courses do you require to be accredited at?   </label> <br/>


<input type="checkbox" name="course_choice[]"  value="اصابات رياضية"> Sport injuries  <br/>
<input type="checkbox" name="course_choice[]"  value="التغذية الرياضية"> Sport nutrition  <br/>
<input type="checkbox" name="course_choice[]"  value="مساعد مدرب لياقة بدنية">  Fitness assistant <br/>
<input type="checkbox" name="course_choice[]"  value="مدرب لياقة بدنية">Fitness instructor <br/>
<input type="checkbox" name="course_choice[]" value="مدرب شخصي">   Personal traine <br/>
<input type="checkbox" name="course_choice[]"  value=" تأهيل رياضي"> Sport rehabilitaion  <br/>

<br/> <br/>
					<label for="category">  If the course you wish to be certified at, is not listed ,please add it here.  </label> <br/>
					<input type="text"  class="form-control"  name="question4" >
				</div>
				
				<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
					<label for="category">3. What marketing plan do you follow? Please attach a sample form. </label> <br/>
                    <input type="text"  class="form-control"  name="question5" >
                    <input type="file" placeholder="phone" class="form-control"  id="myInput" name="sample_form"/>
				</div>
                @else
                
				<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label for="category">يرجى تحديد الفئة الصحيحة:   </label> <br/>
						<input type="radio"  name="category" value="Academy" onclick="afficher('inline');"> أكاديمية    <br/>

						<div class="form-group" id="cat_academy" style="display: none" >
							<label for="exampleTextarea1">اسم الاكاديمية :</label> 
							<input type="text" name="name_academy">  <br/>
							  
						  </div>
	  
						<input type="radio"  name="category" value="Individual" onclick="afficher('none');"> شخص     
					</div>

					<div class="form-group col-md-12"  style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label > :الاسم الكامل  </label>
						<input type="text" class="form-control" name="full_name">
					</div>
					<?php
					$day=0;
				    $month1=0;
				    $year=0;
			  		 ?>

					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label> تاريخ الميلاد: </label> <br/>
						
						<select name="days" class="form-control" required style="display: inline-block!important;width: 20%!important;">
							<option value="0">يوم</option>
							@for($i=1;$i<=31;$i++)
								<option value="{{$i}}" {{($i==$day)?"selected":null}}>{{$i}}</option>
							@endfor
						</select>
						<select name="months" class="form-control" required style="display: inline-block!important;width: 22%!important;">
							<option value="0">شهر</option>
							@foreach($monthsArr as $key=>$month)
								<option value="{{$key}}" {{($key==$month1)?"selected":null}}>{{$month}}</option>
							@endforeach
						</select>
						<select name="years"  class="form-control" required style="display: inline-block!important;width: 30%!important;">
							<option value="0">عام</option>
							@for($i=intval(date("Y"));$i>=1950;$i--)
								<option value="{{$i}}" {{($i==$year)?"selected":null}}>{{$i}}</option>
							@endfor
						</select>



					</div>

					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label> الجنس: </label>
						<input type="radio"  name="gender" value="Female"> انثى       
						<input type="radio"  name="gender" value="Male"> ذكر  
					</div>

					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label>المنطقة:  </label>
						<input type="text" class="form-control" name="country">
					</div>
					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label>المدينة:  </label>
						<input type="text" class="form-control" name="city">
					</div>

					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label>الهاتف:  </label>
						<input type="text" class="form-control" name="phone">
					</div>
					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label>البريد الإلكتروني:</label>
						<input type="email" class="form-control" name="email">
					</div>
					

					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label>يرجى ارفاق السيرة الذاتية : </label>
						<input type="file" placeholder="phone" class="form-control"  id="myInput" name="resume"/>
					</div>

					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label>:يرجى ارفاق شهاداتك</label>
						<input type="file" placeholder="phone" class="form-control"  name="certificates[]" multiple />
					</div>
					
					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}};">
						<label for="Message"> :رسالة تعريف </label>
						<textarea   class="form-control" name="cover_lettre"></textarea>
					</div>


				@endif
 




			</div>


			

			<div class="col-md-6 contact-form"  style="text-align: {{$locale}} ">
			
				<div id="displaycontact" class="display-none"></div>

			
					<p>  </p>
					@if(Session::get("locale") == "en")
					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label for="category">Please select the correct category :   </label> <br/>
						<input type="radio"  name="category" value="Academy" onclick="afficher('inline');"> Academy    <br/>

						<div class="form-group" id="cat_academy" style="display: none" >
							<label for="exampleTextarea1">* Name of the academy :</label> 
							<input type="text" name="name_academy">  <br/>
							  
						  </div>
	  
						<input type="radio"  name="category" value="Individual" onclick="afficher('none');"> Individual      
					</div>

					<div class="form-group col-md-12"  style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label > Full name:   </label>
						<input type="text" class="form-control" name="full_name">
					</div>


					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label> Date of birth:  </label> <br/>
						<?php
							$dayA=0;
							$month1A=0;
							$yeaAr=0;
						?>
						<select name="days" class="form-control" required style="display: inline-block!important;width: 20%!important;">
							<option value="0">day</option>
							@for($i=1;$i<=31;$i++)
								<option value="{{$i}}" {{($i==$dayA)?"selected":null}}>{{$i}}</option>
							@endfor
						</select>
						<select name="months" class="form-control" required style="display: inline-block!important;width: 22%!important;">
							<option value="0">month</option>
							@foreach($monthsArrAng as $key=>$month)
								<option value="{{$key}}" {{($key==$month1A)?"selected":null}}>{{$month}}</option>
							@endforeach
						</select>
						<select name="years"  class="form-control" required style="display: inline-block!important;width: 30%!important;">
							<option value="0">year</option>
							@for($i=intval(date("Y"));$i>=1950;$i--)
								<option value="{{$i}}" {{($i==$yeaAr)?"selected":null}}>{{$i}}</option>
							@endfor
						</select>
						
					</div>

					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label> Gender: </label>
						<input type="radio"  name="gender" value="Female"> Female      
						<input type="radio"  name="gender" value="Male"> Male  
					</div>

					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label>Country/region:  </label>
						<input type="text" class="form-control" name="country">
					</div>
					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label>City:  </label>
						<input type="text" class="form-control" name="city">
					</div>

					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label>Phone:  </label>
						<input type="text" class="form-control" name="phone">
					</div>
					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label>Email address:  </label>
						<input type="email" class="form-control" name="email">
					</div>
					

					<div class="form-group col-md-12" style="text-align:{{$locale}};direction: {{$dir}}; ">
						<label>Upload your CV : </label>
						<input type="file" placeholder="phone" class="form-control"  id="myInput" name="resume"/>
					</div>

					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
						<label>Upload your certificates:   </label>
						<input type="file" placeholder="phone" class="form-control"  name="certificates[]" multiple />
					</div>
					
					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}};">
						<label for="Message"> Cover Letter:  </label>
						<textarea  cols="20" rows="50" class="form-control form-textarea" name="cover_lettre"></textarea>
					</div>

                    @else 
                    
					<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
					<label for="category">1.	تزكية كتابية من شخصين معتمدين في المجال.  </label> <br/>
					<p> - الشخص الأول: </p> <br/>
					<input type="file" placeholder="phone" class="form-control"  id="myInput" name="first_person"/>

					<p> - الشخص الثاني: </p> <br/>
					<input type="file" placeholder="phone" class="form-control"  id="myInput" name="second_person"/>
					 
			</div>
		 
			<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
				<label> 2.	ماهي الدورات التي تطلبون الاعتماد فيها؟  </label> <br/>

				<input type="checkbox" name="course_choice[]"  value="اصابات رياضية"> اصابات رياضية  <br/>
				<input type="checkbox" name="course_choice[]"  value="التغذية الرياضية"> التغذية الرياضية <br/>
				<input type="checkbox" name="course_choice[]"  value="مساعد مدرب لياقة بدنية"> مساعد مدرب لياقة بدنية  <br/>
				<input type="checkbox" name="course_choice[]"  value="مدرب لياقة بدنية">مدرب لياقة بدنية  <br/>
				<input type="checkbox" name="course_choice[]" value="مدرب شخصي">  مدرب شخصي <br/>
				<input type="checkbox" name="course_choice[]"  value=" تأهيل رياضي"> تأهيل رياضي <br/>

<br/> <br/>
					
				<label> ان كانت الدورة التي تريد الاعتماد فيها غير مدرجة بالقائمة الرجاء اضافتها هنا   </label> <br/>
				<input type="text"  class="form-control"  name="question4" >
			</div>
			
			<div class="form-group col-md-12" style="text-align: {{$locale}};direction: {{$dir}}; ">
				<label for="category">3.	ماهي الخطة التسويقية التي تتبعونها؟ يرجى ارفاق نموذج. </label> <br/>
                <input type="text"  class="form-control"  name="question5" ><br/>
                <input type="file" placeholder="phone" class="form-control"  id="myInput" name="sample_form"/>
			</div>
		</div>
			@endif
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
	<script src="{{asset('assets/multiselect-master/multiselect-master/multiselect.min.js')}}">
	</script>

@stop

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 {{-- @extends('front/layouts/master')

 @section('meta')
	 <title>PartnerShip</title>
 
 @stop
 
 @section('content')
 @php $dir = session()->get('locale') === "ar" ? "{{$dir}}" : "ltr" @endphp
 @php $textalign = session()->get('locale') === "{{$locale}}" ? "{{$dir}}" : "left" @endphp
	 <div class="training_purchasing">
		 <div class="container training_container">
			 <div class="media" style="direction: {{$dir}}">
				 <nav aria-label="breadcrumb">
					 <ol class="breadcrumb">
						 <li class="breadcrumb-item">
							 <i class="fa fa-home" aria-hidden="true"></i>
							 <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						 </li>
						 <li class="breadcrumb-item active" aria-current="page">
							 <span>Partnership</span>
						 </li>
					 </ol>
				 </nav>
			 </div>
		 </div>
	 </div>
 
	 <div class="contact-area" >
		<div class="container">
		<form   method="POST" action="{{route('postPartnerShip') }}" enctype="multipart/form-data"  files ="true" >
			
			{{ csrf_field() }}
			
			 <div class="col-xs-12 text-{{$locale}}">
				 
					 <div class="form-group autocomplete"  >
						 <input type="text" placeholder="email" class="form-control search-name"  id="myInput" name="email"/>
					 </div>
					 <div class="form-group autocomplete"  >
						<input type="text" placeholder="phone" class="form-control search-name"  id="myInput" name="phone"/>
					</div>
					<div class="form-group autocomplete"  >
						<input type="file" placeholder="phone" class="form-control search-name"  id="myInput" name="resume"/>
					</div>
				 
				 <div class="col-md-4">
					 <div class="form-group">
						 <input type="submit" class="btn btn-md btn-success svme" value="postuler">
					 </div>
				 </div>
			 </div>
			
		 </form>
		</div>
	 </div> 
 @stop 
 
  --}}