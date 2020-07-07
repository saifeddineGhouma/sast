<script>

$("#form_agent").bootstrapValidator({
	excluded: [':disabled'],
	framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
       name: {
            validators: {
                notEmpty: {
                    message: 'The Name is required'
                }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();
	
	var inputData = $('#form_agent').serialize();
	    		
	$.ajax({
		url: $('#url').val(),
		type: 'post',
		beforeSend: function(){
			$(".demo-loading-btn").button('loading');
		},
		 data: inputData,
	        success: function() {	
	        	$("#country_search").trigger("change");
				
				$("#displayMessages").html("agent saved successfully...");
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
