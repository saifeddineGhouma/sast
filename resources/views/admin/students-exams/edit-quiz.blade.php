@extends('admin/layouts/master')

@section('title')
	Edit {{ $title }}
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
    <h1>Edit {{ $title }}: {{ $exam_name }}-{{$studentQuiz->student->user->full_name_ar}}</h1>
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
                               Edit {{ $title }}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
                    <form id="form1" action="{{ url('admin/'.$table_name.'/'.$studentQuiz->id) }}" method="POST" class="form-horizontal form-row-seperated" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="type" value="{{ request()->type }}"/>
                        <div class="form-actions left" style="float: right;">
                            <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="Saving..." >
                                <i class="fa fa-check"></i> save</button>
                            <button type="button" class="btn btn-secondary-outline" onclick="js:window.location='{{url('/admin/students-exams')}}'"><i class="fa fa-reply"></i> Cancel</button>
                        </div>

                        <div class="tabbable-bordered">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab"> {{ $title }} </a>
                                </li>
                                <li>
                                    <a href="#tab_2" data-toggle="tab"> Answers
                                        <span class="badge badge-success"> {{$studentQuiz->answers->count()}} </span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel">
                                                <div class="panel-heading">

                                                </div>
                                                <div class="panel-body">
                                                    @include("admin.".$table_name.".tabs._quiz")
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="panel">
                                            <div class="panel-heading">

                                            </div>
                                            <div class="panel-body">
                                                @include("admin.".$table_name.".tabs._answers")
                                            </div>
                                        </div>
                                    </div>
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


