  <?php
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('admin/users/create');
		$btn="add";
	}else {
		$url = url('admin/users/edit/'.$user->id);
		$btn="edit";
	}
	
	
?>

 <div class="portlet-body form"> 
 			    
	<form method="post" action="{{$url}}" id="form_user" name="form_user" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-body">
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" name="id" value="{{$method=='edit' ? $user->id:"0"}}">
		
    	{{csrf_field()}}
    	@if($method=="edit")
	    	<a href="{{url('admin/users/view/'.$user->id)}}" style="float:right;">view user</a>
    	@endif
    	          
		  	@include("admin.users._form_fields")
	      
	         <div class="form-actions" >
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
			            <button type="submit" class="btn btn-success demo-loading-btn" data-loading-text="Saving..." >
			                <i class="fa fa-check"></i> {{$btn}}</button>
			            <button type="button" class="btn btn-secondary-outline" onclick="js:window.location='{{url('/admin/users')}}'"><i class="fa fa-reply"></i> الغاء</button>
						@if($method=="edit")
							<a data-toggle="modal" href="#modal-2" class="merge">
								merge
							</a>
						@endif
		            </div>
	            </div>
	        </div>  
        </div>        
     </form>
</div>