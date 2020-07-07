<script type="text/javascript">
 
//init maxlength handler
$('.maxlength-handler').maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});


$(".touchspin_1").TouchSpin({
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

$("#form1").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
        ar_question: {
            validators: {
                notEmpty: {
                    message: 'The question is required'
                }
            }
        },
        en_question: {
            validators: {
                notEmpty: {
                    message: 'The question is required'
                }
            }
        },
    }
}).on('success.form.bv', function(e) {

});

function addAnswer(){
    var id =  1;
    var lastRow = $('#answers > tbody');

    if($('#answers tbody>tr:last').data("id")){
        id = parseInt($('#answers tbody>tr:last').data("id"))+1;
    }

    lastRow.append('<tr id="answer-row'+id+'" data-id="'+id+'">'+
        '<td>'+
            '<input type="text"  name="answers['+id+'][name_ar]" class="form-control">'+
        '</td>'+
        '<td>'+
            '<input type="text"  name="answers['+id+'][name_en]" class="form-control">'+
        '</td>'+
        '<td>'+
            '<input type="checkbox" name="answers['+id+'][is_correct]" class="form-control">'+
        '</td>'+
        '<td class="text-left"><button type="button" onclick="$(\'#answer-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ');


}

</script>