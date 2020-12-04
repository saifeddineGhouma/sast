
<script type="text/javascript">

    $(document).ready(function(){
         
    var options = { 
    buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'copy', className: 'btn red btn-outline'},
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'excel', className: 'btn yellow btn-outline '},
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'colvis', className: 'btn dark btn-outline'}
            ],
       "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
       "drawCallback": function() {
            $(".livicon").addLivicon();
        },
    "order": [ 0, "desc" ],
};
formFilter()

});

function formFilter(/*e*/){


 var options = { 
    buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'copy', className: 'btn red btn-outline'},
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'excel', className: 'btn yellow btn-outline '},
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'colvis', className: 'btn dark btn-outline'}
            ],
       "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
       "drawCallback": function() {
            $(".livicon").addLivicon();
        },
    "order": [ 0, "desc" ],
};




   // e.preventDefault();
    var data = $('#search_form').serializeArray();
    var trashed = $("input[name='trashed']").is(":checked");
    data.push({trashed: trashed});

    $.ajax({
        url: "{{ url('admin/stages/listing/') }}" ,
        type: "GET",
        data: data,
        beforeSend: function(){
            $('#filterBtn').button('loading');
        },
        success: function(result){

            console.log(result)
            $("#childList").html(result);
            $('#table1').DataTable(options);
           
        },
        error: function(error){

        },
        complete: function(){
            $('#filterBtn').button('reset');
        }
    });
};
//$("#search_form").onClick("submit",formFilter());
$("#filterBtn").click(function(){
    formFilter()
})
//$("#search_form").submit();
</script>
