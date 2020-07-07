<script type="text/javascript">

CKEDITOR.replace('', {
	filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
	filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
	filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
	filebrowserUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=file")}}',
	filebrowserImageUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=image")}}',
	filebrowserFlashUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=flash")}}'
});
						


$(document).on('click','.parm',function() {
		var val = $(this).html();
		CKEDITOR.instances['content_en'].insertText(val);
	});
$(document).on('click','.parm_ar',function() {
		var val = $(this).html();
		CKEDITOR.instances['content_ar'].insertText(val);
	});

$("#form_template").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: 'The name is required'
                }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {	
   

});
</script>