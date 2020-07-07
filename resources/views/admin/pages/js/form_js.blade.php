<script type="text/javascript">

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

$("#pages-form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
        en_title: {
            validators: {
                notEmpty: {
                    message: 'The title is required'
                }
            },
            required: true
        },
         ar_slug: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The ar slug is required'
                }, 
                remote: {
                	message: 'The ar slug is not available',
                    url: "{{url('/admin/pages/unique-slug')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('pageid').val(),
                            slug: validator.getFieldElements('ar_slug').val()
                        };
                    }
                }
            },
            required: true
        },
        en_slug: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The en slug is required'
                }, 
                remote: {
                	message: 'The en slug is not available',
                    url: "{{url('/admin/pages/unique-slug')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('pageid').val(),
                            slug: validator.getFieldElements('en_slug').val()
                        };
                    }
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
	

	
	$('input[name="ar_content"]').val($('#tinymce_full_ar').val());
	
	$('input[name="en_content"]').val($('#tinymce_full_en').val());
	
	


});  
$(document).ready(function() {
    var areas = Array('tinymce_full_en','tinymce_full_ar');
    $.each(areas, function (i, area) {
        CKEDITOR.replace(area, {
            filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
            filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
            filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
        });
    });
    $(".ckeditor").each(function(){
        var area= $(this).attr("id");
        CKEDITOR.replace(area, {
            filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
            filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
            filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
        });
    });
    $('.study_choise:checked').each(function(){
       if($(this).val()=="pdf"){
           $(this).closest("tr").find(".pdf").show();
           $(this).closest("tr").find(".video").hide();
           $(this).closest("tr").find(".content_html").hide();
       }else if($(this).val()=="video"){
           $(this).closest("tr").find(".video").show();
           $(this).closest("tr").find(".pdf").hide();
           $(this).closest("tr").find(".content_html").hide();
       }
       else{
           $(this).closest("tr").find(".content_html").show();
           $(this).closest("tr").find(".video").hide();
           $(this).closest("tr").find(".pdf").hide();

       }
    });

});
 
</script>
