<script>
var method = $("#methodForm").val();
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

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
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
$("#admins-form").bootstrapValidator({
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: 'name is required'
                }
            },
            required: true
        }, 
        username: {
            validators: {
                notEmpty: {
                    message: 'UserName is required'
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
                }
            }
        },
        role_id: {
            validators: {
                notEmpty: {
                    message: 'The role is required'
                }
            },
            required: true
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
	


</script>
