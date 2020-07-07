<!-- BEGIN FORM-->
<?php
	$url="";
	$span ="";
		if($method == 'add'){
			$button = "<i class='fa fa-check'></i> add ";
			$url = url('admin/students/create');
			$span = '<span style="color:red">*</span>';
		}else {
			$button = "<i class='fa fa-pencil'></i> edit ";
			$url = url('admin/students/edit/'.$student->id);
		}
	?>
<form method="POST" id="student-form" action="{{$url}}" class="form-horizontal form-bordered form-label-stripped" enctype="multipart/form-data">
    <div class="form-body">
		<input type="hidden" name="methodForm" id="methodForm" value="{{$method}}"/>
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" name="student_id" value="{{$method=='edit' ? $student->id:"0"}}">
        {{csrf_field()}}
		
		<div class="form-actions left" style="float: right;">
	        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
	            <i class="fa fa-check"></i> Save</button>
	        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('/admin/students')}}'"><i class="fa fa-reply"></i> Cancel</button>
	    </div>	
		<ul class="nav nav-tabs">
		    <li class="active">
		        <a href="#tab1" data-toggle="tab">
		           <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
		        user</a>
		    </li>
		    <li>
		        <a href="#tab2" data-toggle="tab">
		     	<i class="livicon" data-name="gift" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
		       data</a>
		    </li>
		     
		</ul>
		<div  class="tab-content mar-top">
		    <div id="tab1" class="tab-pane fade active in">										
				<div class="row">
					<div class="col-lg-12">
						<div class="panel">
							 <div class="panel-heading"></div>
							@include("admin.students.tabs._user")
						</div>
					</div>
				</div>
			</div>
			<div id="tab2" class="tab-pane fade">
	        	<div class="row">
	        		<div class="panel">
	        			<div class="panel-heading"></div>
	        			@include("admin.students.tabs._data")
					</div>
	        	</div>
	        </div>
		</div>		
    </div>
</form>

