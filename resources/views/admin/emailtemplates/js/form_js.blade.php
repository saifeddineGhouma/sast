<script type="text/javascript">

CKEDITOR.replace( 'body', {
	filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
	filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
	filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
	filebrowserUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=file")}}',
	filebrowserImageUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=image")}}',
	filebrowserFlashUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=flash")}}'
});
						
$("#form_emailtemplate").submit(function(e){
	var error = validateForm($(this));
	if(error>0){
		e.preventDefault();	
	}		
});
function validateForm(formid){
	var error = 0;
	
	$(formid).find("input.required,textarea.required,select.required").each(function(){		
        if($(this).val() == ""){
            $(this).closest('.form-group').children(".col-md-6").find(".help-block").remove();
			$(this).closest('.form-group').children(".col-md-6").append('<span class="help-block">هذا الحقل مطلوب</span>');
			$(this).closest('.form-group').removeClass('has-success').addClass('has-error');      
            error++;
        }else{
           $(this).closest('.form-group').children(".col-md-6").find(".help-block").remove();
			$(this).closest('.form-group').removeClass('has-error');
        }
    });
	
    return error;
}

$(document).on('click','.parm',function() {
		var val = $(this).html();
		CKEDITOR.instances['body'].insertText(val);
	});
$("#send").click(function(){
	var error = 0;	
	var subject = $('input[name="subject"]').val();
	var testmail = $('#testmail').val();
	var body = CKEDITOR.instances.body.getData();
	if(testmail == ""){
		 $(this).closest('.form-group').children(".col-md-6").find(".help-block").remove();
			$(this).closest('.form-group').children(".col-md-6").append('<span class="help-block">البريد التجريبي مطلوب</span>');
			$(this).closest('.form-group').removeClass('has-success').addClass('has-error');      
            error++;
	}else{
		 $(this).closest('.form-group').children(".col-md-6").find(".help-block").remove();
		$(this).closest('.form-group').removeClass('has-error');
	}
	if(error == 0){
		$.ajax({
			type: 'POST',
			url: "{{url('/admin/emailtemplates/sendtestmail')}}",
			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
			data:{
				'subject':subject,
				'testmail':testmail,
				'body':body	
			},
			beforeSend: function() {
				$("#send").button("loading");
			},
			success: function(json) {
				//alert(json);
				
				$("#messageStatus").html(json);
				$("#messageStatus").slideDown();
				setTimeout(function(){
					$("#messageStatus").fadeOut("slow", function(){
					});
				}, 5000);
				$("#send").button("reset");
			},
			complete: function() {
			},
			error:function (xhr, ajaxOptions, thrownError){
			}
		});
	}
	
});
</script>