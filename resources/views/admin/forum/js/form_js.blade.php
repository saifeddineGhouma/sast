
<script type="text/javascript">


$(".touchspin_1").TouchSpin({
        min: 0,
        max: 20000,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '$'
    });
$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});


$("#forum-form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
        discussion: {
            validators: {
                notEmpty: {
                    message: 'discussion is required'
                }
            }
        },
    }
}).on('success.form.bv', function(e) {
});

function addReply(){
    var id =  1;
    var lastRow = $('#studies > tbody');

    if($('#studies tbody>tr:last').data("id")){
        id = parseInt($('#studies tbody>tr:last').data("id"))+1;
    }

    lastRow.append('<tr id="reply-row'+id+'" data-id="'+id+'">'+
        '<td>'+
            '{{ Auth::guard("admins")->user()->username }}'+
			'<input type="hidden" name="replies['+id+'][client_id]" value="{{ Auth::guard("admins")->user()->id }}" />'+
        '</td>'+
        '<td>'+
            '<textarea cols="60"  name="replies['+id+'][discussion]" class="form-control"></textarea>'+
        '</td>'+
        '<td>'+
            '<input type="checkbox" name="replies['+id+'][active]" checked>'+
        '</td>'+
        '<td class="text-left"><button type="button" onclick="$(\'#reply-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ');
}


</script>