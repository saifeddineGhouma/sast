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
        	$(".btnedit").click(edit);
        },
};


function countries_search(){
	var countryId = $(this).val();
	var country = $(this);
	
	$.ajax({
			 url: '{{ url('/admin/governments/searchgovernments') }}'+"/"+countryId,
			type: "get",
			 beforeSend: function(){
				 country.closest(".row").find(".col-md-2").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
			},
			success: function(result){
                $("#governments_results").html(result); 
                $('.deletegovernment').on('click', deleteRecord);
                $(".livicon").addLivicon();
		 		$('#table1').DataTable(options);
		 		$(".btnedit").click(edit);
				country.closest(".row").find(".col-md-2").children('img').remove();
			},
		});
};

$("#country_search").change(countries_search);
$("#country_search").trigger("change");

$('.deletegovernment').on('click', deleteRecord);
	function deleteRecord(e) {
		
		 var row =$(this);
		 var id = row.attr('elementId');	
		
		bootbox.confirm({
			title: "Delete Government",
			message: "Are you sure to delete this government? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
		            $.ajax({
		                url: "{{url('admin/governments/delete/')}}" + '/' + id,
		                type: 'POST',
		                headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                }, 
		                beforeSend:function(){
		                     $("#loadmodel_category").show();
		                },               
		                success: function( msg ) {  
	                   		$("#country_search").trigger("change");
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

//$(".btnedit").click(edit);
function edit(){
	$("#form_government").bootstrapValidator('resetForm', true);
	
	var input = $(this);
	
	var url = "{{url('admin/governments/edit/')}}"+"/"+input.data('id');
	$("#url").val(url);
	var ar_name = input.data('ar_name');
	var en_name = input.data('en_name');
	var country_id = input.data('country_id');
	
	$("#government_id").val(input.data('id'));
	$("#ar_name").val(ar_name);
	$("#en_name").val(en_name);
	$("#country_id").val(country_id);
	$("#myModalLabel1").html("edit government "+name);
}
$(".add-government").click(function(){
	$("#form_government").bootstrapValidator('resetForm', true);
	
	var country_id = $("#country_search").val();
	
	var url = "{{url('admin/governments/create/')}}";
	$("#url").val(url);
	$("#country_id").val(country_id);
	$("#myModalLabel1").html("add government");
	
}); 
</script>