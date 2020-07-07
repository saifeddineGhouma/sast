@extends('admin/layouts/master')
@section("page-title")
Edit User
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
  
   <link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
 <link rel="stylesheet" href="{{asset('assets/front/vendors/build/css/intlTelInput.css')}}">
@endsection


                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Edit User {{$user->username}}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/users')}}">users</a>
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
		                        Edit User {{$user->username}}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
	                @include("admin.users._form",array("method"=>"edit"))
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
                <h3 id="myModalLabel1">merge users</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" name="form_merge" method="post" action="{{ url('admin/users/merge') }}">
                    {{csrf_field()}}
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="modal-body">
                        <div class="alert alert-warning">تحذير! سوف يتم نقل جميع السجلات المرتبطة بهؤلاء المستخدمين إلى هذا المستخدم وسيتم حذف هؤلاء المستخدمين
                        </div>
                        <div class="form-group">
                            <label class="control-label bold">user</label>
                            <select name="user_ids[]" class="form-control select2" multiple>
                                <option value="0">choose...</option>
                                @foreach($mergeUsers as $mergeUser)
                                    <option value="{{$mergeUser->id}}">{{$mergeUser->username}}</option>
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

@endsection  
  
@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	@include("admin.users.js.form_js")
@endsection
