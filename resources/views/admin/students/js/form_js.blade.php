<script>

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

		$("#passwordDiv").show();

});

var password = "";
var confirm_password = "";

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

$("#student-form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
    	first_name: {
            validators: {
                notEmpty: {
                    message: 'first name is required'
                }
            },
            required: true
        }, 
        last_name: {
            validators: {
                notEmpty: {
                    message: 'last name is required'
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

        password: password,
        confirm_password: confirm_password,
        user_id: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The user is required'
                }, 
                remote: {
                	message: 'This User is not available',
                    url: "{{url('/admin/students/unique-user')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('user_id').val(),
                            student_id: validator.getFieldElements('student_id').val()
                        };
                    }                   
                }
            },
            required: false
        }
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

$("#user_id").change(function(){
	var userId = $(this).val();
	var user = $(this);
	
	$.ajax({
		 url: '{{ url('/admin/students/user-details') }}',
		 data: {userId: userId},
		 type: "get",
		 beforeSend: function(){
			 user.closest(".form-group").find(".col-md-1").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
		},
		success: function(result){			
            $("#user_details").html(result);
			user.closest(".form-group").find(".col-md-1").children('img').remove();
		}
	});
});


$("input[name='choose_user']").change(function(){
	if($(this).val()=="exist"){
		
		$("#new_div").attr("disabled",true);
		$('#new_div :input').attr('disabled', true);
		
		$("#exist_div").attr("disabled",false);
		$('#exist_div :input').attr('disabled', false);
		
		$("#new_div").slideUp();
		$("#exist_div").slideDown();
	}else{
		
		$("#new_div").attr("disabled",false);		
		$('#new_div :input').attr('disabled', false);
		
		$("#exist_div").attr("disabled",true);
		$('#exist_div :input').attr('disabled', true);
		
		$("#exist_div").slideUp();
		$("#new_div").slideDown();
	}
	$("#student-form").bootstrapValidator('resetForm', true);
	$("#user_details").html("");
});
$("#new_div").attr("disabled",true);
$('#new_div :input').attr('disabled', true);

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});
@if(isset($student))
$(".printReport").click(printdiv);

function printdiv() {

    var iFrame = document.createElement('iframe');
    iFrame.style.position = 'absolute';
    iFrame.style.left = '-99999px';
    iFrame.src = "{{url('/admin/students/report/print/'.$student->id)}}";
    iFrame.onload = function() {
      function removeIFrame(){
        document.body.removeChild(iFrame);
        document.removeEventListener('click', removeIFrame);
      }
      document.addEventListener('click', removeIFrame, false);
    };

    document.body.appendChild(iFrame);
};
@endif

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
