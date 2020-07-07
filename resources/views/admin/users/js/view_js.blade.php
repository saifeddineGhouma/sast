<script>
$(document).ready(function() {
    $('.editable').editable({
         type: 'text',        
         url: "{{url('admin/users/editfield')}}",
         ajaxOptions: {
         	headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         },
		validate: function(value) {
		    if($.trim(value) == '') {
		        return 'This field is required';
		    }
		}
     });
	
	$("input[name='image']").change(function(){
		var _token = '<?php echo csrf_token(); ?>';	
		var id = $("#user_id").val();
		var fd = new FormData();
		
		fd.append('image', $('input[type=file]')[0].files[0]);
		fd.append('id', id);
		fd.append('_token', _token);
		var image = $(this).val();
		
		var obj = $(this);
		$.ajax({
			type: "POST",
			url: '{{url("/admin/users/editimage")}}',
			data: fd,
			processData: false,
	      	contentType: false,
			success: function(){
				$('#imageDiv').load(document.URL +  ' #imageDiv',function(responseText, textStatus, XMLHttpRequest){
			 		$('.fileinput').fileinput();
				});				
			}
		});
	});
	
    $('#status').editable({
        prepend: "not selected",
        source: [
            {value: 1, text: 'Activated'},
            {value: 2, text: 'Pending'},
            {value: 3, text: 'Deleted'}
        ],
        display: function(value, sourceData) {
             var colors = {1: "text-success", 2: "text-warning", 3: "text-danger"},
                 elem = $.grep(sourceData, function(o){return o.value == value;});
                 
             if(elem.length) {
                 $(this).text(elem[0].text).removeClass('text-success text-warning text-danger');     
                 $(this).text(elem[0].text).addClass(colors[value]); 
             }
        }   
    });    


});
password = {
    validators: {
        notEmpty: {
        	 message: 'The Password is required'
        },
        identical: {
            field: 'confirm_password',
            message: 'The password and its confirm are not the same'
        },
        different: {
            field: 'username',
            message: 'The password cannot be the same as username'
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
        },
        different: {
            field: 'username',
            message: 'The password cannot be the same as username'
        }
    }
};
$("#changepassword-form").bootstrapValidator({
    fields: {        
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