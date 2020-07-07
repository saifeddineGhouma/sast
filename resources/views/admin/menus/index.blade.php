@extends('admin/layouts/master')

@section('title')
Menus
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/bootstrap-modal/css/bootstrap-modal-bs3patch.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/bootstrap-modal/css/bootstrap-modal.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />	   
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/vendors/jquery-nestable/jquery.nestable.css')}}"/>
<style>
	.class1{
		position: absolute;
	    margin: 0;
	    left: 60px;
	    top: 0;
	    width: 30px;
	}
	.class2{
		position: absolute;
	    margin: 0;
	    right: 120px;
	    top: 0;
	    width: 30px;
	}
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Menus </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>   
        <li class="active">Menus</li>
    </ol>
</section>
<!--section ends-->

<div class="page-content-wrapper">
			<div class="panel-body">
				
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="tabbable-custom ">
				<ul class="nav nav-tabs ">
					<li class="active">
						<a href="#tab_5_1" data-toggle="tab">
						Edit Menus </a>
					</li>
					<li>
						<a href="#tab_5_2" data-toggle="tab">
						Manage Locations </a>
					</li>									
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_5_1">
						@include("admin.menus.tab1")
						
					</div>
					<div class="tab-pane" id="tab_5_2">
						@include("admin.menus.tab2")
					</div>
					
				</div>
			</div>
				
	</div>	
</div>
	

	
@endsection

@section("footer_scripts")

 <script src="{{asset('assets/admin/vendors/jquery-nestable/jquery.nestable.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/bootstrap-modal/js/bootstrap-modalmanager.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/bootstrap-modal/js/bootstrap-modal.js')}}" type="text/javascript"></script>
@include('admin.menus.js.index_js')
<script src="{{asset('assets/admin/js/pages/ui-nestable.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/pages/ui-extended-modals.js')}}" type="text/javascript"></script>

@endsection
