<script type="text/javascript">
var options = { 
    buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'copy', className: 'btn red btn-outline'},
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'excel', className: 'btn yellow btn-outline '},
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'colvis', className: 'btn dark btn-outline'}
            ],
             "order": [ 4, "desc" ],
       "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
       "drawCallback": function() {
        	$(".livicon").addLivicon();
        },
};



function deleteRecord(e) {	
	var row =$(this);
	var id = row.attr('elementId');	
		
	bootbox.confirm({
			title: "Delete Student",
			message: "Are you sure to delete this Student? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
			 	  
		            $.ajax({
		                url: "{{url('admin/students/delete/')}}" + '/' + id,
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
 


function formFilter(e){
	e.preventDefault();
	var data = $('#search_form').serializeArray();
    
    
	$.ajax({
		url: '{{ url('/admin/students/searchresults/') }}' ,
		type: "GET",
		data: data,
		beforeSend: function(){
			 $('#filterBtn').button('loading');
		},
		success: function(result){				
			$("#studentsChildList").html(result);
			$('.deletestudent').on('click', deleteRecord); 
			
			$('#table1').DataTable(options);
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

</script>