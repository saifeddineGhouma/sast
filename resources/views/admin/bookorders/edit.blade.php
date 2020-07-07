@extends('admin/layouts/master')

@section('title')
edit book order
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
  
  <link href="{{asset('assets/admin/css/pages/editor.css')}}" rel="stylesheet" type="text/css"/>
  
   <link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
 
 <link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>
 <style type="text/css" >
      #map_canvas {
              width:300px;
            height:300px;
     }
</style>
@endsection


                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>edit book order {{$order->id}}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/book-orders')}}">Book Orders</a>
        </li>       
        <li class="active">edit</li>
    </ol>
</section>
<!--section ends-->

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable portlet box">
            	 <div class="panel-heading clearfix">
	                    <div class="panel-title pull-left">
                           <div class="caption">
		                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
		                        edit book order {{$order->id}}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
	                @include("admin.bookorders._form",array("method"=>"edit"))
                </div>
           </div>
	    </div>
	</div>
</section>   


@endsection  
  
@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
<script  src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script  src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script  src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>
	
	<script src="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>
    <script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	@include("admin.bookorders.js.form_js")
@endsection
