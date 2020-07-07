@extends('admin/layouts/master')

@section('title')
Faqs
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('assets/admin/vendors/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />   
<link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Faqs</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">faqs</li>
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
		                        Faqs
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
                    <div class="alert alert-success" id="displayMessages" style="display: none;"></div>
                	<div class="table-toolbar">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <div class="btn-group">
	                                <a data-toggle="modal" href="#modal-2" id="sample_editable_1_new" class="btn add-faq">
	                                	<i class="fa fa-plus"></i> Add Faq
	                                </a>
	                            </div>
	                           
	                        </div>
	                    </div>
	                </div>
	                <div id="reloaddiv">
	                    <table class="table table-striped table-bordered" id="table1">
	                        <thead>
	                            <tr>
	                            	<th>#</th>
	                                <th>question</th>
	                                <th>answer</th>
	                               	<th>sort order</th>
	                                <th>actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($faqs as $u)
	                        	<?php
	                        		$en_question = "";
									$en_answer = "";
									if(!empty($u->faq_trans("en"))){
										$en_question = $u->faq_trans("en")->question;
										$en_answer = $u->faq_trans("en")->answer;
									}
	                        	?>
	                            <tr>
	                            	<td>{{$u->id}}</td>
	                            	<td>
	                            		{{$u->faq_trans("ar")->question}}
	                            		
	                            	</td>
	                            	<td>
	                            		{{$u->faq_trans("ar")->answer}}
	                            	</td>
	                            	<td>
	                            		{{$u->sort_order}}
	                            	</td>
	                                <td>
	                                	<a class="btnedit" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit faq"
                                            data-toggle="modal" href="#modal-2" data-id="{{$u->id}}" data-ar_question="{{$u->faq_trans('ar')->question}}" data-en_question="{{$en_question}}"
                                            data-ar_answer="{{$u->faq_trans('ar')->answer}}" data-en_answer="{{$en_answer}}" data-sort_order="{{$u->sort_order}}" >
                                            edit
                                        </a>
                                        <a data-toggle="modal" class="deletefaq" elementId="{{$u->id}}" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete faq" style="color: red;">
                                            X
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
   
@include('admin.faq._form')

@endsection
@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>
    
	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>
@include('admin.faq.js.index_js')
@include('admin.faq.js.form_js')
@endsection



