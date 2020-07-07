@extends('teachers/layouts/master')

@section('title')
Forum
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('assets/admin/vendors/x-editable/css/bootstrap-editable.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Forum</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/teachers')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                dashboard
            </a>
        </li>
        <li class="active">Forum</li>
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
                               Forum
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                	<div id="loadmodel_category" class="modal fade in" role="dialog"  style="display:none; padding-right: 17px;">
	                    <div class="modal-dialog">
	                        <div class="modal-content">
	                          <div class="modal-body">
	                                <img src="{{asset('assets/admin/img/ajax-loading.gif')}}" alt="" class="loading">
	                                <span> &nbsp;&nbsp;Loading... </span>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                
	                <div class="well table-toolbar">
                    	<form id="search_form" name="search_form" method="get">
                        <div class="row">
                            <div class="col-md-4">
                          		 <div class="form-group">
                                    <label class="control-label bold">course</label>
                                    <select name="course_id" class="form-control">
                                   		<option value="0">choose...</option>
                                   		@foreach($courses as $course)
                                   			<option value="{{$course->id}}">{{$course->course_trans("ar")->name}}</option>
                                   		@endforeach
                                    </select>
                                </div>
                          	</div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label class="control-label bold">client</label>
                                    <select name="user_id" class="form-control select2" >
                                        <option value="0">choose...</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->full_name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label bold">date added</label>
                                    <input class="form-control date-picker" size="16" type="text" name="created_at" />
                                </div>
                            </div>
                          </div>
                          <div class="row">                          	

                            <div class="col-md-4">
                                <button type="submit" id="filterBtn" class="btn green demo-loading-btn col-md-6" style="margin-top: 25px;" data-loading-text="<li class='fa fa-search'></li> searching...">
                                   <li class="fa fa-search"></li> search
                                </button>
                            </div> 
                          </div> 
                        </form>    
                    </div>                    
                    
                	<div class="table-toolbar">
	                    <div class="row" style="margin-top: 20px;">
	                        
	                    </div>
	                </div>
	                <div id="reloaddiv">
	                    <div id="tableChildList"></div>
                	</div>
	            </div>
	         </div>
	    </div>
	</div>
</section>


@endsection

@section("footer_scripts")
    <script src="{{asset('assets/admin/vendors/datatables/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/x-editable/bootstrap-editable.js')}}" type="text/javascript"></script>
	
    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>
    
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
@include('teachers.forum.js.index_js')

@endsection


