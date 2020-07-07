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
            "order": [ 5, "desc" ],
       "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
       "drawCallback": function() {
        	$(".livicon").addLivicon();
        },
};

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});


function deleteRecord(e) {	
	var row =$(this);
	var id = row.attr('elementId');	
		
	bootbox.confirm({
			title: "Delete Forum",
			message: "Are you sure to delete this forum? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
			 	  
		            $.ajax({
		                url: "{{url('teachers/forum/delete/')}}" + '/' + id,
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
		url: "{{ url(App('urlLang').'teachers/forum/searchresults/') }}" ,
		type: "GET",
		data: data,
		beforeSend: function(){
			 $('#filterBtn').button('loading');
		},
		success: function(result){
			result = $.parseJSON(result);
        	var output = result[0];
    	 	output = output.replace(/\\"/g , '"');
    	 					
			$("#tableChildList").html(output);
			$('.deleterecord').on('click', deleteRecord);
            $('.activeIcon').on('click',activeIcon_click);
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
        url: '{{ url("/teachers/forum/updatestateajax") }}',
        type:  'POST',
        data: {_token:  _token,sp: sp[1],newsate: newsate,field: field},
        success: function(result){
        }

    });

}
</script>