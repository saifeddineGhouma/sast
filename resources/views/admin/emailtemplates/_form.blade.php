 
 <?php
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('admin/emailtemplates/create');
		$btn="add";
	}else {
		$url = url('admin/emailtemplates/edit/'.$emailTemplate->id);
		$btn="update";
	}
	$parmlist = array(
		'username'=>'{username}'
	);
?>
 <div class="portlet-body"> 
 	  						    
	<form method="post" action="{{$url}}"  id="form_emailtemplate" name="form_emailtemplate" class="form-horizontal form-row-seperated">
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" value="{{$method=='edit' ? $emailTemplate->id:"0"}}">
    	{{csrf_field()}}
		
		<div class="form-body">
			 <div class="form-group">
		          <label class="control-label col-md-2">subject<span style="color:red;">*</span></label>
		          <div class="col-md-6">
		          	<input  type="text" value="{{$method=='edit'?$emailTemplate->subject:''}}" name="subject" class="form-control required"> 	
		          </div>
		      </div>
				<div class="form-group">
					<label class="col-md-2 control-label">message
						<ul style="width: 0">
						<?php foreach ($parmlist as $key => $value) {?>
							<li>
								<a class="parm" href="javascript:void(0);" rel="<?php echo $value; ?>"> <?php echo $value; ?> </a>
							</li>
						<?php } ?>
					</ul>
					</label>
					<div class="col-md-10">
						<textarea class="form-control" id="body"  name="body" rows="4">{{$method=='edit'?$emailTemplate->body:""}}</textarea>
						<input type="hidden" value=""/>
						
					</div>
				</div>
			<div class="form-group">
		          <label class="control-label col-md-2">send test email</label>
		          <div class="col-md-8">
		          	<input  type="text"  id="testmail" class="form-control1" style="width: 70%;"> 
		          	 <button type="button" class="btn btn-secondary-outline demo-loading-btn" data-loading-text="sending..." id="send">send</button>	
		          	 <div id="messageStatus" style="display: none"></div>
		          </div>
		    </div>
		    <div class="form-group">
				<label class="control-label col-md-2">active</label>
				<div class="col-md-6">
					<input type="checkbox" name="active" class="make-switch" {{ (isset($emailTemplate->active) && $emailTemplate->active)?'checked':'' }} data-on-text="Yes" data-off-text="No">															
				</div>
			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						
			            <button type="submit" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving..." >
	                		<i class="fa fa-check"></i> {{$btn}}</button>
			            <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('/admin/emailtemplates')}}'"><i class="fa fa-reply"></i> cancel</button>
		            </div>
	            </div>
	        </div>  
	
        </div>            
		
                   
     </form>
    </div>