@extends('admin/layouts/master')

@section('title')
	pages
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
    <h1>pages</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				dashboard
            </a>
        </li>
        <li class="active">pages</li>
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
							    pages
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
	                    <div class="row" style="margin-top:10px;">
	                        <div class="col-md-6">
								<a href="{{url('admin/pages/create')}}" id="sample_editable_1_new" class="btn">
									<i class="fa fa-plus"></i> Add Page
								</a>
	                        </div>
	                    </div>
	                </div>
	                <div id="reloaddiv">
	                    <table class="table table-striped table-bordered" id="table1">
	                        <thead>
	                            <tr>
	                            	<th>#</th>
	                                <th>title</th>
	                                <th>slug</th>
	                                <th>active</th>
	                                <th>date added</th>
	                                <th>actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	 @foreach($pages as $u)
									<tr>
										<td>
											 {{ $u->id }}
										</td>
										<td>
											 {{ $u->page_trans(App("lang"))->title}}
										</td>
										<td>
											 {{ $u->page_trans(App("lang"))->slug}}
										</td>															
										<td>
											  {!! $u->getStatus($u->active,$u->id,'active') !!}
										</td>
										<td>
											{{date("Y-m-d",strtotime($u->created_at))}}
										</td>										
										<td>
											<a href="{{url(App('urlLang').'admin/pages/edit/'.$u->id)}}">
	                                            <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit page"></i>
	                                        </a>
	                                        <a data-toggle="modal" class="deletpage" elementId="{{$u->id}}">
	                                            <i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete page"></i>
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
@include('admin.pages.js.index_js')

@endsection

