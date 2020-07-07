@extends('admin/layouts/master')

@section('title')
    Reply ticket
@endsection

@section("header_styles")
 <link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />
 <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
 
 <link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
@endsection
                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Reply ticket</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/ticket')}}">Ticket</a>
        </li>       
        <li class="active">Reply</li>
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
                                Reply ticket
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
                    @include('common.flash')
                    @include('common.errors')
					<div class="row">
						<div class="col-md-12" align="right">
							<a href="{{ url('admin/ticket/close') }}/{{$ticket->id}}" class="btn btn-md btn-warning svme">Close ticket</a>
						</div>
						<div class="clearfix"></div>
						<br>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th>User</th>
								<th>Message</th>
								<th scope="col" class="head_col">Date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{$ticket->user->username}}</td>
								<td>
									{{$ticket->titre}}
									<br>
									{{$ticket->message}}
								</td>
								<td>{{$ticket->created_at}}</td>
							</tr>
							@foreach($tickets as $item)
								<tr>
									<td>
										@if($item->user_id==0)
											Admin
										@else
											{{$ticket->user->username}}
										@endif
									</td>
									<td>
										{{$item->message}}
									</td>
									<td>{{$item->created_at}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="col-md-12">
						<form id="form_cat" action="{{ url('admin/ticket/update') }}" method="POST" class="form-horizontal form-row-seperated" novalidate>
							{{ csrf_field() }}
							<input type="hidden" value="{{$ticket->id}}" name="ticket_id" />
							<input type="hidden" value="{{$ticket->user_id}}" name="user_id" />
							<div class="form-group">
								<label class="form-label">Reply <span>*</span></label>
								<textarea class="form-control" name="message" ></textarea>
							</div>
							<input type="submit" class="btn btn-md btn-success svme" value="Save">

						</form>
					</div>
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

<script src="{{asset('assets/admin/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>
	@include("admin.ticket.js.form_js")
@endsection 


