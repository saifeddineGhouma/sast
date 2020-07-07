<!-- BEGIN FORM-->
<?php
	$url="";
	$span ="";
		if($method == 'add'){
			$button = "<i class='fa fa-check'></i> add ";
			$url = url('admin/reviews/reply/create/');
			$span = '<span style="color:red">*</span>';
		}else {
			$button = "<i class='fa fa-pencil'></i> edit ";
			$url = url('admin/reviews/reply/edit/'.$admin->id);
			
		}
	?>
<form method="POST" id="admins-form" action="{{$url}}" class="form-horizontal form-bordered form-label-stripped" enctype="multipart/form-data">
    <div class="form-body">
		<input type="hidden" name="methodForm" id="methodForm" value="{{$method}}"/>
	
        {{csrf_field()}}

        <div class="form-group">
            <label class="control-label col-md-3">Comment <span style="color:red">*</span></label>
            <div class="col-md-6">
                <input type="text"  placeholder="Comment" required name="comment" value="{{($method=='edit')?$admin->name:null}}" class="form-control"/> 
				<input type="hidden" value="<?php echo $id; ?>" name="rating_id" />
            </div>
        </div>
        
        <div class="form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm">{!!$button!!}</button>
                <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('/admin/reply')}}'"><i class="fa fa-reply"></i> cancel</button>
            </div>
        </div>
    </div>

</form>

