@extends('admin/layouts/master')

@section('title')
	Edit Email Template
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 
@endsection
       
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Edit Email Template {{$emailTemplate->subject}}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/emailtemplates')}}">email templates</a>
        </li>       
        <li class="active">update</li>
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
		                        Edit email template {{$emailTemplate->subject}}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                	@if(Session::has('EmailTemplate_Updated'))
				        <div class="alert alert-success">
				            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				            {{ Session::get('EmailTemplate_Updated') }}
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
	                	
	                @include("admin.emailtemplates._form",array("method"=>"edit"))
                </div>
           </div>
	    </div>
	</div>
</section>

@endsection 
 
@section("footer_scripts")
<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>

<script  src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script  src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script  src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>

	@include("admin.emailtemplates.js.form_js")
@endsection 
 

