<script type="text/javascript">

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});


function deleteRecord(e) {	
	var row =$(this);
	var id = row.attr('elementId');	
		
	bootbox.confirm({
			title: "Delete Order",
			message: "Are you sure to delete this order? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
			 	  
		            $.ajax({
		                url: "{{url('admin/orders/delete/')}}" + '/' + id,
		                type: 'POST',
		                headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                }, 
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
  
};


function formFilter(e){
	e.preventDefault();
    $('#table1').DataTable().draw();
    {{--
	var data = $('#search_form').serializeArray();
  
	$.ajax({
		url: "{{ url(App('urlLang').'admin/orders/searchresults/') }}" ,
		type: "GET",
		data: data,
		beforeSend: function(){
			 $('#filterBtn').button('loading');
		},
		success: function(result){


			result = $.parseJSON(result);
        	var output = result[0];
    	 	output = output.replace(/\\"/g , '"');
    	 					
			$("#ordersChildList").html(output);
			$('.deleteorder').on('click', deleteRecord);
			
			$('#table1').DataTable(options);

		    
			$(".livicon").addLivicon();
		},
		error: function(error){
			
		},
		complete: function(){
			 $('#filterBtn').button('reset');
		}
	});
	--}}
};

$("#search_form").on("submit",formFilter);
//$("#search_form").submit();


var options = {
    buttons: [
        { extend: 'print', className: 'btn dark btn-outline' },
        { extend: 'copy', className: 'btn red btn-outline'},
        { extend: 'pdf', className: 'btn green btn-outline' },
        { extend: 'excel', className: 'btn yellow btn-outline '},
        { extend: 'csv', className: 'btn purple btn-outline ' },
        { extend: 'colvis', className: 'btn dark btn-outline'}
    ],
    "order": [ 0, "desc" ],
    "pageLength": 20,
    "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
    "drawCallback": function() {
        $(".livicon").addLivicon();
    },
    "processing": true,
    "serverSide": true,
    "ajax": {
        url: '{{ url('admin/orders/searchresults') }}' ,
        type: "GET",
        data: function ( d ) {
            //d.extra_search = $('#search_form').serializeArray();
            return $.extend( {}, d, {
                "extra": $('#search_form').serialize()
            } );
        },
        beforeSend: function(){
            $('#filterBtn').button('loading');
        },
        complete: function(){
            $('#filterBtn').button('reset');
            $('.deleteorder').on('click', deleteRecord);
        },
        pages: 5 // number of pages to cache
    }
};

$(document).ready(function(){
    $('#table1').DataTable(options);
});

</script>