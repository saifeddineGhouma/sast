<script type="text/javascript">



$("#year").change(courses_select);
function courses_select(e){
    var year = $(this).val();
    var yearcontrol = $(this);

    if(year!=""){
        $.ajax({
            url: "{{ url('/load-courses') }}",
            data: {year: year},
            type: "get",
            beforeSend: function(){
                yearcontrol.closest(".form-group").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
            },
            success: function(result){

               $("#course_id").html(result["courses"]);
            },
            complete: function(){
                yearcontrol.closest(".form-group").children('img').remove();
            }
        });
    }
}

function paginate(btn){
    btn = $(btn);
    var current = $("input[name='start']").val();
    var start = btn.data("start");
    if(start!=current){
        $("input[name='start']").val(start);
        $("#search_form").submit();
    }

}

function formFilter(e){
	e.preventDefault();
	var data = $('#search_form').serializeArray();
  
	$.ajax({
		url: "{{ url(App('urlLang').'load-graduates') }}" ,
		type: "GET",
		data: data,
		beforeSend: function(){
			 $('#filterBtn').button('loading');
            $('#filterBtn').after("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
//			 $("#content_loading").modal("show");
		},
		success: function(result){
			result = $.parseJSON(result);
        	var output = result[0];
    	 	output = output.replace(/\\"/g , '"');
    	 					
			$("#graduates_content").html(output);
            $("#content_loading").modal("hide");
		},
		error: function(error){
			
		},
		complete: function(){
			 $('#filterBtn').button('reset');
            $('#filterBtn').parent().children('img').remove();
//            $("#content_loading").modal("hide");
		}
	});
};

$("#search_form").on("submit",formFilter);
$("#search_form").submit();
$("#content_loading").modal("hide");

</script>