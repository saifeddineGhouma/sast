@extends('admin/layouts/master')

@section('title')
	Historic
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
		<ol class="breadcrumb">
			<li>
				<a href="{{url('/admin')}}">
					<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
					dashboard
				</a>
			</li>
		</ol>
	</section>
	<!--section ends-->

<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary filterable portlet box">
				<div class="panel-heading clearfix">
					<div class="panel-title pull-left">
						Historic
					</div>
				</div>

				<div class="panel-body">
					

					<div class="table-toolbar">
						<div class="row" style="margin-bottom: 20px;">
						</div>
					</div>
						<div id="reloaddiv">
							<table class="table table-striped table-bordered" id="table1">
								<thead>
								<tr>
									<th>#</th>
									<th>User</th>
									<th>Notification</th>
									<th>Date Added</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody>
								@foreach($historiques as $u)
									<tr>
										<td>{{ $u->id }}</td>
										<td>
											<?php
												$adminnn = \DB::table('admins')->where( 'id', '=', $u->admin_id)->get();
												foreach ($adminnn as $adminnns) {
													echo $adminnns->name;
												}
											?>
										</td>
										<td>
											{{ $u->description }}
										</td>
										<td>
											{{ $u->entree }}
										</td>
										<td>
											<a data-toggle="modal" class="deletehistory" elementId="{{$u->id}}" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete Historic" style="color: red;">
												<li class="fa fa-trash"></li>
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
	@include('admin.historiques.js.index_js')

@endsection

