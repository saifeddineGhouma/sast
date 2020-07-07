@extends('admin/layouts/master')

@section('title')
@if(request()->manual)
Manual
@endif
	{{ ucfirst(str_replace("-"," ",$table_name)) }}
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
    <h1>@if(request()->manual)
			Manual
		@endif {{ ucfirst(str_replace("-"," ",$table_name)) }}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li class="active">{{ ucfirst(str_replace("-"," ",$table_name)) }}</li>
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
							   @if(request()->manual)
								   Manual
							   @endif {{ ucfirst(str_replace("-"," ",$table_name)) }}
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
					@include('common.flash')
					@include('common.errors')
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
	                    <div class="row" style="margin-top: 20px;">
							<div class="btn-group">
								<button id="btn-delete" class="btn sbold danger" onclick="confirmDelete()">
									Delete Selected
								</button>
							</div>
	                    </div>
					</div>
					<form method="POST" id="delform" action="{{ url('admin/students-certificates/delete') }}">
						
	                <div id="recordsTable">
							<table class="table table-striped table-bordered" id="table1">
									<thead>
										<tr>
											
											<th style="width: 5%"> # </th>
											<th style="width: 5%"> Image</th>
											<th style="width: 5%"> QR</th>
											<th style="width: 20%">Full Name En</th>
											<th style="width: 20%">Course</th>
											@if(!request()->manual)
												<th style="width: 10%">Exam</th>
											@endif
											<th>Serial Number</th>
											@if(request()->manual)
												<th style="width: 10%">Status</th>
											@endif
											<th style="width: 10%"> Date Added </th>
											<th style="width: 5%" > Action </th>
				
										</tr>
									</thead>
									<tbody>
									    @php $i=1 @endphp
										@foreach ($StudentCertificate as $Student)
										<tr>
										    <td>
											<input type="checkbox" class="checkbox" name="delStudent[]" value="{{$Student->id}}">
										        </td>
											<td>
											   <a href="{{
											   asset('uploads/kcfinder/upload/image/'.$Student->image)
											   }}" target="_blank">
                       							Image</a> 
											    
											</td>
											<td>
											   <a href="{{
											   asset('uploads/kcfinder/upload/image/barcodes/'.$Student->serialnumber.'-code.png')
											   }}" target="_blank">
                                            Image</a> 
											    
											</td>
											
											<td>{{ $Student->student->user->full_name_en }}</td>
											<td>{{ $Student->course_name }}</td>
											@if(!request()->manual)
												<td>{{ $Student->exam_name }}</td>
											@endif
											<td>{{ $Student->serialnumber }}</td>
											@if(request()->manual)
											
											<form  action="{{ url('admin/students-certificates/changestatus') }}" method="post" class="form-horizontal form-row-seperated" >
												{{ csrf_field() }}
												<td>
												<input type="hidden" name="id" value="{{$Student->id}}" >
												<input type="hidden" name="val" value="{{$Student->active}}" >
												@if($Student->active == 1 )
												<button class="label label-sm label-success" type="submit"> active </button>
												@else
												<button class="label label-sm label-danger" type="submit"> inactif </button>
												@endif
												</td>
											</form>
											@endif
											<td>{{ $Student->date }} 
												
											</td>
											<td>
												<a  onclick="changedate({{$Student->id}},{{$Student->date}})" data-toggle="modal" data-target="#exampleModal">
													<span class="fa fa-edit" > </span>
												</a>
											</td>
											
										</tr>
										@endforeach									
										
									</tbody>
								</table>
							</form>

                	</div>
	            </div>
	         </div>
	    </div>
	</div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel">Change Certification date</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<form  action="{{ url('admin/students-certificates/changestatus') }}" method="post"  >
					{{ csrf_field() }}
					<input type="hidden" name="user" value="" id="changeusermodale">
			   		<input type="date" name="date" value="<?php echo date("Y-m-d");?>" >
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-primary">Save changes</button>
			</form>
			</div>
		  </div>
		</div>
@endsection
@section("footer_scripts")

    <script src="{{asset('assets/admin/vendors/datatables/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/datatables/pipeline.js')}}" type="text/javascript"></script>

	<script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{asset('assets/admin/vendors/countUp/countUp.js')}}"></script>

	<script src="{{asset('assets/admin/vendors/bootbox/bootbox.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
	@include('admin.students-certificates.js.index_js')
	
	<script>
			function changestatus(val,id) {
			
            $.ajax({
               type:'POST',
               url:'/students-certificates/changestatus',
               data:{val:val,id:id,'_token = <?php echo csrf_token() ?>'},
               success:function(data) {
                  $("#msg").html(data.msg);
               }
            });
        }
         
	</script>
	<script>
	    	function changedate(user,datecertif) {
			document.getElementById("changeusermodale").value= user;
		}
	</script>
	<script>
		function confirmDelete(){
			var isDelete = confirm("Do you really want to delete records?");
			if (isDelete == true) {
				$( "#delform" ).submit();
			}
           
        } 
			
			
		
			
      
            
	</script>
	
	
	
@endsection

