@extends('admin/layouts/master')

@section('title')
	User Profile
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
  	<link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/vendors/x-editable/css/bootstrap-editable.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/pages/user_profile.css')}}" rel="stylesheet" type="text/css"/>
@endsection
                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>{{$user->username}} Profile </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/users')}}">users</a>
        </li>       
        <li class="active">profile</li>
    </ol>
</section>
<!--section ends-->
@if(Session::has('password_updated'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('password_updated') }}
    </div>
@endif
<section class="content">
    <div class="row">
        <div class="col-lg-12">
             @include("admin.users._view")
        </div>
    </div>
</section>
<!-- content -->

@endsection    
@section("footer_scripts")	
<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	<script  src="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/x-editable/jquery.mockjax.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/x-editable/bootstrap-editable.js')}}" type="text/javascript"></script>
  
	@include("admin.users.js.view_js")
@endsection
