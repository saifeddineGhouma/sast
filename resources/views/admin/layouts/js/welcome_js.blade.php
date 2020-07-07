<script type="text/javascript">
$("#quickmail_form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
        quick_email: {
            validators: {
                notEmpty: {
                    message: 'The email is required'
                },
	            emailAddress: {
	                message: 'The email is not a valid email address',
	                multiple: true
	            }
            },
            required: true
        },
         quick_subject: {
            validators: {
                notEmpty: {
                    message: 'The subject is required'
                }
            },
            required: true
        },
         quick_message: {
            validators: {
                notEmpty: {
                    message: 'The message is required'
                }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {
	e.preventDefault();
	
	var formData = $("#quickmail_form").serializeArray();
	    		
	$.ajax({
		url: $("#quickmail_form").attr("action"),
		type: 'post',
		beforeSend: function(){
			$("#quick_send").button('loading');
		},
		data: formData,
        success: function(result) {
			$("#quick_result_message").html(result);
			$("#quick_result_message").slideDown();
			setTimeout(function(){
				$("#quick_result_message").fadeOut("slow", function(){
				});
			}, 5000);
			
			$("input[name='quick_email']").val("");
			$("input[name='quick_subject']").val("");
			$("textarea[name='quick_message']").val("");
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
        	$("#quick_send").button('reset');
        }
	});
});

var demo = new CountUp("myTargetElement1", 12.52, {{$auctionsToday}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement2", 1, {{$totalNumbers}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement3", 24.02, {{$countSubscriberToday}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement4", 1254, {{$countUsersToday}}, 0, 6, options);
        
        demo.start();
        var demo = new CountUp("myTargetElement1.1", 1254, {{$auctionslastweak}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement1.2", 1254, {{$auctionslastmonth}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement2.1", 154, {{$totalNumberslastWeak}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement2.2", 2582, {{$totalNumberslastMonth}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement3.1", 2582, {{$countSubscriberWeak}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement3.2", 25858, {{$countSubscriberMonth}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement4.1", 2544, {{$countUsersWeak}}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement4.2", 1584, {{$countUsersMonth}}, 0, 6, options);
        demo.start();
</script>