<script type="text/javascript">
 $('.btn_active').on('click',function(){alert('Ok')});
//init maxlength handler
$('.maxlength-handler').maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
}); 

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
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
    max: 1000,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: 'day'
});
$(".touchspin_3").TouchSpin({
    min: 0,
    max: 500,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: 'point'
});
$(".touchspin_4").TouchSpin({
    min: 0,
    max: 500,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: 'student'
});
$(".touchspin_5").TouchSpin({
    min: 0,
    max: 100,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: '%'
});
$(".touchspin_6").TouchSpin({
    min: 0,
    max: 500,
    step:1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: 'ساعة'
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
        period: {
            validators: {
                notEmpty: {
                    message: 'The period is required'
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
    var onlineRowCount = $('#variations_online tr').length;
    var presenceRowCount = $('#variations_classroom tr').length;
    if(onlineRowCount + presenceRowCount <= 4){
        e.preventDefault();
        $("#courseTypeMessage").slideDown();
    }
    $("#submitbtn").prop("disabled",false);
});
$(document).ready(function() {
    var areas = Array('ar_content_online','ar_content_classroom','en_content_online','en_content_presence','description_all_exam','description_quiz','desciption_exam','description_exam_video','description_stage');
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
$("input[name='online']").change(function(){
   if($(this).is(":checked")){
       $("#online_div").slideDown();
   }else{
       $("#online_div").slideUp();
   }
});
$("input[name='online']").trigger("change");

$("input[name='presence']").change(function(){
    if($(this).is(":checked")){
        $("#presence_div").slideDown();
    }else{
        $("#presence_div").slideUp();
    }
});
$("input[name='presence']").trigger("change");

$("select.country").change(country_select);
function country_select(e){
    var countryId = $(this).val();
    var country = $(this);

    var rowId = $(this).data("id");
    $.ajax({
        url: '{{ url('/admin/courses/governments') }}',
        data: {countryId: countryId},
        type: "get",
        beforeSend: function(){
            country.parent().append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
        },
        success: function(result){
			 
            $("#variation_classroom-row"+rowId).find(".govern").html(result);
            country.parent().children('img').remove();
        }
    });
}

function addVariation(type){
    var id =  1;
    var lastRow = $('#variations_'+type+' > tbody');
    var trLast = $('#variations_'+type+' tbody>tr:last');
    if(trLast.data("id")){
        id = parseInt(trLast.data("id"))+1;
    }
    var htmltmp = '<tr id="variation_'+type+'-row'+id+'" data-id="'+id+'">'+
        ' <td class="text-left">'+
            '<select name="variations'+type+'['+id+'][teacher_id]" class="form-control">'+
                @foreach($teachers as $teacher)
                    '<option value="{{$teacher->id}}">{{$teacher->user->full_name_ar}}</option>'+
                @endforeach
             '</select>'+
        '</td>';
        if(type == "classroom")   {
            htmltmp +='<td>'+
                '<select name="variations'+type+'['+id+'][country_id]" data-id="'+id+'" class="form-control country">'+
                    @foreach($countries as $country)
                       ' <option value="{{$country->id}}">{{trim($country->country_trans("en")->name)}}</option>'+
                    @endforeach
                '</select>'+
            '</td>'+
            '<td class="text-right">'+
                '<select name="variations'+type+'['+id+'][govern_id]" class="form-control govern">'+
                        @foreach($governments as $government)
                            '<option value="{{$government->id}}">{{$government->government_trans("en")->name}}</option>'+
                        @endforeach
                '</select>'+
            '</td>'+
            '<td class="text-right">'+
            '<div class="input-group input-large date-picker input-daterange"  data-date-format="yyyy-mm-dd">'+
            '<input type="text"  class="form-control" name="variations'+type+'['+id+'][date_from]">'+
            '<span class="input-group-addon"> to </span>'+
            '<input type="text" class="form-control" name="variations'+type+'['+id+'][date_to]">'+
            '</div>'+
            '</td>'	;
        }

    htmltmp += '<td class="text-right">'+
            '<input  type="text"  name="variations'+type+'['+id+'][price]" class="form-control touchspin_1" value="0"><br>'+
			'<div class="col-md-6" style="padding-left:0;">'+
            '<input  type="text"  name="variations'+type+'['+id+'][priceautre]" class="form-control" value="0">'+
			'</div>'+
			'<div class="col-md-6" style="padding-right:0;">'+
            '<select name="variations'+type+'['+id+'][pricedevise]" class="form-control">'+
			'<option value="TND">TND</option>'+
			'<option value="USD">USD</option>'+
			'<option value="GBP">GBP</option>'+
			'<option value="JPY">JPY</option>'+
			'<option value="KWD">KWD</option>'+
			'<option value="EGP">EGP</option>'+
			'<option value="QAR">QAR</option>'+
			'<option value="MAD">MAD</option>'+
			'<option value="BHD">BHD</option>'+
            '</select>'+
			'</div>'+
        '</td>'+
        ' <td class="text-right">'+
            '<select name="variations'+type+'['+id+'][certificate_id]" class="form-control">'+
                @foreach($certificates as $certificate)
                    '<option value="{{$certificate->id}}">{{ trim($certificate->name_ar) }}</option>'+
                @endforeach
            '</select>'+
        '</td>'+
        '<td class="text-left"><button type="button" onclick="$(\'#variation_'+type+'-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ';
    lastRow.append(htmltmp);
    var currentRow = $('#variation_'+type+'-row'+id);
    currentRow.find(".country").change(country_select);
    currentRow.find(".country").trigger("change");
    currentRow.find(".touchspin_1").TouchSpin({
        min: 0,
        max: 20000,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '$'
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

function addDiscount(){
    var id =  1;
    var lastRow = $('#discounts > tbody');

    if($('#discounts tbody>tr:last').data("id")){
        id = parseInt($('#discounts tbody>tr:last').data("id"))+1;
    }

    lastRow.append('<tr id="discount-row'+id+'" data-id="'+id+'">'+
        '<td class="text-left">'+
            '<input type="text" name="discounts['+id+'][num_students]" class="form-control touchspin_4" value="0">'+
        '</td>'+
        '<td>'+
            '<div class="percentage">'+
                '<input type="text" class="form-control touchspin_5" name="discounts['+id+'][discount]" value="0">'+
            '</div>'+
        '</td>'+
        '<td>'+
            '<label>'+
            '<input type="checkbox" name="discounts['+id+'][type][0]" value="online"/>'+
            'online'+
            ' </label>'+
            ' <label>'+
            '<input type="checkbox" name="discounts['+id+'][type][1]" value="presence"/>'+
            ' presence'+
            '</label>'+
        ' </td>'+
        '<td class="text-left"><button type="button" onclick="$(\'#discount-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ');

    $(".touchspin_4").TouchSpin({
        min: 0,
        max: 500,
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 20,
        postfix: 'student'
    });
    $(".touchspin_5").TouchSpin({
        min: 0,
        max: 100,
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 20,
        val: 0,
        postfix: '%'
    });
}
function addStudy(){
    var id =  1;
    var lastRow = $('#studies > tbody');

    if($('#studies tbody>tr:last').data("id")){
        id = parseInt($('#studies tbody>tr:last').data("id"))+1;
    }

    lastRow.append('<tr id="study-row'+id+'" data-id="'+id+'">'+
        '<td>'+
            '<input type="text" class="form-control" name="studies['+id+'][name_ar]">'+
            '<input type="text" name="studies['+id+'][duration]" class="form-control touchspin_6">'+
        '</td>'+
        '<td>'+
            '<input type="text" class="form-control" name="studies['+id+'][name_en]">'+
        '</td>'+
         '<td>'+
            '<select class="form-control"name="studies['+id+'][lang]"><option>لغات الدراسة</option><option value="Ar">عربية</option><option value="Fr">فرنسية</option></select>'+
        '</td>'+
        '<td>'+
            '<div class="radio-list">'+
                '<label>'+
                '<input type="radio" name="studies['+id+'][type]" class="study_choise"  value="pdf" checked/>'+
                ' pdf  </label>'+
                '<label>'+
                ' <input type="radio" name="studies['+id+'][type]" class="study_choise"  value="video"/>'+
                ' video </label>'+
                ' <input type="radio" name="studies['+id+'][type]" class="study_choise"  value="html"/>'+
                ' html </label>'+
            ' </div>'+
            '<label>'+
                '<input type="checkbox" name="studies['+id+'][only_registered]" />'+
                'only registered'+
            '</label>'+
        '</td>'+
        '<td colspan="2">'+
            '<div class="pdf">'+
                '<input type="text" class="form-control" id="study_urla_'+id+'" name="studies['+id+'][pdf]">'+
                '<a onclick="openKCFinderLink($(\'#study_urla_'+id+'\'))">browse server</a>'+
            ' </div>'+
            '<div class="video" style="display: none;">'+
                ' <input type="text" class="form-control" id="video_urla_'+id+'" name="studies['+id+'][url]">'+
                '<a onclick="openKCFinderLink($(\'#video_urla_'+id+'\'))">browse server</a>'+
            '</div>'+
            '<div class="content_html" style="display: none;">'+
                '<textarea cols="60" id="study_content1_'+id+'" name="studies['+id+'][content]" class="form-control ckeditor"></textarea>'+
            '</div>'+
        '</td>'+

        '<td class="text-left"><button type="button" onclick="$(\'#study-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ');
    $("input.study_choise").on('click',studyChoiseChange);
    $(".touchspin_6").TouchSpin({
        min: 0,
        max: 500,
        step:1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 20,
        postfix: 'ساعة'
    });
    CKEDITOR.replace('study_content1_'+id, {
        filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',
        filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',
        filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',
    });
}
$("input.study_choise").on('click',studyChoiseChange);
function studyChoiseChange(){
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

function addCourse(){
    var id =  1;
    var lastRow = $('#courses > tbody');

    if($('#courses tbody>tr:last').data("id")){
        id = parseInt($('#courses tbody>tr:last').data("id"))+1;
    }

    lastRow.append('<tr id="course-row'+id+'" data-id="'+id+'">'+
        '<td class="text-left">'+
            '<select name="courses['+id+'][quiz_id]" class="form-control select2">'+
            @foreach($quizzes as $quiz)
                '<option value="{{$quiz->id}}">'+
                '{{ $quiz->quiz_trans("ar")->name }}'+
                '</option>'+
            @endforeach
                '</select>'+
        '</td>'+
        '<td>'+
        '<input type="checkbox" name="courses['+id+'][active]">'+
        '</td>'+
        '<td class="text-right">'+
        '<div class="input-group input-large date-picker input-daterange"  data-date-format="yyyy-mm-dd">'+
        '<input type="text"  class="form-control" name="courses['+id+'][active_from]">'+
        '<span class="input-group-addon"> to </span>'+
        '<input type="text" class="form-control" name="courses['+id+'][active_to]">'+
        '</div>'+
        '</td>'+
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


</script>