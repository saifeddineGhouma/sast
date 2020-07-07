@extends('admin/layouts/master')

@section('title')
    Export {{ $record_name }} 
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />
 <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>

 <link href="{{asset('assets/admin/vendors/bootstrap-multiselect/bootstrap-multiselect.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
@endsection
                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Export {{ $record_name }} {{ $certificate->name_ar }}</h1>
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
        <li class="active">export</li>
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
                                Export {{ $record_name }} {{ $certificate->name_ar }}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
                    <form id="form1" action="{{ url('admin/'.$table_name.'/export/'.$certificate->id) }}" method="POST" class="form-horizontal form-row-seperated" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-md-2">Test</label>
                            <div class="col-md-10">
                                <input type="checkbox" name="test" id="test" class="make-switch" data-on-text="Yes" data-off-text="No">
                            </div>
                        </div>
                        <div id="live">
                            <div class="form-group">
                                <label class="col-md-2 control-label">courses</label>
                                <div class="col-md-10">
                                    <select  name="coursetypevariation_id" id="coursetypevariation_id" class="form-control">
                                        <option value=""></option>
                                        @foreach($courseTypeVariations as $courseTypeVariation)
                                            <option value="{{$courseTypeVariation->id}}">
                                                {{ $courseTypeVariation->courseType->course->course_trans("ar")->name }}-
                                                {{ $courseTypeVariation->courseType->type }}-
                                                {{ $courseTypeVariation->teacher->user->full_name_ar }}
                                                <span>{{ $courseTypeVariation->date_from ." - ".$courseTypeVariation->date_to }}</span>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Students</label>
                                <div class="col-md-10">

                                    <select  name="student_ids[]" id="student_ids" class="form-control" multiple>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions" >
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="Saving..." >
                                        <i class="fa fa-check"></i> Export</button>
                                    <button type="button" class="btn btn-secondary-outline" onclick="js:window.location='{{url('/admin/certificates')}}'"><i class="fa fa-reply"></i> Cancel</button>
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
    <script src="{{asset('assets/admin/vendors/bootstrap-multiselect/bootstrap-multiselect.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>

<script src="{{asset('assets/admin/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>
	@include("admin.".$table_name.".js.export_js")
@endsection 


