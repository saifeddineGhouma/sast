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
    @if(request()->manual)
        "order": [ 6, "desc" ],
    @else
        "order": [ 6, "desc" ],
    @endif
    "processing": true,
    "serverSide": true,
    "ajax": {
            url: '{{ url('teachers/'.$table_name.'/listing-ajax/') }}' ,
            type: "GET",
            data: function ( d ) {
                //d.extra_search = $('#search_form').serializeArray();
                return $.extend( {}, d, {
                        "extra": "manual={{ request()->manual}}"
                } );
            },
            pages: 5 // number of pages to cache

        }
};

$(document).ready(function(){
    $('#table1').DataTable(options);
});

    //************************* Change Active *********************************

    function activeIcon_click(){
        var id = $(this).data('id');
        var this1 =$(this);
        swap(id,'active',this1);
    }
    function swap(state,field,this1){
        var sp = state.split('-');
        var newsate = true;
        var onstate = "on";
        var offstate = "off";

        if(sp[0]==onstate){
            this1.html('<span class="label label-sm label-danger"> inactive </span>');
            this1.data('id',state.replace(sp[0],offstate));
            newsate = false;
        }else{
            this1.html('<span class="label label-sm label-success"> active </span>');
            this1.data('id',state.replace(sp[0],onstate));
            newsate = true;
        }
        var _token = '<?php echo csrf_token(); ?>';

        $.ajax({
            url: '{{ url("/admin/students-certificates/updatestateajax") }}',
            type:  'POST',
            data: {_token:  _token,sp: sp[1],newsate: newsate,field: field},
            success: function(result){
            }

        });

    }


</script>