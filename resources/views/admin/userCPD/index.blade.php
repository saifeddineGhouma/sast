@extends('admin/layouts/master')

@section('title')
Stage
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
    <h1>{{ ucfirst('CPD') }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">{{ ucfirst('CPD') }}</li>
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
							   {{ ucfirst('CPD') }}
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
	                <div id="reloaddiv">
                        {{-- <div id="childList"></div> --}}
                        <table class="table table-striped table-bordered" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>user</th>
                                    <th>course </th>
                                    <th>Certificate</th>
                                    <th>Created at</th>
                                    <th class="text-center"> status </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userverify as $userver)
                                    <tr> 
                                        <td>{{ $userver->id }}</td>
                     
                                        <td>
                                            {{ $userver->user['full_name_en']}}
                                          </td>
                                        <td>
                                            {{ $userver->course->course_trans("ar")->name}}
                                        </td> 
                                        <td>
                                            <a href = "{{url(App('urlLang').'/admin/view_user_cpd/' . $userver->id)}}">    View
                                        </td>
                                        <td> 
                                          
                                            {{ date("Y-m-d",strtotime($userver->created_at)) }}
                                        </td>
                                        <td> 
                                            <form method="POST"> 
                                           @if($userver->verify == 1)
                                           <span class="label label-sm label-success"> <a href="{{url('/admin/update_user_cpd/0/'. $userver->id)}}">  Valider </a> </span>
                                           @else
                                           <span class="label label-sm label-danger"> <a href="{{url('/admin/update_user_cpd/1/'. $userver->id)}}">  Refuser </a> </span>
                                           @endif
                                            </form>
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
	<script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>

	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>



@endsection
 
