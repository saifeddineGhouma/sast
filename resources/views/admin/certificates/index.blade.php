@extends('admin/layouts/master')

@section('title')
	{{ ucfirst($table_name) }}
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />   

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
					@include('common.flash')
					@include('common.errors')
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
	                                <a href="{{url('admin/'.$table_name.'/create')}}" id="sample_editable_1_new" class="btn" target="_blank">
	                                	<i class="fa fa-plus"></i> Add {{ ucfirst($record_name) }}
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
									<th>image</th>
	                                <th>name ar</th>
									<th>name en</th>
	                                <th>courses</th>
	                                <th>date added</th>
	                                <th>Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
		                        @foreach($certificates as $key=>$item)
		                            <tr>
		                                <td>{{$item->id}}</td>
										<td>
											<a href="{{ asset('uploads/kcfinder/upload/image/'.$item->image) }}" target="_blank">
												<img src="{{asset('uploads/kcfinder/upload/image/'.$item->image)}}" alt="no image" width="70px"/>
											</a>
										</td>
		                                <td>
											{{$item->name_ar}}
		                                </td>
		                                <td>
											{{$item->name_ar}}
		                                </td>
		                                <td>
											@foreach($item->coursetype_variations as $coursetype_variation)
												<?php
													$type = "online";
													if($coursetype_variation->courseType->type == "presence")
														$type = "classroom";
												?>
												{{ $coursetype_variation->courseType->course->course_trans("ar")->name .'-'.
												$type }}
												@if(!$loop->last)
													,
												@endif
											@endforeach
		                                </td>
		                                <td>
		                                	{{$item->date}}
		                                </td>
		                                <td>
		                                	<a href="{{ action('Admin\certificatesController@edit', $item->id) }}" target="_blank">
	                                            <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit certificate"></i>
	                                        </a>
	                                        <a data-toggle="modal" class="deleterecord" elementId="{{$item->id}}">
	                                            <i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete certificate"></i>
	                                        </a>
											<a href="{{ action('Admin\certificatesController@getExport', $item->id) }}">
												<i class="livicon" data-name="file-export" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="export certificate"></i>
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

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>
    
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
   @include('admin.'.$table_name.'.js.index_js')


@endsection

