<!-- BEGIN FORM-->
<?php
	$url="";
	$span ="";
		if($method == 'add'){
			$button = "<i class='fa fa-check'></i> add ";
			$url = url('admin/roles/create');
			$span = '<span style="color:red">*</span>';
		}else {
			$button = "<i class='fa fa-pencil'></i> edit ";
			$url = url('admin/roles/edit/'.$role->id);
			
		}
	?>
<form method="POST" id="roles-form" action="{{$url}}" class="form-horizontal form-bordered form-label-stripped">
    <div class="form-body">
		<input type="hidden" name="methodForm" id="methodForm" value="{{$method}}"/>
	
        {{csrf_field()}}

        <div class="form-group">
            <label class="control-label col-md-3">Name<span style="color:red">*</span></label>
            <div class="col-md-6">
                <input type="text"  placeholder="Name" name="name" value="{{($method=='edit')?$role->name:null}}" class="form-control required"/>                               
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Display Name<span style="color:red">*</span></label>
            <div class="col-md-6">
                <input type="text" placeholder="Display Name" name="display_name" value="{{($method=='edit')?$role->display_name:null}}" class="form-control"/>                               
            </div>
        </div>
       
       <div class="form-group">
            <label class="control-label col-md-3">Description</label>
            <div class="col-md-6">
                <textarea placeholder="Description" name="description" class="form-control">{{($method=='edit')?$role->description:null}}</textarea>                               
            </div>
        </div>
		
		 <div class="form-group">
            <label class="control-label col-md-3">Permissions</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select" id="my_multi_select1" name="perms[]">
                	@foreach($permissions as $permission)
                    	<option value="{{$permission->id}}" {{$method=="edit"&&$role->hasPermission($permission->name)?"selected":null}}>{{$permission->name}}</option>
                    @endforeach                    
                </select>
            </div>
        </div>
                                            
        <div class="form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm">{!!$button!!}</button>
                <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('/admin/roles')}}'"><i class="fa fa-reply"></i> cancel</button>
            </div>
        </div>
    </div>

</form>

