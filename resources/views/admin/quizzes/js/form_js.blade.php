<script type="text/javascript">
 
//init maxlength handler
$('.maxlength-handler').maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});
$(".touchspin_1").TouchSpin({
    min: 0,
    max: 300,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 10,
    postfix: 'minute'
});
$(".touchspin_2").TouchSpin({
    min: 0,
    max: 20000,
    step: 0.01,
    decimals: 2,
    boostat: 5,
    maxboostedstep: 10,
    postfix: 'degree'
});
$(".touchspin_3").TouchSpin({
    min: 0,
    max: 300,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 10,
    postfix: 'question'
});

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});

$(".touchspin_2").TouchSpin({
    min: 0,
    max: 500,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: 'degree'
});

$(".touchspin_3").TouchSpin({
    min: 0,
    max: 300,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 10,
    postfix: 'question'
});

$(".slug").change(function(){
	$(this).val($.trim($(this).val()));
	var slug = $(this).val().replace(/ /g, '-');
	$(this).val(slug);
});


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
    var areas = Array('ar_finish_message','en_finish_message','ar_finish_message_pass','en_finish_message_pass');
    $.each(areas, function (i, area) {
    CKEDITOR.replace(area, {
    filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
    filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
    filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
    });
    });
});

function addCourse(){
    var id =  1;
    var lastRow = $('#courses > tbody');

    if($('#courses tbody>tr:last').data("id")){
        id = parseInt($('#courses tbody>tr:last').data("id"))+1;
    }

    lastRow.append('<tr id="course-row'+id+'" data-id="'+id+'">'+
        '<td class="text-left">'+
        '<select name="courses['+id+'][course_id]" class="form-control select2">'+
            @foreach($courses as $course)
                '<option value="{{$course->id}}">'+
        '{{ $course->course_trans("ar")->name }}'+
        '</option>'+
            @endforeach
                '</select>'+
        '</td>'+
        '<td>'+
        '<input type="checkbox" name="courses['+id+'][active]">'+
        '</td>'+
            @if($from_section=="exam")
                '<td>'+
        '<input type="number" class="form-control" name="courses['+id+'][attempts]">'+
        ' </td>'+
            @endif
        '<td class="text-left"><button type="button" onclick="$(\'#course-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ');
    $(".select2").select2({
        theme:"bootstrap",
        placeholder:"",
        width: '100%'
    });
    $('.date-picker').datepicker({
        orientation: "left",
        autoclose: true
    });
}
$('.date-picker').datepicker({
    orientation: "left",
    autoclose: true
});
</script>