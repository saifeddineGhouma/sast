@extends('admin/layouts/master')

@section('title')
Coupons
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
    <h1>Coupons</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Coupons</li>
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
		                        Coupons
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
                    
                	<div class="table-toolbar">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <div class="btn-group">
	                                <a href="{{url(App('urlLang').'admin/coupons/create')}}" id="sample_editable_1_new" class="btn">
	                                	<i class="fa fa-plus"></i> Add Coupon
	                                </a>
	                            </div>
	                           
	                        </div>
	                    </div>
	                </div>
	                <div id="reloaddiv">
	                    <table class="table table-striped table-bordered" id="table1">
	                        <thead>
	                            <tr>
	                            	<th>Coupon Number</th>
	                                <th>Discount</th>
	                                <th>total greater than</th>
	                                <th>date from</th>
	                                <th>date to</th>
	                                <th>date added</th>
	                                <th>Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	 @foreach($coupons as $u)
									<tr>
										<td>
											 {{ $u->coupon_number }}
										</td>
										<td>
											 {{ $u->discount }} %
										</td>
										<td>
											 {{ $u->ordertotal_greater }} %
										</td>
										<td>
											{{ $u->date_from }}
										</td>
										<td>
											{{ $u->date_to }}
										</td>
										<td>
											{{date("Y-m-d",strtotime($u->created_at))}}
										</td>										
										<td>
											<a href="{{url('admin/coupons/edit/'.$u->id)}}">
	                                            <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit coupon"></i>
	                                        </a>
	                                        
	                                        <a data-toggle="modal" class="deletecoupon" elementId="{{$u->id}}">
	                                            <i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete coupon"></i>
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


@endsection

@section("footer_scripts")
    <script src="{{asset('assets/admin/vendors/datatables/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/x-editable/bootstrap-editable.js')}}" type="text/javascript"></script>
	
    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>
    
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	
@include('admin.coupons.js.index_js')

@endsection


