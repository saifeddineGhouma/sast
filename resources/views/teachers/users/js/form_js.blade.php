<script src="{{asset('assets/front/vendors/build/js/intlTelInput.js')}}"></script>
<script>
    $(".select2").select2({
        theme:"bootstrap",
        placeholder:"",
        width: '100%'
    });
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
        hiddenInput: "mobile",
        initialCountry: "auto",
        // nationalMode: false,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        placeholderNumberType: "MOBILE",
        // preferredCountries: ['cn', 'jp'],
        // separateDialCode: true,
        utilsScript: "{{asset('assets/front/vendors/build/js/utils.js')}}"
    });

</script>
<script type="text/javascript">

var method = $("#method").val();
$("#checkPassword").change(function(){
	if($(this).is(':checked')){
		$("#passwordDiv").slideDown();
	}else{
		$("#passwordDiv").slideUp();
	}
});
$(document).ready(function(){
	//var method = $("#method").val();
	if(method == "add"){
		$("#passwordDiv").show();
	}else{
		$("#passwordDiv").hide();
	}
});

var password = "";
var confirm_password = "";
if(method=="add"){
	password = {
            validators: {
                notEmpty: {
                	 message: 'The Password is required'
                },
                identical: {
                    field: 'confirm_password',
                    message: 'The password and its confirm are not the same'
                }
            }
       };
   confirm_password = {
            validators: {
                notEmpty: {
                	 message: 'The Confirm is required'
                },
                identical: {
                    field: 'password'
                }
            }
        };
}else{
	password = {
            validators: {
                identical: {
                    field: 'confirm_password',
                    message: 'The password and its confirm are not the same'
                }
            }
       };
   confirm_password = {
            validators: {
                identical: {
                    field: 'password'
                }
            }
        };
}
$("#form_user").bootstrapValidator({
    fields: {
        full_name_ar: {
            validators: {
                notEmpty: {
                    message: 'full name ar is required'
                }
            },
            required: true
        },
        full_name_en: {
            validators: {
                notEmpty: {
                    message: 'full name en is required'
                }
            },
            required: true
        },
        username: {
            validators: {
                notEmpty: {
                    message: 'UserName is required'
                },
                remote: {
                	message: 'The UserName is not available',
                    url: "{{url('/admin/users/unique-username')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('id').val()
                        };
                    }
                }
            },
            required: true
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'The email address is required'
                },
                emailAddress: {
                    message: 'The input is not a valid email address'
                },
                remote: {
                	message: 'The Email is not available',
                    url: "{{url('/admin/users/unique-email')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('id').val()
                        };
                    }
                }
            }
        },
        mobile: {
            validators: {
                notEmpty: {
                    message: 'The mobile is required'
                },
                remote: {
                    message: 'The Mobile is not available',
                    url: "{{url('/admin/users/unique-mobile')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('id').val()
                        };
                    }
                }
            }
        },

        password: password,
        confirm_password: confirm_password
    }
}).on('success.form.bv', function(e) {
    // Prevent form submission
   // e.preventDefault();
    //$("#roles-form").submit();
    // e.preventDefault();

});



$("#phone").change(function(){
	var phone = $("#phone").val().replace(/[^0-9]/g, '');
	$(this).val(phone);
});

$("#mobile").change(validatePhone);
function validatePhone(){
	var error = 0;
	 var phone= $("#mobile").val().replace(/[^0-9]/g, '');
	 $(this).val(phone);
    
   return error; 
}

$(".country_id").change(country_select);
function country_select(e){
    var countryId = $(this).val();
    var country = $(this);

    if(countryId!=""){
        $.ajax({
            url: "{{ url('/admin/users/governments') }}",
            data: {countryId: countryId},
            type: "get",
            beforeSend: function(){
                country.closest(".form-group").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
            },
            success: function(result){
                $("#government_id").val("");
                $("#government_id").html(result["governments"]);
                country.closest(".form-group").children('img').remove();
            },
            complete: function(){
                country.closest(".form-group").children('img').remove();
            }
        });
    }else{
        govern_div.slideUp();
    }
}
</script>