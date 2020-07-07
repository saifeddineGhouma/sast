@extends('front/layouts/master')

@section('meta')
{{-- @php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $locale = session()->get('locale'); @endphp --}}
<script type="text/javascript">
	function afficher(etat)
	{   
		document.getElementById("cat_academy").style.display=etat;   
	}
</script>
@section('styles')
	<link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
@stop
@section('content')
	<div class="training_purchasing">
		<div class="container training_container">
			<div class="media" style="direction: rtl;">
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
			<p style="text-align: justify;direction: rtl;">
			ان الأكاديمية السويدية للتدريب الرياضي SAST هي أكاديمية رياضية تأسست في السويد من قبل بعض الخبراء الدوليين والاساتذة الأكاديميين والمدربين وبمختلف التخصصات الرياضية وعلى اعلى المستويات وقد بدأت بنشر الخبرات والمعارف الرياضية بمختلف مجالاتها الاكاديمية والتدريبية والمهنية.   تستمد الاكاديمية قوتها من الاعتمادات الدولية والعالمية وتعد شهاداتها المصدرة شهادات مصادق عليها من طرف REPS Tunisia  التي هي جزء من الاتحاد الدولي لسجلات المحترفين المهنين في مجال التدريب(IC REPS)  و معتمدة أيضا من المجلس العالمي للعلوم الرياضية في السويد  (GCSS). ان المدربين المنخرطين معنا هم من خيرة المدربين لذلك من ضمن استراتيجية الأكاديمية ان تختار نخبة وأفضل المدربين الطموحين للحفاظ على جودة تعليمنا ومناهجنا لذلك نحن منفتحين على كافة أشكال وطلبات التعاون سواء كانت من أفراد أو مؤسسات ولأن اسم الأكاديمية هو الاهم في حساباتنا فنحن ملتزمون بمعايير الجودة العالمية في كل المستويات.

			</p>

