<!DOCTYPE html>
<html>   
	<head>
		<meta charset="utf-8" />
		<title> 
			@section('title')
	             Teacher Dashboard
	        @show
        </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('meta')
		
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		 <!-- global css -->
	    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
	    <!-- font Awesome -->
	    <link href="{{asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
	    <link href="{{asset('assets/admin/css/styles/black.css')}}" rel="stylesheet" type="text/css" id="colorscheme" />
	    <link href="{{asset('assets/admin/css/panel.css')}}" rel="stylesheet" type="text/css" />
	    <link href="{{asset('assets/admin/css/metisMenu.css')}}" rel="stylesheet" type="text/css" />
	    <!-- end of global css -->
	    <!--page level css -->
	     @yield('header_styles')
	    <!--end of page level css-->
		 <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet" type="text/css" />
		  <script src="{{asset('assets/admin/js/jquery-1.11.3.min.js')}}" type="text/javascript"></script>
	</head>
    <!-- END HEAD -->

 	<body class="skin-josh">
        <!-- BEGIN HEADER -->
        @include('teachers.layouts._header')
        <!-- END HEADER -->
        <div class="wrapper row-offcanvas row-offcanvas-left">
        	<aside class="left-side sidebar-offcanvas">
            	@include("teachers.layouts._sidebar")
            </aside>
            <!-- Right side column. Contains the navbar and content of the page -->
        	<aside class="right-side">
              @yield("content")
            </aside>
        </div>
        
        <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
	        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
	    </a>
    
    <!-- global js -->
   
    <script src="{{asset('assets/admin/vendors/fullcalendar/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!--livicons-->
    <script src="{{asset('assets/admin/vendors/livicons/minified/raphael-min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/livicons/minified/livicons-1.4.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/josh.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/metisMenu.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/holder/holder.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/js/notifications/sweetalert2.all.js') }}"></script>
    <!-- end of global js -->
    <!-- begin page level js -->
		@yield('footer_scripts')
	<!-- end page level js -->
	@include("teachers.layouts.js.active_link_js")
    </body>
</html>