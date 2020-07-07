

<script>
$("#menuSelect").change(menuSelectFun);
function menuSelectFun(e){
	var menuId = $(this).val();
	var menu = $(this);
	
	if(menuId != undefined){
		
		$.ajax({
			 url: '{{ url('/admin/menus/links/') }}' + '/' + menuId ,
			type: "GET",
			 beforeSend: function(){
				 menu.parent().append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
			},
			
			success: function(result){
				$("#linksChildList").html(result);
				UINestable.init();
				 //$('.dd').nestable('collapseAll');
				$(".dd").trigger("change");	
				 $(".delete").on('click',deleteRow);
				 $("#saveMenu1").on('click',saveMenu);
				$("#saveMenu").on('click',saveMenu);
				$("#deleteMenu").on('click',deleteMenuFun);
				 menu.parent().children('img').remove();
			},
			
		});
	}
};
	
$("#menuSelect").trigger("change");


	
$(".reload").click(function(e){
	$("#menuSelect").trigger("change");
});
$("#checkall").click(function(){
	
	var checkboxes = $("#pages").find(":checkbox");
	var count = checkboxes.length;
	var countChecked = $("#pages").find(":checkbox:checked").length;
	
	checkboxes.each(function(){
		if(countChecked != count){
			$(this).attr('checked',true);
			$(this).parent().addClass("checked");
		}else{
			$(this).attr('checked',false);
			$(this).parent().removeClass("checked");
		}
	});
	 $('input:checkbox').not(this).prop('checked', this.checked);
});

$("#checkall_design").click(function(){
	
	var checkboxes = $("#design_pages").find(":checkbox");
	var count = checkboxes.length;
	var countChecked = $("#design_pages").find(":checkbox:checked").length;
	
	checkboxes.each(function(){
		if(countChecked != count){
			$(this).attr('checked',true);
			$(this).parent().addClass("checked");
		}else{
			$(this).attr('checked',false);
			$(this).parent().removeClass("checked");
		}
	});
	 $('input:checkbox').not(this).prop('checked', this.checked);
});


$("#addPage").click(function(e){
	var linkId = $("#linkId").val();
	
	var openwindow = $("#open-window-page:checked").val();
	if(openwindow == undefined)
		openwindow = "off";
	
	var linkType = "page";
	
	var pages = [];
	$("input[name='page']:checked").each(function(){
		pages[$(this).attr("id").substring(5)] = $(this).attr("ar_element")+":=:"+$(this).attr("en_element");			
	});
	
	
	var error  = 0;
	if($.isEmptyObject(pages)){
		$("#pages").find(".help-block1").remove();
		$("#pages").append('<span class="help-block1">لابد من اختيار صفحة على الأقل</span>');
		error++;
	}else{
		$("#pages").find(".help-block1").remove();
	}
	
	if(error == 0){
		for (var k in pages){
		    if (pages.hasOwnProperty(k)) {		         
		         var data = {};
				data["page_id"] = k;			
				var settings = JSON.stringify(data);
				
				$('div>ol.dd-list').append('<li class="dd-item dd3-item" notsaved data-id="' +  linkId +
				 '" id="'+linkId+'" link-type="'+linkType+'" open-window="'+openwindow+'" settings=\''+settings+
				 '\' name="'+ pages[k] +'"><div class="dd-handle dd3-handle"></div><span class="class2"><button id="delete-'+ linkId +'" class="delete">delete</button></span><div class="dd3-content"> ' +  pages[k] + '</div></li>');
				  $("#linkId").val(parseInt($("#linkId").val(),10) +1);
				  linkId = $("#linkId").val();
				 $("#linktxt").val("");
				 $("#link").val("");
				 $("#open-window").prop('checked', false); 
				 $("#open-window").parent().removeClass("checked");	
				 $(".dd").trigger("change");	
		    }
		}
		$(".delete").on('click',deleteRow);
	}
	
});
$("#addLink").click(function(e){
	
	var linkId = $("#linkId").val();
	
	var openwindow = $("#open-window:checked").val();
	if(openwindow == undefined)
		openwindow = "off";
	
	var linkType = "link";
	var linkname = $("#ar_linktxt").val()+':=:'+$("#en_linktxt").val();
	var error  = 0;
	if($("#en_linktxt").val() ==""){
		$("#en_linktxt").parent().find(".help-block").remove();
		$("#en_linktxt").parent().append('<span class="help-block">نص الرابط مطلوب</span>');
		$("#en_linktxt").closest(".form-group").addClass("has-error");
		error++;
	}else{
		$("#en_linktxt").parent().find(".help-block").remove();
		$("#en_linktxt").closest(".form-group").removeClass("has-error");
	}
	
	if($("#link").val() ==""){
		$("#link").parent().find(".help-block").remove();
		$("#link").parent().append('<span class="help-block"> الرابط مطلوب</span>');
		$("#link").closest(".form-group").addClass("has-error");
		error++;
	}else{
		$("#link").parent().find(".help-block").remove();
		$("#link").closest(".form-group").removeClass("has-error");
	}
	var link = $("#link").val();
	if(error == 0){
		var data = {};
		data["link"] = link;
		var settings = JSON.stringify(data);
		var temp = JSON.parse(settings);
		
		$('div>ol.dd-list').append('<li class="dd-item dd3-item" notsaved data-id="' + linkId +
		 '" id="'+linkId+'" link-type="'+linkType+'" open-window="'+openwindow+'" settings=\''+settings+
		 '\' name="'+ linkname +'"><div class="dd-handle dd3-handle"></div><span class="class2"><button id="delete-'+ linkId +'" class="delete">delete</button></span><div class="dd3-content"> ' + linkname + '</div></li>');
		 $("#linkId").val(parseInt($("#linkId").val(),10) +1);
		 linkId = $("#linkId").val();
		 $("#en_linktxt").val("");
		 $("#ar_linktxt").val("");
		 $("#link").val("");
		  $("#open-window").prop('checked', false); 
		  $("#open-window").parent().removeClass("checked");
		  $(".dd").trigger("change");	
	}
	
});


