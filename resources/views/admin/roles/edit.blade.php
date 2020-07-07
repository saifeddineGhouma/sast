@extends('admin/layouts/master')

@section('title')
	Edit Role
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('assets/admin/vendors/jquery-multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Edit Role {{$role->display_name}}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/admins')}}">admins</a>
        </li>
        <li>
            <a href="{{url('/admin/roles')}}">roles</a>
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
		                        Edit Role {{$role->display_name}}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                	@include('common.flash')
					@include('common.errors')
	                @include("admin.roles._form",array("method"=>"edit"))
                </div>
           </div>
	    </div>
	</div>
</section>
 
@endsection

@section("footer_scripts")
<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/jquery-multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/pages/components-multi-select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
@include("admin.roles.js.form_js")
@endsection
