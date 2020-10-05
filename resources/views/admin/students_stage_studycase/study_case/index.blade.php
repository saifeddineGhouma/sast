













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
							   {{ ucfirst(str_replace("-"," ",$table_name)) }}
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
						<form   action="{{route('students.studycase')}}" method="get">
							<div class="row">
								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label class="control-label bold">Student</label>
										<select name="student_id" class="form-control select2">
											<option value="0"></option>
											@foreach($students as $student)
												<option value="{{$student->id}}">{{$student->user->full_name_en}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label class="control-label bold">Course</label>
										<select  name="course_id" class="form-control select2">
											<option value="0"></option>
                                            @foreach($courses as $course)
												<option value="{{$course->id}}">{{$course->course_trans("ar")->name}}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label class="control-label bold">Type</label>
										<select  name="types" class="form-control" id="stageOrstudycase"  onchange="location = this.value;">
											<option>selected Type </option>
											<option value="{{route('students.stage')}}" {{(\Request::route()->getName()=='students.stage')?'selected':''}}>Stage</option>
											<option value="{{route('students.studycase')}}" {{(\Request::route()->getName()=='students.studycase')?'selected':''}}>Study Case</option>
										</select>

								      
									</div>
								</div>
							</div>
							<div class="row">
								
								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label class="control-label bold">Date Added</label>
										<input class="form-control date-picker" size="16" type="text" name="created_at" />
									</div>
								</div>
								<div class="col-md-4">
									<button type="submit" name='search'id="filterBtn" class="btn green demo-loading-btn col-md-6" style="margin-top: 25px;" data-loading-text="<li class='fa fa-search'></li> Searching...">
										<li class="fa fa-search"></li> Search 
									</button>
								</div>
							</div>
						</form>

					</div>




				<div id="reloaddiv" >
						<table class="table table-striped table-bordered" id="table1">
							<thead>
							<tr>
								<th>Username</th>
								<th>Email</th>
								<th>Course </th>
								<th>sujet</th>
								<th>Fichie Pdf</th>
								<th>Status</th>
								<th class="text-center"> Date added </th>
								<th > Actions </th>
							</tr>
							</thead>
							<tbody>
								@foreach($study_cases as $study_case)
								<tr>
									<td>{{$study_case->student->user->full_name_ar}}</td>
									<td>{{$study_case->student->user->email}}</td>
									<td>{{$study_case->course->course_trans('ar')->name}}</td>
									<td>
										{{$study_case->sujet->description}}

										</td>
										<td>
											 
											

										
										<a href="{{asset('uploads/kcfinder/upload/image/studyCase/'.$study_case->document)}}" target="_blank">
											
											Document  

										</a>
										

										</td>
								
								
									<td> 

										
										{{($study_case->successful==1) ? 'success':'Refus'}}
										

									</td>
										<td>{{\Carbon\Carbon::parse($study_case->created_at)->format('m-d-Y')}}</td>
									<td>
										<a href="{{route('students.studycase.edit',$study_case->id)}}">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit student exam"></i>
					</a>
									</td>

								</tr>

								@endforeach


							</tbody>
						</table>
						{{ $study_cases->links() }}
                	</div>
	         </div>
	    </div>
	</div>
</section>

<div class="modal fade" id="modal_stage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Valid stage </h5>
        <p> vailid = <span class="label_stage"></span></p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_valid">Save changes</button>
      </div>
    </div>
  </div>
</div>

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

	<script type="text/javascript">
	    $('.select2').select2();
	</script>

@endsection














































