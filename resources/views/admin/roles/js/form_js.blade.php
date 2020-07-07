<script>
	
	

$("#roles-form").bootstrapValidator({
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: 'name is required'
                }
            },
            required: true
        },
         display_name: {
            validators: {
                notEmpty: {
                    message: 'display name is required'
                }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {
    // Prevent form submission
   // e.preventDefault();
    //$("#roles-form").submit();
    // e.preventDefault();

    

});
 


</script>
