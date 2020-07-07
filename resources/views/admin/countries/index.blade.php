@extends('admin/layouts/master')

@section('title')
Countries
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('assets/admin/vendors/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />   
<link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Countries</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">countries</li>
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
		                        Countries
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
                    <div class="alert alert-success" id="displayMessages" style="display: none;"></div>
                	<div class="table-toolbar">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <div class="btn-group">
	                                <a data-toggle="modal" href="#modal-2" id="sample_editable_1_new" class="btn add-country">
	                                	<i class="fa fa-plus"></i> Add Country
	                                </a>
	                            </div>
	                           
	                        </div>
	                    </div>
	                </div>
	                <div id="reloaddiv">
	                    <table class="table table-striped table-bordered" id="table1">
	                        <thead>
	                            <tr>
	                            	<th>#</th>
	                                <th>en_name</th>
	                                <th>ar_name</th>
	                               	<th>code</th>
									<th>sort order</th>
	                                <th>actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($countries as $u)
	                        	<?php
	                        		$ar_name = "";
									$en_name = "";
	                        	?>
	                            <tr>
	                            	<td>{{$u->id}}</td>
	                            	<td>
	                            		@if(!empty($u->country_trans("en")))
	                            		<?php
                            				$en_name = $u->country_trans("en")->name;
                            			?>
	                            			{{$en_name}}
	                            		@endif
	                            	</td>
	                            	<td>
	                            		@if(!empty($u->country_trans("ar")))
	                            			<?php
	                            				$ar_name = $u->country_trans("ar")->name;
	                            			?>
	                            			{{$ar_name}}
	                            		@endif
	                            	</td>
	                            	<td>
	                            		{{$u->code}}
	                            	</td>
									<td>
										{{ $u->sort_order }}
									</td>
	                                <td>
	                                	<a>
                                            <i class="livicon btnedit" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit country"
                                            data-toggle="modal" href="#modal-2" data-id="{{$u->id}}" data-ar_name="{{$ar_name}}" data-en_name="{{$en_name}}"
                                            data-code="{{$u->code}}" data-sort_order="{{ $u->sort_order }}"></i>
                                        </a>
                                        <a data-toggle="modal" class="deletcountry" elementId="{{$u->id}}">
                                            <i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete country"></i>
                                        </a>
	                                </td>
	                            </tr>
	                            @endforeach
	                        </tbody>
	                    </table>
                            
                	</div>
	            </div>
	         </div>
	    </div>
	</div>
</section>
   
@include('admin.countries._form')

@endsection
@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>
    
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>
@include('admin.countries.js.index_js')
@include('admin.countries.js.form_js')
@endsection



