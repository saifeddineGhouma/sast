<script>
	jQuery("#login-form").submit(function(e){
		var error = commonValidateForm(jQuery(this));
		if(error>0)
			e.preventDefault();
	});
	
	function commonValidateForm(formid){	
		var error = 0;
		
		jQuery(formid).find("input.required,textarea.required,select.required").each(function(){	
			
	        if(jQuery(this).val() == ""){        	
	            jQuery(this).closest('.form-group').find(".help-block").remove();
				jQuery(this).closest('.form-group').append('<span class="help-block"><?php echo e(trans("home.this_field_required")); ?></span>');
				jQuery(this).closest('.form-group').addClass('has-error');
	            error++;
	        }else if(validatedEmail){
	           jQuery(this).closest('.form-group').find(".help-block").remove();
				jQuery(this).closest('.form-group').removeClass('has-error');
	        }
	    });
	    return error;
	 }
	function validate_input(input){
		var error = 0;
		
		if(input.val() == ""){
            input.closest('.form-group').find(".help-block").remove();
			input.closest('.form-group').append('<span class="help-block"><?php echo e(trans("home.this_field_required")); ?></span>');
			input.closest('.form-group').addClass('has-error');
            error++;
        }else{
           input.closest('.form-group').find(".help-block").remove();
			input.closest('.form-group').removeClass('has-error');
        }
	}
	
	jQuery(".required").change(function(){			
		validate_input(jQuery(this));
	});
	
	jQuery("input[name='mobile']").change(function(){
		var mobile = jQuery("input[name='mobile']").val().replace(/[^0-9]/g, '');
		jQuery(this).val(mobile);
	});
	

    $("input[name='mobile1']").keyup(function() {
        if (this.value.match(/[^0-9 ]/g)) {
            this.value = this.value.replace(/[^0-9 ]/g, '');
        }
    });
	jQuery("#register-form").bootstrapValidator({
	    fields: {
	    	
	        username: {
	            validators: {
	                notEmpty: {
	                    message: '<?php echo e(trans("home.username_required")); ?>'
	                },
	                remote: {
	                	message: 'اسم المستخدم غير متاح',
	                    url: "<?php echo e(url('/home/unique-username')); ?>",
	                    type: 'GET',
	                    data: function(validator) {
	                        return {
	                            id: 0
	                        };
	                    }
	                }
	            },
	            required: true
	        },
	        email: {
	            validators: {
	                notEmpty: {
	                    message: '<?php echo e(trans("home.email_required")); ?>'
	                },
	                emailAddress: {
	                    message: 'البريد الإلكتروني غير صالح'
	                },
	                remote: {
	                	message: 'The Email is not available',
	                    url: "<?php echo e(url('/home/unique-email')); ?>",
	                    type: 'GET',
	                    data: function(validator) {
	                        return {
	                            id: 0
	                        };
	                    }
	                }
	            }
	        },
            mobile1: {
                validators: {
                    notEmpty: {
                        message: '<?php echo e(trans("home.this_field_required")); ?>'
                    }
                },
                required: true
            },
	        password : {
	            validators: {
	                notEmpty: {
	                	 message: '<?php echo e(trans("home.password_required")); ?>'
	                },
	                identical: {
	                    field: 'confirm_password',
	                    message: '<?php echo e(trans("home.password_confirm_not_same")); ?>' 
	                },
                    stringLength: {
                        min: 6,
                        message: 'من فضلك ادخل اكثر من 6 حروف'
                    }
	            }
	       },
	   	   confirm_password : {
	            validators: {
	                notEmpty: {
	                	 message: '<?php echo e(trans("home.confirm_required")); ?>'
	                },
	                identical: {
	                    field: 'password'
	                }
	            }
	       },
            agreement: {
		            validators: {
		                notEmpty: {
		                    message: '<?php echo e(trans("home.you_should_agree")); ?>'
		                }
		            },
		            required: true
		        }
	    }
	}).on('success.form.bv', function(e) {


	
	});
</script>