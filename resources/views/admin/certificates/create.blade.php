@extends('admin/layouts/master')

@section('title')
    Create {{ $record_name }}
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />
 <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>
 <link href="{{asset('assets/admin/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet" type="text/css" media="all"/>
@endsection
                 
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Create {{ $record_name }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/'.$table_name)}}">{{ $table_name }}</a>
        </li>       
        <li class="active">create</li>
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
                               Add New {{ $record_name }}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
                    <form id="form1" action="{{ url('admin/'.$table_name) }}" method="POST" class="form-horizontal form-row-seperated" novalidate>
                        {{ csrf_field() }}

                        @include('admin.'.$table_name.'._form',array("method"=>"add"))

                    </form>
                </div>
           </div>
	    </div>
	</div>
</section>

@endsection 

@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
	
	<script src="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap-colorpicker.js')}}"></script>
    <script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>

	@include("admin.".$table_name.".js.form_js")
@endsection   

