<script>
jQuery(function($){

	/******************************************
    PRICE FILTER
******************************************/
var from = {{$minPrice}},
to = {{$maxPrice}};
$( "#slider-range_one" ).slider({
    range: true,
    min: from,
    max: to,
    values: [ from, to ],
    slide: function( event, ui ) {
        $( "#amount_one" ).val(+ ui.values[ 0 ] );
        $( "#amount_two" ).val(+ ui.values[ 1 ] );
        from = ui.values[0];
        to = ui.values[1];
    },
    change: function(event, ui) {
        reload_products();
    }
});
$( "#amount_one" ).val($( "#slider-range_one" ).slider( "values", 0 )  );
$( "#amount_two" ).val($( "#slider-range_one" ).slider( "values", 1 ) );

$("#amount_one").change(function() { $("#slider-range_one").slider('values',0,$(this).val()); });
$("#amount_two").change(function() { $("#slider-range_one").slider('values',1,$(this).val()); });

	
	$(".view-list").click(function(){
		if(!$(this).closest("li").hasClass("active")){
			$(".view-grid").closest("li").removeClass("active");
			$(this).closest("li").addClass("active");
			$("#courses-container").removeClass("products-grid").addClass("products-list");
			$("#courses-container").parent().removeClass("product-grid-area").addClass("product-list-area");
			reload_products();
		}
	});
	$(".view-grid").click(function(){
		if(!$(this).closest("li").hasClass("active")){
			$(".view-list").closest("li").removeClass("active");
			$(this).closest("li").addClass("active");
			$("#courses-container").removeClass("products-list").addClass("products-grid");
			$("#courses-container").parent().removeClass("product-list-area").addClass("product-grid-area");
			reload_products();
		}
	});
	
	$("#sort_link").change(function(){
		$("#sort_order").val($(this).val());
		reload_products();
	});
	$(".cat_check").change(reload_products);
    $(".type_check").change(reload_products);

	function reload_products(){
	 	var obj = $(this);
	 	var catIds = [];
	 	$(".cat_check").each(function() {
	    	if($(this).prop("checked"))
	        	catIds.push($(this).data("id"));
	    });
	    
	    var types = [];
	    $(".type_check").each(function() {
	    	if($(this).prop("checked"))
                types.push($(this).val());
	    });
	   sort_courses = $("#sort_order").val();
	   
	   var containerType = "products-grid";
	   if($("#coruses-container").hasClass("products-list"))
	   	containerType = "products-list";

	    $.ajax({
		        url: '{{url(App("urlLang")."categories/reload-products")}}',
		        data: {
		            'catIds': JSON.stringify(catIds),
                    'types': JSON.stringify(types),
		            'sort_courses': sort_courses,
		            'cat_id': $('#cat_id').val(),
		            'price_from': from,'price_to': to,'type': $('#type').val(),
		            'containerType': containerType
		        },
		        type: 'GET',			       
		        beforeSend: function(){
                    //$("#content_loading").modal("show");
				},
		        success: function( data ) {
		        	$('#coruses-container').html("");
		        	
		        	result = $.parseJSON(data);
		        	$("#countpro").val(result[1]);
		        	
		        	$("#search_total").html(result[2]);
		        	
	 				 $("#start_at").val("{{$start_at}}");
		        	
		        	if(result[0].length>0){
		        		result[0] = result[0].replace(/\\"/g , '"');
	        	 		$('#coruses-container').append(result[0]);
		        	}else{
		        		$('#coruses-container').append('<div class="strip_list wow fadeIn" data-wow-delay="0.1s"><div class="row"><div class="col-md-9 col-sm-9"> لا يوجد دورات </div></div></div>');
		        	}
				     
				    var start_at = parseInt($("#start_at").val());					
					var countPro = parseInt($("#countpro").val());
					
					if(countPro <= start_at)
				    	$(".load-more-holder").hide();
				    else
				    	$(".load-more-holder").show();


		        },
		        complete: function() {
		           // $("#content_loading").modal("hide");
		        },
		    });
	 }
	
	$("#new-products_grid").click(function(){

		var start_at = parseInt($("#start_at").val());
		var step = parseInt($("#step").val());
		var countPro = parseInt($("#countpro").val());
		
		var catIds = [];
	 	$(".cat_check").each(function() {
	    	if($(this).prop("checked"))
	        	catIds.push($(this).data("id"));
	    });

        var types = [];
        $(".type_check").each(function() {
            if($(this).prop("checked"))
                types.push($(this).val());
        });

        sort_courses = $("#sort_order").val();
	   
	   var containerType = "products-grid";	
	   if($("#coruses-container").hasClass("products-list"))
	   	containerType = "products-list";	
	   		
		var obj=$(this);
		$.ajax({
		        url: '{{url(App("urlLang")."categories/productsmore")}}',
		        data: {
	                'start_at': start_at,
                    'catIds': JSON.stringify(catIds),
                    'types': JSON.stringify(types),
                    'sort_courses': sort_courses,
                    'cat_id': $('#cat_id').val(),
                    'price_from': from,'price_to': to,'type': $('#type').val(),
                    'containerType': containerType,
                    'more': true
	            },
		        type: 'GET',			       
		        beforeSend: function(){
					obj.button("loading");
					obj.css("pointer-events", "none");
				},
		        success: function( data ) {
		        	result = $.parseJSON(data);	
		        	
	        	 	result[0] = result[0].replace(/\\"/g , '"');	        	 	
			         
			        $('#coruses-container').append(result[0]);
		           
		           
		           start_at += step;
		            $("#start_at").val(start_at);		            
		        	if(countPro <= start_at)
		        		$(".load-more-holder").hide();

		        	
		        },	
	            complete: function() {
	                //remove the spinner
	               obj.button("reset");
	               obj.css("pointer-events", "auto");
	            }
		    });
	});
});
</script>