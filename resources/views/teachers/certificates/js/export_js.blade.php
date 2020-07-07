<script type="text/javascript">
    $(".select2").select2({
        theme:"bootstrap",
        placeholder:"",
        width: '100%'
    });
    $('#student_ids').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'Select all!',
        enableFiltering: true,
        filterPlaceholder: 'Search for Student ...'
    });
    $("#form1").bootstrapValidator({
        excluded: [':disabled'],
//        fields: {
//            "student_ids[]": {
//                validators: {
//                    notEmpty: {
//                        message: 'plz choose at least one student'
//                    }
//                }
//            },
//        }
    }).on('success.form.bv', function(e) {

    });

    $("#coursetypevariation_id").change(variation_select);
    function variation_select(e){
        console.log("asdfasdf");
        var coursetypevariationId = $(this).val();
        var variation = $(this);

        if(coursetypevariationId!=""){

            $.ajax({
                url: "{{ url('/admin/certificates/students') }}",
                data: {coursetypevariationId: coursetypevariationId},
                type: "get",
                beforeSend: function(){
                    variation.closest(".form-group").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
                },
                success: function(result){
                    $("#student_ids").html(result["students"]);
                    $('#student_ids').multiselect('rebuild');
                },
                complete: function(){
                    variation.closest(".form-group").children('img').remove();
                }
            });
        }
    }

    $("#test").click(function(){
       if($(this).is(":checked")){
            $("#live").slideUp();
       }else{
           $("#live").slideDown();
       }
    });

//$("#form1").submit(function(e){
//    e.preventDefault();
//    if($("#student_ids").val()!= ""){
//        $("#student_ids").closest(".form-group").find(".help-block").remove();
//        $("#student_ids").closest(".form-group").addClass("has-error");
//        $("#student_ids").closest(".form-group").append("<span class='help-block'>plz choose at least one student</span>");
//        e.preventDefault();
//    }else{
//        $("#student_ids").closest(".form-group").removeClass("has-error");
//        $("#student_ids").closest(".form-group").find(".help-block").remove();
//    }
//});

</script>