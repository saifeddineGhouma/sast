<script type="text/javascript">
$(".touchspin_1").TouchSpin({
    min: 0,
    max: 20000,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 10,
    postfix: '%'
}); 

$(".touchspin_2").TouchSpin({
    min: 0,
    max: 20000,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 10,
    postfix: 'user'
});   

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});

$("#form_coupon").bootstrapValidator({
	excluded: [':disabled'],
	framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        coupon_number: {
            validators: {
                notEmpty: {
                    message: 'The coupon number is required'
                },
                remote: {
	            	message: 'The coupon number is not available',
	                url: "{{url('/admin/coupons/unique-number')}}",
	                type: 'GET',
	                data: function(validator) {
	                    return {
	                        id: validator.getFieldElements('id').val()
	                    };
	                }
	               
	            }
            },
            
        },
        date_from: {
            validators: {
                notEmpty: {
                    message: 'date from is required'
                }
            },
            required: true
        },
        date_to: {
            validators: {
                notEmpty: {
                    message: 'date to is required'
                }
            },
            required: true
        },
    }
}).on('success.form.bv', function(e) {
   
	
});

$("input[name='date_from']").on('changeDate show', function(e) {
    $('#form_coupon').bootstrapValidator('revalidateField', 'date_from'); 
});
$("input[name='date_to']").on('changeDate show', function(e) {
    $('#form_coupon').bootstrapValidator('revalidateField', 'date_to');
});

</script>