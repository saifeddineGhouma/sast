<script>

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
};
$(document).ready(function(){
	$('#table1').DataTable(options);
});
 
 $('.deletrole').on('click', deleteRole);
	function deleteRole(e) {
		
		 var row =$(this);
		 var id = row.attr('elementId');	
		
			bootbox.confirm({
				title: "Delete Role",
				message: "Are you sure to delete this role? This operation is irreversible.",
			    callback: function(result) {
					if (result == true) {					 	 
			           $.ajax({
					        url: "{{ url('/admin/roles/delete/') }}" + '/' + id,
					        type: 'POST',
					        headers: {
						        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						    },
						    beforeSend:function(){
			                     $("#loadmodel_category").show();
			                },				       
					        success: function( msg ) {
					        	$('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
							 		$('.deletrole').on('click', deleteRole);
							 		$(".livicon").addLivicon();
							 		$('#table1').DataTable(options);
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
</script>