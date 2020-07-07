<script type="text/javascript">
 
//init maxlength handler
$('.maxlength-handler').maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});
$(".touchspin_1").TouchSpin({
    min: 0,
    max: 20000,
    step: 0.01,
    decimals: 2,
    boostat: 5,
    maxboostedstep: 10,
    postfix: '$'
});

$(".touchspin_2").TouchSpin({
    min: 0,
    max: 500,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: 'point'
});


$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});

$(".slug").change(function(){
	$(this).val($.trim($(this).val()));
	var slug = $(this).val().replace(/ /g, '-');
	$(this).val(slug);
});

function openKCFinder(field,hiddenField) {
    window.KCFinder = {
        callBack: function(url) {
            field.attr("src",url);
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

function openKCFinderLink(field) {
    window.KCFinder = {
        callBack: function(url) {
            var filename = url.substr(url.lastIndexOf('file/')+5);
            field.val(filename);
            window.KCFinder = null;
        },
        title: 'File Browser',
    };
    window.open('{{asset("uploads/kcfinder/browse.php?type=file")}}', 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}

$("#form1").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
        ar_name: {
            validators: {
                notEmpty: {
                    message: 'The name is required'
                }
            }
        },
        ar_slug: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The ar slug is required'
                },
                remote: {
                	message: 'The ar slug is not available',
                    url: "{{url('/admin/'.$table_name.'/unique-slug')}}",
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
        en_slug: {
         	verbose: false,// will stop validations when there is one failure validator
            validators: {
                notEmpty: {
                    message: 'The en slug is required'
                },
                remote: {
                	message: 'The en slug is not available',
                    url: "{{url('/admin/'.$table_name.'/unique-slug')}}",
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
        }
    }
}).on('success.form.bv', function(e) {

});

$(document).ready(function() {
    var areas = Array('ar_content','en_content');
    $.each(areas, function (i, area) {
    CKEDITOR.replace(area, {
    filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
    filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
    filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
    });
    });
});
</script>