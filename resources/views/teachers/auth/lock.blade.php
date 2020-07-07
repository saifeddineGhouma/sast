<!DOCTYPE html>
<html>

<head>
    <title>Lock Screen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <!-- global level css -->
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!-- end of global level css -->
    <!-- page level css -->
    <link href="{{asset('assets/admin/css/pages/lockscreen.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/admin/vendors/formcolorloader/gradient/fort.css')}}" />
    <!-- end of page level css -->
</head>

<body>
    <div class="top">
        <div class="colors"></div>
    </div>
    <div class="container">
        <div class="login-container">
            <div id="output"></div>
            <div class="avatar"></div>
            <div class="form-box">
            	
                <form method="POST" id="lock-form" name="screen" action="{{url('teachers/home/lock')}}">
                	{{csrf_field()}}
                    <div class="form">
                        <p class="form-control-static">{{Auth::guard("teachers")->user()->name}}</p>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                         
	                    <a class="notadmin" href="{{url('teachers/home/logout1')}}">لست {{Auth::guard("teachers")->user()->name}} ؟</a>
                        <button class="btn btn-info btn-block login" id="index" type="submit">GO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script src="{{asset('assets/admin/js/jquery-1.11.3.min.js')}}" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="{{asset('assets/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/holder/holder.js')}}"></script>
    <!-- end of global js -->
    <!-- begining of page level js-->
   
    <script src="{{asset('assets/admin/vendors/formcolorloader/gradient/fort.js')}}"></script>
    <script>
   		gradient();
    	$(function(){
			var textfield = $("input[name=password]");
            $('button[type="submit"]').click(function(e) {
            	
                e.preventDefault();
                //little validation just to check username
                if (textfield.val() !== "") {
                    
                    var data = $("#lock-form").serialize();
                    $.ajax({
                    	url: $("#lock-form").attr('action'),
                    	type: "POST",
                    	data: data,
                    	 beforeSend: function(){
							//obj.addClass("spinner");
						},
						success: function( result ) {
							if(result == "autherror"){
								location.href = "{{url('teachers/login')}}";
							}else if(result == "passwordIncorrect"){
								$("input[name='password']").val("");
								 $("#output").removeClass(' alert alert-success');
                    			$("#output").addClass("alert alert-danger animated fadeInUp").html("sorry Your Password Is Incorrect");
							}else{
								
			                    $("#output").addClass("alert alert-success animated fadeInUp").html("Welcome back Admin");
			                    $("#output").removeClass(' alert-danger');
			                    $("input").css({
			                    "height":"0",
			                    "padding":"0",
			                    "margin":"0",
			                    "opacity":"0"
			                    });
			                    //change button text 
								$(".notadmin").remove();
			                    $('button[type="submit"]').html("continue")
			                    .removeClass("btn-info")
			                    .addClass("btn-success").click(function(){
			                     	window.location.href = "{{url('/teachers')}}";
			                    });
			                    
			                    //show avatar
			                    $(".avatar").css({
			                        "background-image": "url('../../assets/admin/img/img_holder/400-x-699-green.jpg')"
			                    });
							}
							
						}
                    });
                    
                } else {
                    //remove success mesage replaced with error message
                    $("#output").removeClass(' alert alert-success');
                    $("#output").addClass("alert alert-danger animated fadeInUp").html("sorry enter Your Password ");
                }
                //console.log(textfield.val());
			
			});
		});

    </script>
    <!-- end of page level js-->
</body>
</html>
