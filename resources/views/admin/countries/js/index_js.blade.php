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

$('.deletcountry').on('click', deleteRecord);
	function deleteRecord(e) {
		
		 var row =$(this);
		 var id = row.attr('elementId');	
		if(id!=1){
			bootbox.confirm({
				title: "Delete Country",
				message: "Are you sure to delete this country? This operation is irreversible.",
			    callback: function(result) {
					if (result == true) {
			            $.ajax({
			                url: "{{url('admin/countries/delete/')}}" + '/' + id,
			                type: 'POST',
			                headers: {
			                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			                }, 
			                beforeSend:function(){
			                     $("#loadmodel_category").show();
			                },               
			                success: function( msg ) {                    
			                   if(msg=="error"){
			                   		bootbox.alert("Cannot delete this country because there is a related records");
			                   }else{
			                   		$('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
								 		$('.deletcountry').on('click', deleteRecord);
								 		$(".livicon").addLivicon();
								 		$('#table1').DataTable(options);
								 		$(".btnedit").click(edit);
									});
			                   }
			                    
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
			bootbox.alert("cannot delete Main Country");
		}
		
  
};

$(".btnedit").click(edit);
function edit(){
	$("#form_country").bootstrapValidator('resetForm', true);
	
	var input = $(this);
	
	var url = "{{url('admin/countries/edit/')}}"+"/"+input.data('id');
	$("#url").val(url);
	var en_name = input.data('en_name');
	var ar_name = input.data('ar_name');
	var code = input.data('code');
	
	$("#country_id").val(input.data('id'));
	$("#ar_name").val(ar_name);
	$("#en_name").val(en_name);
	$("#code").val(code);
    $("#sort_order").val(input.data('sort_order'));
	$("#myModalLabel1").html("edit country "+ar_name);
}
$(".add-country").click(function(){	
	$("#form_country").bootstrapValidator('resetForm', true);
	
	var url = "{{url('admin/countries/create/')}}";
	$("#url").val(url);	
	$("#myModalLabel1").html("add country");
	
}); 
</script>