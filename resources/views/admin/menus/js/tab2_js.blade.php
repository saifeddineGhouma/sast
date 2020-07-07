<script>
$("#tab2_shopId").change(function(){
	$.ajax({
		url: '{{ url('/admin/menus/tab2content/') }}' ,
		type: "GET",
		data: {shop_id: $("#tab2_shopId").val()},
		beforeSend: function(){
			 $('#spinner_div').append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
		},
		success: function(result){				
			$("#_tab2").html(result);
			$("#savePos").on("click",savePosFun);
		},
		complete: function(){
			$('#spinner_div').html("");
		}
	});
});
$("#tab2_shopId").trigger("change");


function savePosFun(e){
	/*
	var positions = $('input:text.positions').serialize();
	var menus = $('input:text.menus').serialize();*/
	var data ={};
	$("#tableTab2").find("select").each(function(){
		data[$(this).attr("positionId")]=$(this).val();
	});
	
	$.ajax({
 			url:'{{url("/admin/menus/savemenupos/")}}',
 			type: 'post',
 			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
 			data: {data: data},
 			beforeSend: function(){
						 $('.demo-loading-btn').button('loading');
			},
	        success: function( message ) {
	        	console.log(message);
                $('.demo-loading-btn').button('reset');
                
                 
	        },	       
 		});
}
</script>