@extends('teachers/layouts/master')

@section('title')
Courses
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
    <h1>Courses</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/teachers')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Courses</li>
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
		                        Courses
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
	                    <div class="row" style="margin-top: 10px;">

	                    </div>
	                </div>
	                <div id="reloaddiv">
	                    <table class="table table-striped table-bordered" id="table1">
	                        <thead>
	                            <tr>
	                            	<th>#</th>
									<th>thumb</th>
									<th>name</th>
									<th>type</th>
									<th>period</th>
									<th>status</th>
	                                <th>Num Students</th>
	                                <th>Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($courseTypeVariations as $u)
									<?php
										$course = $u->courseType->course;
									?>
	                            <tr>
	                            	<td>{{ $course->id }}</td>
	                                <td>
										@if(!empty($course->image))
											<img src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" style="width:60px;"/>
										@else
											no thumbnail
										@endif
									</td>
	                                <td>
										{{ $course->course_trans("ar")->name}}
									</td>
									<td>
										{{ $u->courseType->type }}
									</td>
									<td>
										{{ $course->period }}
									</td>
									<td>
										{!! $course->getStatus($course->active,$course->id) !!}
									</td>
	                                <td>
										{{ $u->students()->count() }}
									</td>
	                                <td>
										<a href="{{url('/teachers/courses/view/'.$u->id)}}">
											<i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view"></i>
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
@include('teachers.courses.js.index_js')

@endsection


