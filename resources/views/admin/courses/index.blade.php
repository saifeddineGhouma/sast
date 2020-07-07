@extends('admin/layouts/master')

@section('title')
{{ ucfirst($table_name) }}
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />

<link href="{{asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
@endsection
                 
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>{{ ucfirst($table_name) }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">{{ ucfirst($table_name) }}</li>
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
							   {{ ucfirst($table_name) }}
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
								<div class="col-md-3 col-sm-3">
									<div class="form-group">
										<label class="control-label bold">Name</label>
										<input type="text" name="name" class="form-control">
									</div>
								</div>
								<div class="col-md-3 col-sm-3">
									<div class="form-group">
										<label class="control-label bold">Category</label>
										<select  name="category_id[]" id="category_id"  class="form-control select2 select2-hidden-accessible" multiple aria-hidden="true" >
                                            @foreach($categories as $category)
												<option value="{{$category->id}}">{{$category->category_trans("ar")->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-3">
									<div class="form-group">
										<label class="control-label bold">Price</label>
										<select  name="price" id="price"  class="form-control select2" aria-hidden="true" >
											<option>All</option>
											<option value="paid">Paid</option>
											<option value="free">Free</option>
										</select>
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group">
										<label class="control-label bold">Date Added</label>
										<input class="form-control date-picker" size="16" type="text" name="created_at" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-4">
									<div class="form-group form-md-checkboxes" style="margin-top: 20px;">
										<div class="md-checkbox-inline">
											<div class="md-checkbox">
												<input type="checkbox" id="checkbox6" name="trashed" class="md-check">
												<label for="checkbox6">
													<span></span>
													<span class="check"></span>
													<span class="box"></span>only trashed</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<button type="submit" id="filterBtn" class="btn green demo-loading-btn col-md-6" style="margin-top: 25px;" data-loading-text="<li class='fa fa-search'></li> Searching...">
										<li class="fa fa-search"></li> search
									</button>
								</div>
							</div>
						</form>
					</div>

					<div class="table-toolbar">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <div class="btn-group">
	                                <a href="{{url('admin/'.$table_name.'/create')}}" id="sample_editable_1_new" class="btn">
	                                	<i class="fa fa-plus"></i> Add {{ ucfirst($record_name) }}
	                                </a>
	                            </div>
	                           
	                        </div>
	                    </div>
	                </div>
	                <div id="reloaddiv">
						<div id="childList"></div>
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

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>

	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
@include('admin.'.$table_name.'.js.index_js')


@endsection

