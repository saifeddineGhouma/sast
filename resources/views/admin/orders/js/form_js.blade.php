
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
$(".printOrder").click(printdiv);

function printdiv() {
	var id = $("#id").val();
    var iFrame = document.createElement('iframe');
    iFrame.style.position = 'absolute';
    iFrame.style.left = '-99999px';
    iFrame.src = "{{url('admin/orders/report/')}}"+"/"+id;
    iFrame.onload = function() {
      function removeIFrame(){
        document.body.removeChild(iFrame);
        document.removeEventListener('click', removeIFrame);
      }
      document.addEventListener('click', removeIFrame, false);
    };

    document.body.appendChild(iFrame);
 
};

 $("#orders-form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {

    }
}).on('success.form.bv', function(e) {
});


$('.deletepayment').on('click', deleteRecord);
function deleteRecord(e) {

    var row =$(this);
    var id = row.attr('elementId');

        bootbox.confirm({
            title: "Delete Payment",
            message: "Are you sure to delete this payment? This operation is irreversible.",
            callback: function(result) {
                if (result == true) {
                    $.ajax({
                        url: "{{url('admin/orders/delete-payment/')}}" + '/' + id,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend:function(){
                            $("#loadmodel_category").show();
                        },
                        success: function( msg ) {
                            $('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
                                $('.deletepayment').on('click', deleteRecord);
                                $(".editpayment").click(edit);
                                $(".addpayment").click(add);
                            });
                        },
                        error: function( data ) {
                            if ( data.status === 422 ) {
                                toastr.error('Cannot delete the category');
                            }
                        },
                        complete: function(){
                            $("#loadmodel_category").hide();
                        }
                    });

                }
            }
        });


};

$(".editpayment").click(edit);
function edit(){
    $("#form_payment").bootstrapValidator('resetForm', true);

    var input = $(this);

    var url = "{{url('admin/orders/edit-payment/')}}"+"/"+input.data('id');
    $("#url_payment").val(url);

    $("input[name='total']").val(input.data('total'));
    if(input.data('payment_status')=="paid")
        $("#paid").prop("checked",true);
    else
        $("#paid").prop("checked",false);
    $("#myModalLabel1").html("edit payment "+input.data('id'));
}
$(".addpayment").click(add);
function add(){
    $("#form_payment").bootstrapValidator('resetForm', true);

    var url = "{{url('admin/orders/create-payment/')}}";
    $("#url_payment").val(url);
    $("#myModalLabel1").html("add payment");

};

$("#form_payment").bootstrapValidator({
    excluded: [':disabled'],
    framework: 'bootstrap',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        total: {
            validators: {
                notEmpty: {
                    message: 'The total is required'
                },
                greaterThan: {
                    value: 1,
                    message: 'should be greater than 0'
                }
            },
            required: true
        }
    }
}).on('success.form.bv', function(e) {
    e.preventDefault();

    var inputData = $('#form_payment').serialize();

    $.ajax({
        url: $('#url_payment').val(),
        type: 'post',
        beforeSend: function(){
            $(".demo-loading-btn").button('loading');
        },
        data: inputData,
        success: function() {
            $('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
                $('.deletepayment').on('click', deleteRecord);
                $(".editpayment").click(edit);
                $(".addpayment").click(add);
            });
            $("#modal-2").modal("hide");
            swal({
                title: "Payment saved successfully....",
                text: "",
                confirmButtonColor: "#00695C",
                type: "success",
                allowOutsideClick: true,
                confirmButtonText: "OK",
                customClass: "swl-success"
            });
        },
        error: function( data ) {
            var errors = data.responseJSON;

            $('#errorDiv').show();
            $('#errorul').html("");
            $.each(errors,function(k,v){
                $('#errorul').append('<li>'+v+'</li>');
            });
        },
        complete: function(){
            $(".demo-loading-btn").button('reset');
        }
    });

});


</script>