$("#addSubMenu").click(function(e){
	
	var linkId = $("#linkId").val();
	
	var openwindow = 0;
	var linkType = "menu";
	console.log($("#ar_submenu").val());
	var submenu = $("#ar_submenu").val()+":=:"+$("#en_submenu").val();
	var error  = 0;
	if($("#en_submenu").val() ==""){
		$("#en_submenu").parent().find(".help-block1").remove();
		$("#en_submenu").parent().append('<span class="help-block1">القائمة الفرعية مطلوبة</span>');
		$("#en_submenu").closest(".form-group").addClass("has-error");
		error++;
	}else{
		$("#en_submenu").parent().find(".help-block1").remove();
		$("#en_submenu").closest(".form-group").removeClass("has-error");
	}
	
	if(error == 0){
		var settings = "";
		$('div>ol.dd-list').append('<li class="dd-item dd3-item" notsaved data-id="' + linkId +
		 '" id="'+linkId+'" link-type="'+linkType+'" open-window="'+openwindow+'" settings=\''+settings+
		 '\' name="'+ submenu +'"><div class="dd-handle dd3-handle"></div><span class="class2"><button id="delete-'+ linkId +'" class="delete">delete</button></span><div class="dd3-content"> ' + submenu + '</div></li>');
		 $("#linkId").val(parseInt($("#linkId").val(),10) +1);
		 linkId = $("#linkId").val();
		 $("#en_submenu").val("");
		 $("#ar_submenu").val("");
		 $(".dd").trigger("change");	
	}
	
});

$("#addDesign").click(function(e){
	var linkId = $("#linkId").val();
	
	var openwindow = $("#open-window-design:checked").val();
	if(openwindow == undefined)
		openwindow = "off";
	
	//var linkType = "page";
	
	var pages = [];
	$("input[name='design']:checked").each(function(){
		pages[$(this).attr("id")] = $(this).attr("ar_element")+":=:"+$(this).attr("en_element");			
	});
	
	
	var error  = 0;
	if($.isEmptyObject(pages)){
		$("#design_pages").find(".help-block").remove();
		$("#design_pages").append('<span class="help-block">لابد من اختيار صفحة على الأقل</span>');
		$("#design_pages").closest(".form-group").addClass("has-error");
		error++;
	}else{
		$("#design_pages").find(".help-block").remove();
		$("#design_pages").closest(".form-group").removeClass("has-error");
	}
	
	if(error == 0){
		for (var k in pages){
		    if (pages.hasOwnProperty(k)) {		         
		         var data = {};
				//data["page_id"] = k;			
				//var settings = JSON.stringify(data);
				var settings = "";
				$('div>ol.dd-list').append('<li class="dd-item dd3-item" notsaved data-id="' +  linkId +
				 '" id="'+linkId+'" link-type="'+k+'" open-window="'+openwindow+'" settings=\''+settings+
				 '\' name="'+ pages[k] +'"><div class="dd-handle dd3-handle"></div><span class="class2"><button id="delete-'+ linkId +'" class="delete">delete</button></span><div class="dd3-content"> ' +  pages[k] + '</div></li>');
				  $("#linkId").val(parseInt($("#linkId").val(),10) +1);				
				linkId = $("#linkId").val();
				 $("#open-window-design").prop('checked', false); 
				 $("#open-window-design").parent().removeClass("checked");	
					$(".dd").trigger("change");	
		    }
		}
		$(".delete").on('click',deleteRow);
	}
	
});







