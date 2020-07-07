<script>

$("#form_country").bootstrapValidator({
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
                    url: "{{url('/admin/countries/unique-name')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('country_id').val(),
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
                    url: "{{url('/admin/countries/unique-name')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('country_id').val(),
                            name: validator.getFieldElements('en_name').val()
                        };
                    }
                   
                }
            },
            required: true
        }, 
        code: {
            validators: {
                 notEmpty: {
                    message: 'The code is required'
                },
            },
            required: true
        }, 
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();
	
	var inputData = $('#form_country').serialize(); 
	    		
	$.ajax({
		url: $('#url').val(),
		type: 'post',
		beforeSend: function(){
			$(".demo-loading-btn").button('loading');
		},
		 data: inputData,
	        success: function() {	
	        	$('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
			 		$('.deletcountry').on('click', deleteRecord);
			 		$(".livicon").addLivicon();
			 		$('#table1').DataTable(options);
			 		$(".btnedit").click(edit);
				});
				
				$("#displayMessages").html("country saved successfully...");
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
