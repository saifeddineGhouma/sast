@extends('teachers/layouts/master')

@section('title')
	{{ ucfirst($table_name) }}
@endsection

@section("header_styles")
	<link href="{{asset('assets/admin/vendors/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
	<link href="{{asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
                 
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<!--section starts-->
		<h1>{{ ucfirst($table_name) }}</h1>
		<ol class="breadcrumb">
			<li>
				<a href="{{url('/teachers')}}">
					<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
					dashboard
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

					<div class="table-toolbar">
						<div class="row" style="margin-bottom: 20px;">
						</div>
					</div>
						<div id="reloaddiv">
							<table class="table table-striped table-bordered" id="table1">
								<thead>
								<tr>
									<th>#</th>
									<th>Notification</th>
									<th>read at</th>
									<th>Date Added</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
								@foreach($notifications as $u)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>
											@include("common.notifications.".snake_case(class_basename($u->type)),["notification"=>$u])
										</td>
										<td>
											{{ $u->read_at }}
										</td>
										<td>
											{{ date("Y-m-d",strtotime($u->created_at)) }}
										</td>
										<td>
											<a onclick="deleteRecord(this)" elementId="{{$u->id}}" class="btn red" data-original title="Delete">
												<li class="fa fa-trash"> Delete</li>
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
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
@include('teachers.'.$table_name.'.js.index_js')

@endsection