-
			<form   method="POST" action="{{route('postPartnerShip') }}" enctype="multipart/form-data"  files ="true" >
			
				{{ csrf_field() }}
			<div class="col-md-6 contact-info " style="text-align: right">
				

				<div class="form-group col-md-12" style="text-align: right;direction: rtl; ">
					<label for="category">يرجى تحديد الفئة الصحيحة:   </label> <br/>
					<input type="radio"  name="category" value="Academy" onclick="afficher('inline');"> أكاديمية    <br/>

					<div class="form-group" id="cat_academy" style="display: none" >
						<label for="exampleTextarea1">اسم الاكاديمية :</label> 
						<input type="text" name="name_academy">  <br/>
						  
					  </div>
  
					<input type="radio"  name="category" value="Individual" onclick="afficher('none');"> شخص     
				</div>

				<div class="form-group col-md-12"  style="text-align:right;direction: rtl; ">
					<label > :الاسم الكامل  </label>
					<input type="text" class="form-control" name="full_name">
				</div>
				<?php
				$day=0;
				$month1=0;
				$year=0;
				   ?>

				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label> تاريخ الميلاد: </label> <br/>
					
					<select name="days" class="form-control" required style="display: inline-block!important;width: 20%!important;" required >
						<option value="">يوم</option>
						@for($i=1;$i<=31;$i++)
							<option value="{{$i}}" {{($i==$day)?"selected":null}}>{{$i}}</option>
						@endfor
					</select>
					<select name="months" class="form-control" required style="display: inline-block!important;width: 22%!important;" required >
						<option value="">شهر</option>
						@foreach($monthsArr as $key=>$month)
							<option value="{{$key}}" {{($key==$month1)?"selected":null}}>{{$month}}</option>
						@endforeach
					</select>
					<select name="years"  class="form-control" required style="display: inline-block!important;width: 30%!important;" required >
						<option value="">عام</option>
						@for($i=intval(date("Y"));$i>=1950;$i--)
							<option value="{{$i}}" {{($i==$year)?"selected":null}}>{{$i}}</option>
						@endfor
					</select>



				</div>

				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label> الجنس: </label>
					<input type="radio"  name="gender" value="Female"> انثى       
					<input type="radio"  name="gender" value="Male"> ذكر  
				</div>

				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label>العنوان:  </label>
					<input type="text" class="form-control" name="country">
				</div>
				

				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label>رقم الهاتف :  </label>
					<input type="text" class="form-control" name="phone" id="mobile">
				</div>
				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label>البريد الإلكتروني:</label>
					<input type="email" class="form-control" name="email">
				</div>
				

				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label>يرجى ارفاق السيرة الذاتية : </label>
					<input type="file" placeholder="phone" class="form-control"  id="myInput" name="resume" required />
				</div>

				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label> يرجى ارفاق شهاداتك :</label>
					<input type="file" placeholder="phone" class="form-control"  name="certificates[]" multiple  required />
				</div>
				
				<div class="form-group col-md-12" style="text-align:right;direction: rtl;">
					<label for="Message"> رسالة تعريف : </label>
					<textarea   class="form-control" name="cover_lettre"></textarea>
				</div>




			</div>


			

			<div class="col-md-6 contact-form"  style="text-align: right ">
			
				<div id="displaycontact" class="display-none"></div>

			
					<p>  </p>
					

					<div class="form-group col-md-12" style="text-align: right;direction: rtl; ">
						<label for="category">1.	تزكية كتابية من شخصين معتمدين في المجال.  </label> <br/>
						<p> - الشخص الأول: </p> <br/>
						<input type="file" placeholder="phone" class="form-control"  id="myInput" name="first_person"/>
	
						<p> - الشخص الثاني: </p> <br/>
						<input type="file" placeholder="phone" class="form-control"  id="myInput" name="second_person"/>
						 
				</div>
			 
				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label> 2.	ماهي الدورات التي تطلبون الاعتماد فيها؟  </label> <br/>

						<input type="checkbox" name="course_choice[]"  value="اصابات رياضية"> اصابات رياضية  <br/>
						<input type="checkbox" name="course_choice[]"  value="التغذية الرياضية"> التغذية الرياضية <br/>
						<input type="checkbox" name="course_choice[]"  value="مساعد مدرب لياقة بدنية"> مساعد مدرب لياقة بدنية  <br/>
						<input type="checkbox" name="course_choice[]"  value="مدرب لياقة بدنية">مدرب لياقة بدنية  <br/>
						<input type="checkbox" name="course_choice[]" value="مدرب شخصي">  مدرب شخصي <br/>
						<input type="checkbox" name="course_choice[]"  value=" تأهيل رياضي"> تأهيل رياضي <br/>
						{{-- <input type="checkbox" name="course_choice[]"  value=" دورة اليوغا"> دورة اليوغا <br/>
						<input type="checkbox" name="course_choice[]" value="مدرب البيلاتيس"> مدرب البيلاتيس <br/>
						<input type="checkbox" name="course_choice[]"  value="القوة و التكيف"> القوة و التكيف
				 --}}
						<br/> <br/>
					<label> ان كانت الدورة التي تريد الاعتماد فيها غير مدرجة بالقائمة الرجاء اضافتها هنا   </label> <br/>
					<input type="text"  class="form-control"  name="question4" >
				</div>
				
				<div class="form-group col-md-12" style="text-align:right;direction: rtl; ">
					<label for="category">3.	ماهي الخطة التسويقية التي تتبعونها؟ يرجى ارفاق نموذج. </label> <br/>
					<input type="text"  class="form-control"  name="question5" ><br/>
					<input type="file" placeholder="phone" class="form-control"  id="myInput" name="sample_form"/>
				</div>
			</div>

					















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
@stop

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 {{-- @extends('front/layouts/master')

 @section('meta')
	 <title>PartnerShip</title>
 
 @stop
 
 @section('content')
 @php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
 @php $textalign = session()->get('locale') === "right" ? "rtl" : "left" @endphp
	 <div class="training_purchasing">
		 <div class="container training_container">
			 <div class="media" style="direction: rtl">
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
			
			 <div class="col-xs-12 text-right">
				 
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