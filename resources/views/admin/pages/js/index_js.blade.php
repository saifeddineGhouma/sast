<script type='text/javascript'>
$(document).ready(function(){
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

$('.deletpage').on('click', deletePage);
	function deletePage(e) {
		
		 var row =$(this);
		 var id = row.attr('elementId');	
		
		bootbox.confirm({
			title: "Delete Admin",
			message: "Are you sure to delete this admin? This operation is irreversible.",
		    callback: function(result) {
				if (result == true) {
		            $.ajax({
		                url: "{{url('admin/pages/delete/')}}" + '/' + id,
		                type: 'POST',
		                headers: {
		                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		                }, 
		                beforeSend:function(){
		                     $("#loadmodel_category").show();
		                },               
		                success: function( msg ) {                   
		                  
	                   		$('#reloaddiv').load(document.URL +  ' #reloaddiv',function(responseText, textStatus, XMLHttpRequest){
						 		$('.deletpage').on('click', deletePage);
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
		
		$(document).on('click', ".in_homeIcon", function(){
				var id = $(this).find('img').attr('id');
				var sp = id.split('-');
				if(sp[0]=="hoff"){
					$.ajax({
				        url: "{{ url('/pages/checkhome') }}" ,
				        type: 'GET',
				        async: false,
				        success: function( count ) {
				            if(count<2)
				            	swap(id,'in_home');
				            else
				            	 bootbox.alert('لا يمكن اختيار أكثر من خاصيتين');
				        },
			       
			    	});
				}else{
					swap(id,'in_home');
				}
				
		});
		$(document).on('click', ".in_footerIcon", function(){
				var id = $(this).find('img').attr('id');
				var sp = id.split('-');
				if(sp[0]=="foff"){
					$.ajax({
				        url: "{{ url('/pages/checkfooter') }}" ,
				        type: 'GET',
				        async: false,
				        success: function( count ) {
				            if(count<2)
				            	swap(id,'in_footer');
				            else
				            	 bootbox.alert('لا يمكن اختيار أكثر من خاصيتين');
				        },
			       
			    	});
				}else{
					swap(id,'in_footer');
				}
				
		});
		$(document).on('click', ".activeIcon", function(){
				var id = $(this).find('img').attr('id');
				swap(id,'active');
		});
		
	

	
	});
	function swap(state,field){
	//	alert(state);
	var sp = state.split('-');
	var newsate = true;
	//console.log(sp[0]);
	//console.log('on');
	var onstate = "on";
	var offstate = "off";
	if(field == "in_home"){
		onstate = "hon"
		offstate = "hoff";
	}
	if(field == "in_footer"){
		onstate = "fon"
		offstate = "foff";
	}
	if(sp[0]==onstate){
	$('#'+state).attr('src',"{{ asset('assets/admin/img/false.png') }}");
	$('#'+state).attr('id',state.replace(sp[0],offstate));
		newsate = false;
		//console.log(newsate);
	}else{
		$('#'+state).attr('src',"{{ asset('assets/admin/img/true.png') }}");
		$('#'+state).attr('id',state.replace(sp[0],onstate));
		newsate = true;
	}
	var _token = '<?php echo csrf_token(); ?>';	
	
	
	var parent = $(this).parent();
	
		$.ajax({
					url: "{{url('admin/pages/updatestateajax')}}",
					type:  'POST',
					data: {_token:  _token,sp: sp[1],newsate: newsate,field: field},
					success: function(result){
						
						},	
						error: function(data){
							
						},			
				});
	
	}
	 
</script>
