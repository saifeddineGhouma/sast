@extends('admin/layouts/master')

@section('title')
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
    <h1>SEO</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">SEO</li>
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
							   SEO
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
	                    <table class="table table-striped table-bordered" id="table1">
	                        <thead>
	                            <tr>
	                            	<th>#</th>
	                                <th>Page</th>
	                                <th>Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
		                        @foreach($seo as $item)
		                            <tr>
		                                <td>{{$item->id}}</td>
		                                <td>
											{{$item->page}}
		                                </td>
		                                <td>
		                                	<a href="{{ action('Admin\seoController@edit', $item->id) }}">
	                                            <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit category"></i>
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

@endsection

