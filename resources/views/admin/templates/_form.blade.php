 
 <?php
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('admin/templates/create');
		$btn="add";
	}else {
		$url = url('admin/templates/edit/'.$template->id);
		$btn="update";
	}
	$parmlist = array(
		'shop_name'=>'{shop_name}',
		'shop_link'=>'{shop_link}',
	);
?>
 <div class="portlet-body"> 
 	  						    
	<form method="post" action="{{$url}}"  id="form_template" name="form_template" class="form-horizontal form-row-seperated">
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" value="{{$method=='edit' ? $template->id:"0"}}">
    	{{csrf_field()}}
		
		<div class="form-body">
			 <div class="form-group">
		          <label class="control-label col-md-2">name<span style="color:red;">*</span></label>
		          <div class="col-md-6">
		          	<input  type="text" value="{{$method=='edit'?$template->name:''}}" name="name" class="form-control required"> 	
		          </div>
		      </div>
				<div class="form-group">
					<label class="col-md-2 control-label">content en
						<ul style="width: 0">
						<?php foreach ($parmlist as $key => $value) {?>
							<li>
								<a class="parm" href="javascript:void(0);" rel="<?php echo $value; ?>"> <?php echo $value; ?> </a>
							</li>
						<?php } ?>
					</ul>
					</label>
					<div class="col-md-10">
						<textarea class="form-control" id="content_en"  name="content_en" rows="4">{{$method=='edit'?$template->content_en:""}}</textarea>
						<input type="hidden" value=""/>						
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">content ar
						<ul style="width: 0">
						<?php foreach ($parmlist as $key => $value) {?>
							<li>
								<a class="parm_ar" href="javascript:void(0);" rel="<?php echo $value; ?>"> <?php echo $value; ?> </a>
							</li>
						<?php } ?>
					</ul>
					</label>
					<div class="col-md-10">
						<textarea class="form-control" id="content_ar"  name="content_ar" rows="4">{{$method=='edit'?$template->content_ar:""}}</textarea>
						<input type="hidden" value=""/>						
					</div>
				</div>
				
			
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
	            			<i class="fa fa-check"></i> Save</button>
			            <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('/admin/templates')}}'"><i class="fa fa-reply"></i> cancel</button>
		            </div>
	            </div>
	        </div>  
	
        </div>            
		
                   
     </form>
    </div>