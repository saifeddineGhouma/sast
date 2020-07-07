@extends('admin/layouts/master')

@section('title')
	Edit Video Exam
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />
 <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>

 <link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">

 <link href="{{asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Edit Video Exam: {{ $exam_name }}-{{$studentVideo->student->user->full_name_ar}}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a> 
        </li>
        <li>
            <a href="{{url('/admin/'.$table_name)}}">{{ $table_name }}</a>
        </li>       
        <li class="active">edit</li>
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
                               Edit Video Exam
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
                    <form id="form1" action="{{ url('admin/'.$table_name.'/'.$studentVideo->id) }}" method="POST" class="form-horizontal form-row-seperated" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="type" value="video"/>

                        <div class="panel">
                            {{-- cas d'exam pratique  --}}
                            @if(in_array($studentVideo->course->id, [496, 502]))
                            <div class="form-group">
                                <label class="col-md-2 control-label">Cas d'examen pratique</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="student_name" class="form-control" value="{{ $casExamPratique->name }}" readonly>
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-2 control-label">Student Full Name</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="student_name" class="form-control" value="{{ $studentVideo->student->user->full_name_ar }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Student UserName</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="student_username" class="form-control" value="{{ $studentVideo->student->user->username }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Video Exam Name</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="video_exam_name" class="form-control" value="{{ $exam_name }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Course Name</label>
                                <div class="col-md-10">
                                    <input  type="text"  name="course_name" class="form-control" value="{{ $studentVideo->course->course_trans("ar")->name or  $studentVideo->course_name}}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">manager message</label>
                                <div class="col-md-10">
                                    <textarea cols="60"  name="manager_message"  class="form-control">{{$studentVideo->manager_message}} </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">website message</label>
                                <div class="col-md-10">
                                    <textarea cols="60"  name="website_message"  class="form-control">{{$studentVideo->website_message}} </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">user message</label>
                                <div class="col-md-10">
                                    <textarea cols="60"  name="user_message"  class="form-control">{{$studentVideo->user_message}} </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Video</label>
                                <div class="col-md-10">
                                    {!! \App\VideoExam::showVideo($studentVideo->video) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control">
                                        @foreach($statusData as $key=>$status)
                                            <option value="{{$key}}" {{ $studentVideo->status == $key?"selected":null }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">result</label>
                                <div class="col-sm-9">
                                    <div class="radio-list">
                                        <label>
                                            <input type="radio" name="successfull" value="1"  {{($studentVideo->successfull)?"checked":null}}/>
                                            Successfull  </label>
                                        <label>
                                            <input type="radio" name="successfull" value="0" {{(!$studentVideo->successfull)?"checked":null}} />
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
</section>  


@endsection
@section("footer_scripts")
    <script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>

    <script src="{{asset('assets/admin/vendors/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>
    @include("admin.".$table_name.".js.form_js")
@endsection 


