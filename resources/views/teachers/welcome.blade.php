@extends('teachers/layouts/master')


@section('header_styles')	
	<link rel="stylesheet" href="{{asset('assets/admin/vendors/animate/animate.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/admin/css/only_dashboard.css')}}" />
	<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')
<div class="alert alert-success alert-dismissable margin5">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Success:</strong> You have successfully logged in.
</div>
<!-- Main content -->
<section class="content-header">
    <h1>Welcome to Dashboard</h1>
    <ol class="breadcrumb">
        <li class="active">
            <a href="{{url('/teachers')}}">
                <i class="livicon" data-name="home" data-size="14" data-color="#333" data-hovercolor="#333"></i> Dashboard
            </a>
        </li>
    </ol>
</section>



<!-- BEGIN CONTAINER -->
<section class="content">
    <div class="row">
        Dashboard
    </div>
    <!--/row-->
    
    
    <div class="clearfix"></div>
    <div class="row ">
        <div class="col-md-4 col-sm-12">
            <div class="panel panel-danger">
                <div class="panel-heading border-light">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="mail" data-size="18" data-color="white" data-hc="white" data-l="true"></i>
                        Quick Mail
                    </h4>
                </div>
                <div class="panel-body no-padding">
                    <div class="compose row">
                    	<div id="quick_result_message"></div>
                    	<form method="post" id="quickmail_form" action="{{url('/teachers/home/sendemail')}}"/>
                    	{{csrf_field()}}
                    		<div class="form-group">
                    			 <label class="col-md-3 hidden-xs">To:</label>
	                        	 <input type="text" class="col-md-9 col-xs-9" name="quick_email" placeholder="name@email.com " tabindex="1" />
                    		</div>
	                       
	                        <div class="form-group">
		                        <label class="col-md-3 hidden-xs">Subject:</label>
		                        <input type="text" class="col-md-9 col-xs-9" name="quick_subject" tabindex="1" placeholder="Subject" />
		                    </div>
	                        
	                        <div class='box-body'>
	                        	<div class="form-group">
	                            	<textarea class="textarea textarea_home" name="quick_message" placeholder="Write mail content here"></textarea>
	                            </div>                            
	                        </div>
	                        <br />
	                        <div class="pull-right">
	                            <input type="submit" class="btn btn-danger" id="quick_send" data-loading-text="sending..." value="Send">
	                        </div>
	                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading border-light">
                    <h4 class="panel-title">
                        <i class="livicon" data-name="bell" data-size="18" data-color="white" data-hc="white" data-l="true"></i>
                        Notifications
                    </h4>
                </div>
                <div class="panel-body no-padding">
                    There are no new notifications
                </div>
            </div>
        </div>
        
    </div>
</section>
@endsection

@section("footer_scripts")

    
    <!--Sparkline Chart-->
    <script src="{{asset('assets/admin/vendors/charts/jquery.sparkline.js')}}"></script>
    <!-- Back to Top-->
	<script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>
	<script src="{{asset('assets/admin/js/dashboard.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>

@endsection
