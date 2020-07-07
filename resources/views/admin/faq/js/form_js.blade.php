<script>

$("#sort_order").change(function(){
	var sort_order = $("#sort_order").val().replace(/[^0-9]/g, '');
	$(this).val(sort_order);
});
$("#form_faq").bootstrapValidator({
	excluded: [':disabled'],
	framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        ar_question: {
            validators: {
                notEmpty: {
                    message: 'The Ar Question is required'
                }
            },
            required: true
        }, 
        ar_answer: {
            validators: {
                notEmpty: {
                    message: 'The Ar answer is required'
                }
            },
            required: true
        }, 
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();
	
	var inputData = $('#form_faq').serialize(); 
	    		
	$.ajax({
		url: $('#url').val(),
		type: 'post',
		beforeSend: function(){
			$(".demo-loading-btn").button('loading');
		},
		data: inputData,
	        success: function() {	
	        	$('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
			 		$('.deletefaq').on('click', deleteRecord);
			 		$(".livicon").addLivicon();
			 		$('#table1').DataTable(options);
			 		$(".btnedit").click(edit);
				});
				
				$("#displayMessages").html("faq saved successfully...");
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
