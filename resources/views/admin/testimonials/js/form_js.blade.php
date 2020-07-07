<script>
//init maxlength handler
$('.maxlength-handler').maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});

$(".slug").change(function(){
	$(this).val($.trim($(this).val()));
	var slug = $(this).val().replace(/ /g, '-');
	$(this).val(slug);
});

function openKCFinder(field,hiddenField) {
    window.KCFinder = {
        callBack: function(url) {
            field.attr("src",url) ;
           	var filename = url.substr(url.lastIndexOf('image/')+6);
        	hiddenField.val(filename);
            window.KCFinder = null;
        },
        title: 'File Browser',
    };
	window.open('{{asset("uploads/kcfinder/browse.php?type=image")}}', 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
} 


    
$("#testimonials-form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {    	
        ar_title: {
            validators: {
                notEmpty: {
                    message: 'title ar is required'
                }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {

});
 


</script>
