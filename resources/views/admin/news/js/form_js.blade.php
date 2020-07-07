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

    
$("#news-form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
    	en_slug: {
            validators: {
                notEmpty: {
                    message: 'en slug is required'
                }, 
                remote: {
                	message: 'The En slug is not available',
                    url: "{{url('/admin/news/unique-slug')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('id').val(),
                            slug: validator.getFieldElements('en_slug').val()
                        };
                    }
                   
                }
            },
            required: true
        },
        ar_slug: {
            validators: {
                notEmpty: {
                    message: 'ar slug is required'
                }, 
                remote: {
                	message: 'The Ar slug is not available',
                    url: "{{url('/admin/news/unique-slug')}}",
                    type: 'GET',
                    data: function(validator) {
                        return {
                            id: validator.getFieldElements('id').val(),
                            slug: validator.getFieldElements('ar_slug').val()
                        };
                    }
                   
                }
            },
            required: true
        },
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
    // Prevent form submission
   // e.preventDefault();
    //$("#roles-form").submit();
    // e.preventDefault();

    

});
 


</script>
