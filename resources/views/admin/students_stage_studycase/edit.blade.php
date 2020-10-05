@extends('admin/layouts/master')


@section('title')
{{ ucfirst(str_replace("-"," ",$table_name)) }}
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
    <h1>{{ ucfirst(str_replace("-"," ",$table_name)) }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">{{ ucfirst(str_replace("-"," ",$table_name)) }}</li>
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
							   Edit Stage
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                	

					<div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
                    <form id="form1" action="{{route('students.stage.update',$stage->id)}}" method="POST" class="form-horizontal form-row-seperated" novalidate>
                        {{ csrf_field() }}
                       

                        <div class="panel">
                            {{-- cas d'exam pratique  --}}
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label">Student Full Name</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="student_name" class="form-control" value="{{ $stage->user->full_name_ar }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Student UserName</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="student_username" class="form-control" value="{{ $stage->user->username }}" readonly>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-md-2 control-label">Course Name</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="course_name" class="form-control" value="{{ $stage->course->course_trans("ar")->name or  $study_case->course_name}}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">manager message</label>
                                <div class="col-md-10">
                                    <textarea cols="60"  name="manager_message"  class="form-control">{{$stage->manager_message}} </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">website message</label>
                                <div class="col-md-10">
                                    <textarea cols="60"  name="website_message"  class="form-control">{{$stage->website_message}} </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">user message</label>
                                <div class="col-md-10">
                                    <textarea cols="60"  name="user_message"  class="form-control">{{$stage->user_message}} </textarea>
                                </div>
                            </div>

                       

                          

                            <div class="form-group">
                                <label class="col-sm-3 control-label">result</label>
                                <div class="col-sm-9">
                                    <div class="radio-list">
                                        <label>
                                            <input type="radio" name="valider" value="1"  {{($stage->valider)?"checked":null}}/>
                                            Successfull  </label>
                                        <label>
                                            <input type="radio" name="valider" value="0" {{(!$stage->valider)?"checked":null}} />
                                            Failed </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions" >
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="Saving..." >
                                        <i class="fa fa-check"></i> save</button>
                                    <button type="button" class="btn btn-secondary-outline" onclick="js:window.location='{{url('/admin/students-exams')}}'"><i class="fa fa-reply"></i> cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
	<script src="{{asset('assets/admin/vendors/datatables/pipeline.js')}}" type="text/javascript"></script>

	<script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>

	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>

@endsection