$(".delete").on('click',deleteRow);
function deleteRow(e){
	$(this).parent().parent().remove();
	$(".dd").trigger("change");	
};

$("#saveMenu1").on('click',saveMenu);
$("#saveMenu").on('click',saveMenu);
function saveMenu(e){
	var data = [];
	$("#nestable_list_3").find("li[notsaved]").each(function(){
		var row ={};
		row['id']=$(this).attr("data-id");
		row['name']=$(this).attr("name");
		row['link_type']=$(this).attr("link-type");
		row['open_window']=$(this).attr("open-window");
		row['sort_order']=$(this).parent().children().index(this);
		row['settings']=$(this).attr("settings");
		data.push(row);
	});
	var menuId = $("#menu_id").val();
	var menuName = $("#menuNameEdit").val();
	var ar_menuName = $("#ar_menuNameEdit").val();
	var shop_id = $("#links_shopId").val();
	
	$.ajax({
 			url:'{{url("/admin/menus/savetree/")}}',
 			type: 'post',
 			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
 			data: {data: data,jsontree: $("#nestable2-output").val(),menuName: menuName,
 			menuId: menuId,shop_id: shop_id,ar_menuName: ar_menuName},
 			beforeSend: function(){
						 $('.demo-loading-btn').button('loading');
			},
	        success: function( message ) {
	        	
                $('.demo-loading-btn').button('reset');
                 $("#reloadMenu").load(document.URL +  ' #reloadMenu',function(responseText, textStatus, XMLHttpRequest){
						$("#menuSelect").val(menuId);
						$("#menuSelect").change(menuSelectFun);
						// $(".delete").on('click',deleteRow);
					});
                $(".reload").trigger("click");   
                 
	        },
	        error: function( data ) {
	            
	        }
 		});
};
$("#deleteMenu").on('click',deleteMenuFun);
function deleteMenuFun(e){
	var menuName = $("#menuNameEdit").val();
	var menu =$(this);
	bootbox.confirm("-.......................           الحذف لا يمكن التراجع عنه! هل أنت متأكد من حذف " + menuName + " ؟ ", function(result) {
		if (result == true) {
			var menuId = $("#menu_id").val();
			$.ajax({
		 			url:'{{url("/admin/menus/deletemenu/")}}',
		 			type: 'post',
		 			headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    },
		 			 data: {menuId: menuId},
		 			 beforeSend: function(){
								menu.parent().append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
							},
				      success: function( message ) {
				      	console.log(message);
			                 menu.parent().children('img').remove();
			                $("#reloadMenu").load(document.URL +  ' #reloadMenu',function(responseText, textStatus, XMLHttpRequest){
								$("#menuSelect").change(menuSelectFun);	
								$("#menuSelect").trigger("change");					
							});
							reloadTab2();
				       },
				       
		 		});
		 }
	 });
};

$("#menuBtn").click(function(e){
	var error = 0;
	if($("#menuName").val() ==""){
		$("#menuName").parent().find(".help-block1").remove();
		$("#menuName").parent().append('<span class="help-block1">اسم القائمة مطلوب</span>');
		error++;
	}else{
		$("#menuName").parent().find(".help-block1").remove();
	}
	if(error == 0){
		$.ajax({
 			url:'{{url("/admin/menus/addmenu/")}}',
 			type: 'post',
 			headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
 			 data: {name: $("#menuName").val(),shop_id:$("#shopId").val()},
 			 beforeSend: function(){
				 $('.demo-loading-btn').button('loading');
			},
		      success: function( message ) {
		      	console.log(message);
		        	$("#menuName").val("");
		        	$('#static').modal('toggle');
	                $('.demo-loading-btn').button('reset');
	                $("#reloadMenu").load(document.URL +  ' #reloadMenu',function(responseText, textStatus, XMLHttpRequest){
						$("#menuSelect").val(message);
						$("#menuSelect").change(menuSelectFun);
						$("#menuSelect").trigger("change");	
					});
					reloadTab2();
		       },
		       
 		});
	}
});
function reloadTab2(){
	  $("#tab2").load(document.URL +  ' #tab2',function(responseText, textStatus, XMLHttpRequest){
			$("#savePos").on("click",savePosFun);
		});
}

</script>