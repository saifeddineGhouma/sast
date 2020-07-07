<script type="text/javascript">
    $("#category_id").select2({
        theme:"bootstrap",
        placeholder:"",
        width: '100%'
    });

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
$(document).ready(function(){
	$('#table1').DataTable(options);
});

$('.deleterecord').on('click', deleteRecord);
	function deleteRecord(e) {

		 var row =$(this);
		 var id = row.attr('elementId');	
		
		bootbox.confirm({
			title: "Delete {{ $record_name }}",
			message: "Are you sure to delete one {{ $record_name }}? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
		            $.ajax({
		                url: "{{url('admin/'.$table_name.'/delete/')}}" + '/' + id,
		                type: 'POST',
		                headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                }, 
		                beforeSend:function(){
		                     $("#loadmodel_category").show();
		                },               
		                success: function( msg ) {
                            $("#filterBtn").trigger("click");
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

function restoreRecord(e) {

    var record =$(this);
    bootbox.confirm({
        title: "Restore article",
        message: "Are you sure to restore this {{ $record_name }}?",
        callback: function(result) {
            if (result == true) {
                var id = record.attr('elementId');
                $.ajax({
                    url: "{{url('/admin/'.$table_name.'/restore/')}}" + '/' + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend:function(){
                        $("#loadmodel_category").show();
                    },
                    success: function( msg ) {
                        $("#filterBtn").trigger("click");
                    },
                    error: function( data ) {
                        if ( data.status === 422 ) {
                            toastr.error('Cannot delete the record');
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


function formFilter(e){
    e.preventDefault();
    var data = $('#search_form').serializeArray();
    var trashed = $("input[name='trashed']").is(":checked");
    data.push({trashed: trashed});

    $.ajax({
        url: '{{ url('admin/'.$table_name.'/listing/') }}' ,
        type: "GET",
        data: data,
        beforeSend: function(){
            $('#filterBtn').button('loading');
        },
        success: function(result){
            $("#childList").html(result);
            $('.deleterecord').on('click', deleteRecord);
            $('.restore').on('click', restoreRecord);
            $('#table1').DataTable(options);
            $('.activeIcon').on('click',activeIcon_click);
            $(".livicon").addLivicon();
        },
        error: function(error){

        },
        complete: function(){
            $('#filterBtn').button('reset');
        }
    });
};


$("#search_form").on("submit",formFilter);
$("#search_form").submit();


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
        this1.html('<span class="label label-sm label-danger"> not active</span>');
        this1.data('id',state.replace(sp[0],offstate));
        newsate = false;
    }else{
        this1.html('<span class="label label-sm label-success"> active </span>');
        this1.data('id',state.replace(sp[0],onstate));
        newsate = true;
    }
    var _token = '<?php echo csrf_token(); ?>';

    $.ajax({
        url: "{{ url('/admin/'.$table_name.'/updatestateajax') }}",
        type:  'POST',
        data: {_token:  _token,sp: sp[1],newsate: newsate,field: field},
        success: function(result){
        }

    });

}


</script>