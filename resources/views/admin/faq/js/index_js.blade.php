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
};
$('#table1').DataTable(options);

$('.deletefaq').on('click', deleteRecord);
	function deleteRecord(e) {
		
		 var row =$(this);
		 var id = row.attr('elementId');	
		
		bootbox.confirm({
			title: "Delete Faq",
			message: "Are you sure to delete this faq? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
		            $.ajax({
		                url: "{{url('admin/faq/delete/')}}" + '/' + id,
		                type: 'POST',
		                headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                }, 
		                beforeSend:function(){
		                     $("#loadmodel_category").show();
		                },               
		                success: function( msg ) {  
	                   		$('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
						 		$('.deletefaq').on('click', deleteRecord);
						 		$(".livicon").addLivicon();
						 		$('#table1').DataTable(options);
						 		$(".btnedit").click(edit);
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

$(".btnedit").click(edit);
function edit(){
	$("#form_faq").bootstrapValidator('resetForm', true);
	
	var input = $(this);
	
	var url = "{{url('admin/faq/edit/')}}"+"/"+input.data('id');
	$("#url").val(url);
	var en_question = input.data('en_question');
	var ar_question = input.data('ar_question');
	var en_answer = input.data('en_answer');
	var ar_answer = input.data('ar_answer');
	var sort_order = input.data('sort_order');
	
	$("#faq_id").val(input.data('id'));
	$("#en_question").val(en_question);
	$("#ar_question").val(ar_question);
	$("#en_answer").val(en_answer);
	$("#ar_answer").val(ar_answer);
	$("#sort_order").val(sort_order);
	$("#myModalLabel1").html("edit faq "+en_question);
}
$(".add-faq").click(function(){	
	$("#form_faq").bootstrapValidator('resetForm', true);
	$("#ar_question").val("");
	$("#ar_answer").val("");
	var url = "{{url('admin/faq/create/')}}";
	$("#url").val(url);	
	$("#myModalLabel1").html("add faq");
	
}); 
</script>