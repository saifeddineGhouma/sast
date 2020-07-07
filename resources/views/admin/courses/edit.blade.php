@extends('admin/layouts/master')

@section('title')
	Edit {{ $record_name }}
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
    <h1>Edit {{ $record_name }} {{$course_trans_ar->name}}</h1>
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
		                        Edit {{ $record_name }} {{$course_trans_ar->name}}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
                    <form id="form1" action="{{ url('admin/'.$table_name.'/'.$course->id) }}" method="POST" class="form-horizontal form-row-seperated" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">

                        @include('admin.'.$table_name.'._form',array("method"=>"edit"))

                    </form>
                </div>
           </div>
	    </div>
	</div>
</section>


<div class="modal fade" id="modal-2">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="myModalLabel1">merge courses</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" name="form_merge" method="post" action="{{ url('admin/courses/merge') }}">
                    {{csrf_field()}}
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    <div class="modal-body">
                        <div class="alert alert-warning">تحذير! سوف يتم نقل جميع السجلات المرتبطة بهذه الدورات إلى هذه الدورة وسيتم حذف هذه الدورات
                        </div>
                        <div class="form-group">
                            <label class="control-label bold">course</label>
                            <select name="course_ids[]" class="form-control select2" multiple>
                                <option value="0">choose...</option>
                                @foreach($courses as $course1)
                                    <option value="{{$course1->id}}">{{$course1->course_trans("ar")->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="saving...">save</button>
                        <button aria-hidden="true" data-dismiss="modal" class="btn">cancel </button>
                    </div>
                </form >
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-3">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="myModalLabel1">import users to {{$course_trans_ar->name}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" name="form_import" method="post" action="{{ url('admin/courses/import') }}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    <div class="modal-body">
                        <div class="alert alert-warning">سوف يتم إستيراد بيانات المستخدمين من ملف الاكسل وعمل طلبات لهم بهذه الدورة بحالة مدفوعة
                        </div>
                        <div class="form-group">
                            <label class="control-label bold">crouse</label>
                            <select name="coursetypeVariation_ids[]" class="form-control select2" multiple>
                                <option value="0">choose...</option>
                                @foreach($course->courseTypes as $courseType)
                                    @foreach($courseType->couseType_variations as $courseTypeVariation)
                                        <option value="{{ $courseTypeVariation->id}}">{{ $courseType->type."-".$courseTypeVariation->teacher->user->{'full_name_'.App("lang")} }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label bold">excel file</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="saving...">save</button>
                        <button aria-hidden="true" data-dismiss="modal" class="btn">cancel </button>
                    </div>
                </form >
            </div>
        </div>
    </div>
</div>

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


