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



function deleteRecord(e) {	
	var row =$(this);
	var id = row.attr('elementId');	
		
	bootbox.confirm({
			title: "Delete User",
			message: "Are you sure to delete this user? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
			 	  
		            $.ajax({
		                url: "{{url('admin/users/delete/')}}" + '/' + id,
		                type: 'POST',
		                headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                }, 
		                beforeSend:function(){
		                     $("#loadmodel_category").show();
		                },               
		                success: function( msg ) {                    
		                   if(msg=="error"){
		                   		bootbox.alert("cannot delete this user because he has related records");
		                   }else{
		                   		$("#filterBtn").trigger("click");
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
  
};
 


function formFilter(e){
	e.preventDefault();
	var data = $('#search_form').serializeArray();
//    var advertiser = $("input[name='advertiser']").is(":checked");
//    var notadvertiser = $("input[name='notadvertiser']").is(":checked");
//    data.push({advertiser: advertiser,notadvertiser: notadvertiser});
    
	$.ajax({
		url: '{{ url('/admin/users/searchresults/') }}' ,
		type: "GET",
		data: data,
		beforeSend: function(){
			 $('#filterBtn').button('loading');
		},
		success: function(result){				
			$("#usersChildList").html(result);
			$('.deletuser').on('click', deleteRecord); 
			
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
		url: '{{ url("/admin/users/updatestateajax") }}',					
		type:  'POST',
		data: {_token:  _token,sp: sp[1],newsate: newsate,field: field},
		success: function(result){	
		}	
							
	});
	
}
</script>