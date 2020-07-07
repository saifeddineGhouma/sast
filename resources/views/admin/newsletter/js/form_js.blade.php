<script type="text/javascript">
CKEDITOR.replace( 'body', {
	filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
	filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
	filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
	filebrowserUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=file")}}',
	filebrowserImageUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=image")}}',
	filebrowserFlashUploadUrl: '{{asset("uploads/kcfinder/upload.php?type=flash")}}'
});
$(document).ready(function(){
	$("#touchspin_2").val($("#repeated").val());
})

$("#touchspin_2").TouchSpin({
	    min: 1,
	    max: 500,
	    step: 1,
	    decimals: 0,
	    boostat: 5,
	    maxboostedstep: 20,
	    postfix: 'days'
	});
$("#checkbydate").change(function() {
    if( $('#checkbydate').is(':checked')) {
    	$("#sendByDate").show("slow");                    
    	 $('#SubmiteButton').html('save');                    	
    }else{
    	$("#sendByDate").hide("slow");
    	$('#SubmiteButton').html('send');  
    }
});
$("#checkbydate").trigger("change"); 

//$("#sendto").change(function(){
//	var input = $(this);
//	if(input.val()==2){
//		$("#clientgroup").show("slow");
//	}else{
//		$("#clientgroup").hide("slow");
//	}
//});
$("#sendto").trigger("change");
 
$("#emailtemplate").change(function(){
	var input = $(this);
	if($(this).val()!=""){
		$.ajax({
			type: 'GET',
				url: "{{url('/admin/newsletter/template/')}}"+"/"+$(this).val(),
				
				beforeSend: function() {
					input.closest(".form-group").find(".col-md-1").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
				},
				success: function(result) {
					
					input.closest(".form-group").find(".col-md-1").children('img').remove();
					if(result.subject != undefined){
						$("input[name='subject']").val(result.subject);
					}
					if(result.body != undefined){
						CKEDITOR.instances.body.setData(result.body);
						  
					}
						
				},				
				error:function (xhr, ajaxOptions, thrownError){
				}
			});
	}
});


$("#form_newsletter").submit(function(e){
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
			$(this).closest('.form-group').children(".col-md-6").append('<span class="help-block">This field is required</span>');
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

</script>