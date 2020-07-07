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

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});
function countries_search(){
	var countryId = $(this).val();
	var country = $(this);
	
	$.ajax({
			 url: '{{ url('/admin/agents/searchagents') }}'+"/"+countryId,
			type: "get",
			 beforeSend: function(){
				 country.closest(".row").find(".col-md-2").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
			},
			success: function(result){
                $("#agents_results").html(result);
                $('.deleteagent').on('click', deleteRecord);
                $(".livicon").addLivicon();
		 		$('#table1').DataTable(options);
		 		$(".btnedit").click(edit);
                $('.activeIcon').on('click',activeIcon_click);
                country.closest(".row").find(".col-md-2").children('img').remove();
			},
		});
};

$("#country_search").change(countries_search);
$("#country_search").trigger("change");

$('.deleteagent').on('click', deleteRecord);
	function deleteRecord(e) {
		
		 var row =$(this);
		 var id = row.attr('elementId');	
		
		bootbox.confirm({
			title: "Delete Agent",
			message: "Are you sure to delete this agent? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
		            $.ajax({
		                url: "{{url('admin/agents/delete/')}}" + '/' + id,
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
	$("#form_agent").bootstrapValidator('resetForm', true);
	
	var input = $(this);
	
	var url = "{{url('admin/agents/edit/')}}"+"/"+input.data('id');
	$("#url").val(url);
	var country_id = input.data('country_id');
	
	$("#agent_id").val(input.data('id'));
	$("#name").val(input.data('name'));
    $("#mobile").val(input.data('mobile'));
    $("#email").val(input.data('email'));
    $("#address").val(input.data('address'));
	$("#country_id").val(country_id);
	$("#myModalLabel1").html("edit agent "+name);
}
$(".add-agent").click(function(){
    $("#form_agent").bootstrapValidator('resetForm', true);
	
	var country_id = $("#country_search").val();
	
	var url = "{{url('admin/agents/create/')}}";
	$("#url").val(url);
    $("#mobile").val("");
    $("#email").val("");
    $("#address").val("");
	$("#country_id").val(country_id);
	$("#myModalLabel1").html("add agent");
	
});

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
        url: '{{ url("/admin/agents/updatestateajax") }}',
        type:  'POST',
        data: {_token:  _token,sp: sp[1],newsate: newsate,field: field},
        success: function(result){
        }

    });

}
</script>