<!-- BEGIN FORM-->
<?php
	$url="";
	$span ="";
		if($method == 'add'){
			$button = "<i class='fa fa-check'></i> add ";
			$url = url('admin/admins/create');
			$span = '<span style="color:red">*</span>';
		}else {
			$button = "<i class='fa fa-pencil'></i> edit ";
			$url = url('admin/admins/edit/'.$admin->id);
			
		}
	?>
<form method="POST" id="admins-form" action="{{$url}}" class="form-horizontal form-bordered form-label-stripped" enctype="multipart/form-data">
    <div class="form-body">
		<input type="hidden" name="methodForm" id="methodForm" value="{{$method}}"/>
	
        {{csrf_field()}}

        <div class="form-group">
            <label class="control-label col-md-3">Name <span style="color:red">*</span></label>
            <div class="col-md-6">
                <input type="text"  placeholder="Name" name="name" value="{{($method=='edit')?$admin->name:null}}" class="form-control"/>                               
            </div>
        </div>
        
		<div class="form-group">
            <label class="control-label col-md-3">UserName<span style="color:red">*</span></label>
            <div class="col-md-6">
                <input type="text"  placeholder="UserName" name="username" value="{{($method=='edit')?$admin->username:null}}" class="form-control"/>                               
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3">Email<span style="color:red">*</span></label>
            <div class="col-md-6">
                <input type="email" placeholder="Email" name="email" value="{{($method=='edit')?$admin->email:null}}" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" for="name">Image</label>
            <div class="col-md-6">
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="image"></span>
                    <a href="javascript:;" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
                <div class="col-md-9">
					<?php if($method=="edit"){?>
						@include('admin.admins._images',array('admin'=>$admin))	
					<?php }?>
				</div>
            </div>
        </div>	
        @if(Auth::guard("admins")->user()->can("admins"))
			 <div class="form-group">
	            <label class="control-label col-md-3">Role<span style="color:red">*</span></label>
	            <div class="col-md-6">
	                <select name="role_id" id="role_id"  class="form-control">
	                	<option value="">--choose--</option>
	                    @foreach($roles as $role)
							@if($role->display_name=="Superadmin")
								@if(Auth::guard("admins")->user()->can("superadmin"))	
									@if(($method=='edit'))
										<option value="{{$role->id}}" {{($admin->hasRole($role->name))?"selected":""}}>{{$role->display_name}}</option>
									@else
										<option value= "{{$role->id}}"  >{{$role->display_name}}</option>
									@endif
								@endif
							@else
								@if(($method=='edit'))
									<option value="{{$role->id}}" {{($admin->hasRole($role->name))?"selected":""}}>{{$role->display_name}}</option>
								@else
									<option value= "{{$role->id}}"  >{{$role->display_name}}</option>
								@endif
							@endif
	                    @endforeach
	                </select>
	            </div>
	        </div>
		@endif
		<div class="form-group {{$method=='add'?'display-none':''}}" >
	      	<div class="col-md-4 col-md-offset-3">
	      		<input type="checkbox" id="checkPassword" name="checkPassword" >change password
	      	</div>
	      </div>
	      
	    <div id="passwordDiv" class="display-none">
	        <div class="form-group">
	            <label class="control-label col-md-3">Password {!!$span!!} </label>
	            <div class="col-md-6">
	                <input type="password" id="password" placeholder="كلمة السر"  name="password" class="form-control"/>
	            </div>
	        </div>
	       
	        <div class="form-group">
	            <label class="control-label col-md-3">Confirm Password {!!$span!!}</label>
	            <div class="col-md-6">
	                <input type="password" id="confirm_password" placeholder="Confirm Password" name="confirm_password" class="form-control"/>
	            </div>            
	        </div>
	    </div>
             

       

        <div class="form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm">{!!$button!!}</button>
                <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('/admin/admins')}}'"><i class="fa fa-reply"></i> cancel</button>
            </div>
        </div>
    </div>

</form>

