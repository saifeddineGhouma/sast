  <?php
	$url="";
	$btn = "";
	
	if($method == 'add'){
		$url = url('admin/newsletter/create');
		$btn="send";
	}else {
		$url = url('admin/newsletter/edit/'.$newsletter->id);
		$btn="send";
	}
	$parmlist = array(
		'username'=>'{username}'
	);
	$groupsarr = array("جميع مشتركي القائمة البريدية","جميع العملاء");
	
?>
 <div class="portlet-body "> 
 	  						    
	<form method="post" action="{{$url}}"  id="form_newsletter" name="form_newsletter" class="form-horizontal form-row-seperated">
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" value="{{$method=='edit' ? $newsletter->id:"1"}}">
    	{{csrf_field()}}
		
		<div class="form-body">
			<div class="form-group">
		          <label class="control-label col-md-2">template</label>
		          <div class="col-md-8">
		          	<select class="form-control" name="emailtemplate" id="emailtemplate">
		          		<option value=""></option>
		          		@foreach($emailTemplates as $emailTemplate)
		          			<option value="{{$emailTemplate->id}}">{{$emailTemplate->subject}}</option>
		          		@endforeach
		          	</select>
		          </div>
		          <div class="col-md-1">
		          	
		          </div>
		    </div>
			 <div class="form-group">
		          <label class="control-label col-md-2">subject<span style="color:red;">*</span></label>
		          <div class="col-md-6">
		          	<input  type="text" value="{{$method=='edit'?$newsletter->subject:''}}" name="subject" class="form-control required"> 	
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
						<textarea class="form-control" id="body"  name="body" rows="4">{{$method=='edit'?$newsletter->body:""}}</textarea>
						<input type="hidden" value=""/>
						
					</div>
				</div>
				
			<div class="form-group">
		          <label class="control-label col-md-2">to</label>
		          <div class="col-md-8">
		          	<select class="form-control" name="sendto" id="sendto">
		          		@foreach($groupsarr as $key=>$group)
		          			@if($method == "edit")
		          				<option value="{{$key}}" {{$newsletter->sendto==$key?"selected":""}}>{{$group}}</option>
		          			@else
		          				<option value="{{$key}}">{{$group}}</option>
		          			@endif
		          		@endforeach
		          	</select>
		          </div>
		    </div>

		    
			<div class="form-group">
		          <label class="control-label col-md-2">other email</label>
		          <div class="col-md-8">
		          	<textarea cols="60" class="form-control" name="othermail" placeholder="more than one email separated with ,">{{$method=='edit'?$newsletter->otheremail:''}}</textarea>
		          </div>
		    </div>
		    
		    <div class="form-group">
				<label class="control-label col-md-2">send by date</label>
				<div class="col-md-8">
					<input type="checkbox" class="form-control" name="checkbydate" id="checkbydate" {{($method=='edit' && $newsletter->checkbydate)?"checked":""}}>			
				</div>
			</div>
				
				
			<div id="sendByDate" >
				<div class="form-group">
                    <label class="control-label col-md-2">starting date</label>
                    <div class="col-md-8">
                    	<input class="form-control date-picker" data-date-format="yyyy-m-d" value="{{$method=='edit'?$newsletter->start_date:''}}" type="text" name="start_date" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">ending date</label>
                    <div class="col-md-8">
                    	<input class="form-control date-picker" data-date-format="yyyy-m-d" type="text" value="{{$method=='edit'?$newsletter->end_date:''}}" name="end_date" />
                    </div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-2">repeated every   </label>
					<?php 
						$repeated = 0;
						if($method=="edit")
							$repeated = intval($newsletter->repeated);
					?>
					<input type="hidden" id="repeated" value="{{$repeated}}">
					<div class="col-md-8">
						<input id="touchspin_2" value="{{$repeated}}" type="text" name="repeated"  class="form-control" >
					</div>
				</div>
			</div>
		    <div class="form-group">
				<label class="control-label col-md-2">active</label>
				<div class="col-md-6">
					<input type="checkbox" name="active" class="make-switch" {{ (isset($newsletter->active) && $newsletter->active)?'checked':'' }} data-on-text="Yes" data-off-text="No">															
				</div>
			</div>
			<div class="form-actions" >
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
			            <button type="submit" id="SubmiteButton" class="btn btn-success demo-loading-btn" data-loading-text="saving..." >
	                		<i class="fa fa-check"></i> {{$btn}}</button>
			            <button type="button" class="btn btn-secondary-outline" onclick="js:window.location='{{url('/admin/newsletter')}}'"><i class="fa fa-reply"></i> cancel</button>
		            </div>
	            </div>
	        </div>  
	
        </div>            
		
                   
     </form>
    </div>