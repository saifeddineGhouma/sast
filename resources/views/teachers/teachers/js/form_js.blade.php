<script type="text/javascript">
 
//init maxlength handler
$('.maxlength-handler').maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
}); 

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});
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

    $("#passwordDiv").hide();

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

function addSocial(){
	var id =  1;
	var lastRow = $('#socials > tbody');
	
	if($('#socials tbody>tr:last').data("id")){
		id = parseInt($('#socials tbody>tr:last').data("id"))+1;
	}
	
	lastRow.append('<tr id="link-row'+id+'" data-id="'+id+'">'+
		         ' <td class="text-left">'+
		          	'<a href="javascript:void(0)">'+
		          		'<input type="text" name="socials['+id+'][name]" class="form-control">'+
		          	'</a>'+
		          '</td>'+
		          '<td>'+
		          	'<select class="form-control" name="socials['+id+'][font]">'+
		          		@foreach($socialArray as $key=>$value)
		          			'<option value="{{$key}}">{{$value}}</option>'+
		          		@endforeach
		          	'</select>'+		          	
		          '</td>'+
		          '<td class="text-right">'+
		          	'<input type="text" name="socials['+id+'][link]" class="form-control">'+
		          '</td>'+
		          '<td class="text-left"><button type="button" onclick="$(\'#link-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
		        '</tr>');
	
}

$("#form_teacher").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
    	ar_name: {
            validators: {
            	notEmpty: {
                    message: 'The Ar Name is required'
                }
            },
            required: true
        },
        en_name: {
	        validators: {
	        	notEmpty: {
	                message: 'The En Name is required'
	            }
	        },
	        required: true
        },
        ar_job: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The ar job is required'
                }
            },
            required: true
        },
        en_job: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The en job is required'
                }
            },
            required: true
        },
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
                    url: "{{url('/teachers/unique-username')}}",
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
                    url: "{{url('/teachers/unique-email')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('id').val()
                        };
                    }
                }
            }
        },
        password : {
            validators: {
                identical: {
                    field: 'confirm_password',
                    message: 'The password and its confirm are not the same'
                }
            }
        },
        confirm_password : {
            validators: {
                identical: {
                    field: 'password'
                }
            }
        },
        user_id: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The user is required'
                }, 
                remote: {
                	message: 'This User is not available',
                    url: "{{url('/teachers/unique-user')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('user_id').val(),
                            teacher_id: validator.getFieldElements('teacher_id').val()
                        };
                    }                   
                }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {
	
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
$(".country_id").change(country_select);
function country_select(e){
    var countryId = $(this).val();
    var country = $(this);

    if(countryId!=""){
        $.ajax({
            url: "{{ url('/teachers/home/governments') }}",
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