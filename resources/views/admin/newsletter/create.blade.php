@extends('admin/layouts/master')

@section('title')
	Edit Newsletter
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/> 
@endsection
                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
<!--section starts-->
    <h1>Add Newsletter</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/newsletter')}}">newsletters</a>
        </li>       
        <li class="active">create</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable portlet box">
            	 <div class="panel-heading clearfix">
	                    <div class="panel-title pull-left">
                           <div class="caption">
		                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
		                        add newsletter
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                	@if(Session::has('Newsletter_Inserted'))
				        <div class="alert alert-success">
				            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				            {!! Session::get('Newsletter_Inserted') !!}
				        </div>
				    @endif
				    @if (count($errors) > 0)
	                <div class="alert alert-danger">
	                    <ul>
	                        @foreach ($errors->all() as $error)
	                        <li>{{ $error }}</li>
	                        @endforeach
	                    </ul>
	                </div>
	                @endif
	                <div id="errorDiv" class="alert alert-danger display-none"></div>
	                	
	                @include("admin.newsletter._form",array("method"=>"add"))
                </div>
           </div>
	    </div>
	</div>
</section>
@endsection    
@section("footer_scripts")
<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>

	@include("admin.newsletter.js.form_js")
@endsection