@extends('admin/layouts/master')

@section('title')
Agents
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('assets/admin/vendors/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />   
<link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>
<link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Agents</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">agents</li>
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
		                        Agents
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
	                <div class="well">
		              	<div class="row" >
				            <label class="control-label col-md-1 col-md-offset-2">  Country</label>
				            <div class="col-md-6" id="reloadGovern2">
				                <select  id="country_search" name="country_search" placeholder="اختار" class="form-control select2">
				                    @foreach($countries as $country)
				                    	<option value= "{{$country->id}}"  >{{$country->country_trans("en")->name}}</option>
				                    @endforeach
				                    <option value="0">الكل</option>
				                </select>
				            </div>
				            <div class="col-md-2">
				            	
				            </div>
						</div>
		            </div>
		              
                    <div class="alert alert-success" id="displayMessages" style="display: none;"></div>
                	<div class="table-toolbar">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <div class="btn-group">
	                                <a data-toggle="modal" href="#modal-2" id="sample_editable_1_new" class="btn add-agent">
	                                	<i class="fa fa-plus"></i> Add Agent
	                                </a>
	                            </div>
	                           
	                        </div>
	                    </div>
	                </div>
	                <div id="reloaddiv">
	                	<div id="agents_results">
		              
                  		</div>
                	</div>
	            </div>
	         </div>
	    </div>
	</div>
</section>
   
@include('admin.agents._form')

@endsection
@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>
    
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
@include('admin.agents.js.index_js')
@include('admin.agents.js.form_js')
@endsection



