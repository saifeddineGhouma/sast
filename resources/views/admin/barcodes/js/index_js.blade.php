<script type="text/javascript">
    // handle group checkbox:
    jQuery('body').on('change', '.group-checkbox', function () {
        var set = jQuery('.checkbox');
        var checked = jQuery(this).is(":checked");
        jQuery(set).each(function () {
            //jQuery( this ).prop( "checked", true );
            $(this).prop("checked", checked);
        });
        //jQuery.uniform.update(set);
    });

$('#btn-delete').on('click', deleteRecords);
	function deleteRecords(e) {
        var ids = [];
        $(".checkbox:checked").each(function(){
            var rowId = $(this).data("id");
            ids.push(rowId);
        });
		if(ids.length>0){
            bootbox.confirm({
                title: "Delete Records",
                message: "Are you sure to delete "+ids.length+" records? This operation is irreversible.",
                callback: function(result) {
                    if (result == true) {
                        $.ajax({
                            url: "{{url('admin/'.$table_name.'/delete')}}",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: { ids: ids},
                            beforeSend:function(){
                                $("#loadmodel_category").show();
                            },
                            success: function( msg ) {
                                $('#table1').DataTable().draw();
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
        }else{
		    bootbox.alert("You must choose at least one row to delete");
        }

  
};

//function formFilter(e){
//    e.preventDefault();
//    $('#table1').DataTable().draw();
//};
//$("#search_form").on("submit",formFilter);



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
    "columnDefs": [
        { "orderable": false, "targets": 0 }
    ],
    "order": [ 5, "desc" ],
    "processing": true,
    "serverSide": true,
    "ajax": {
            url: '{{ url('admin/'.$table_name.'/listing-ajax/') }}' ,
            type: "GET",
            data: function ( d ) {
                //d.extra_search = $('#search_form').serializeArray();

            },
            pages: 5 // number of pages to cache

        }
};

$(document).ready(function(){
    $('#table1').DataTable(options);
});


</script>