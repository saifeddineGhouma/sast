<script>

$("#form_government").bootstrapValidator({
	excluded: [':disabled'],
	framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
       en_name: {
            validators: {
                notEmpty: {
                    message: 'The En Name is required'
                }, 
                remote: {
                	message: 'The En Name is not available',
                    url: "{{url('/admin/governments/unique-name')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('government_id').val(),
                            name: validator.getFieldElements('en_name').val()
                        };
                    }
                   
                }
            },
            required: true
        }, 
        ar_name: {
            validators: {
                remote: {
                	message: 'The Ar Name is not available',
                    url: "{{url('/admin/governments/unique-name')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('government_id').val(),
                            name: validator.getFieldElements('en_name').val()
                        };
                    }
                   
                }
            },
            required: true
        }, 
        country_id: {
            validators: {
            	notEmpty: {
                    message: 'The country is required'
               }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();
	
	var inputData = $('#form_government').serialize(); 
	    		
	$.ajax({
		url: $('#url').val(),
		type: 'post',
		beforeSend: function(){
			$(".demo-loading-btn").button('loading');
		},
		 data: inputData,
	        success: function() {	
	        	$("#country_search").trigger("change");
				
				$("#displayMessages").html("government saved successfully...");
	            $("#displayMessages").slideDown();
	          
	           setTimeout(function(){
					$("#displayMessages").fadeOut("slow", function(){
					});
				}, 5000);
				
               $("#modal-2").modal("hide"); 
				
				
				
	        },
	        error: function( data ) {
	            var errors = data.responseJSON;
	            
	            $('#errorDiv').show();
	             $('#errorul').html("");
	            $.each(errors,function(k,v){			            	
	            	$('#errorul').append('<li>'+v+'</li>');
	            });
	        },
	        complete: function(){
	        	$(".demo-loading-btn").button('reset');
	        }
	});
	
});
	


</script>
