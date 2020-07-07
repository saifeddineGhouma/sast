<!-- BEGIN FORM-->
<?php
	$url="";
	
		if($method == 'add'){
			$button = "<i class='fa fa-check'></i> add ";
			$url = url('admin/coupons/create');
		}else {
			$button = "<i class='fa fa-pencil'></i> edit";
			$url = url('admin/coupons/edit/'.$coupon->id);
			
		}
	?>
<form method="POST" id="form_coupon" action="{{$url}}" class="form-horizontal form-bordered form-label-stripped">
    <div class="form-body">
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" value="{{$method=='edit' ? $coupon->id:"0"}}">
		
        {{csrf_field()}}
		
		<div class="form-group">
    		<label class="col-md-3 control-label">Coupon Number  <span style="color:red;">*</span></label>
    		<div class="col-md-6">
    			<input type="text" name="coupon_number" value="{{$method=='edit'?$coupon->coupon_number:''}}" class="form-control">
    			<span class="help-inline">can be string</span>
    		</div>
    	</div> 
		
		<div class="form-group">
		    <label class="col-md-3 control-label">discount</label>
			<div class="col-md-6">	
		       <input  type="text"  name="discount" class="form-control touchspin_1" value="{{($method=='edit')?$coupon->discount:0}}">
		    </div>
		</div> 
		
		<div class="form-group">
		    <label class="col-md-3 control-label">total greater than </label>
			<div class="col-md-6">	
		       <input  type="text"  name="ordertotal_greater" class="form-control touchspin_1" value="{{($method=='edit')?$coupon->ordertotal_greater:0}}">
		    </div>
		</div> 
		
		<div class="form-group">
		    <label class="col-md-3 control-label">number of limits</label>
			<div class="col-md-6">	
		       <input  type="text"  name="limits" class="form-control touchspin_2" value="{{($method=='edit')?$coupon->limits:0}}">
		       <span class="help-inline">if zero no limit</span>
		    </div>
		</div> 
		
		<div class="form-group">
		    <label class="col-md-3 control-label">date from</label>
			<div class="col-md-6">	
		       <div class="input-group input-large date-picker input-daterange"  data-date-format="yyyy-mm-dd">
			        <input type="text"  class="form-control" name="date_from" value="{{$method=='edit'?$coupon->date_from:''}}">
			        <span class="input-group-addon"> {{trans('home.to')}} </span>
			        <input type="text" class="form-control" name="date_to" value="{{$method=='edit'?$coupon->date_to:''}}"> 
			    </div>
		    </div>
		</div>

	      <?php
	      	$nonOrderUsers=array();
			if($method=="edit")
	      		$nonOrderUsers = $coupon->users()->pluck("users.username")->all();
	      ?>
		  <div class="form-group">
    		<label class="col-md-3 control-label">Clients </label>
    		<div class="col-md-6">
    			<input type="text" data-role="tagsinput" name="usernames" value="{{$method=='edit'?implode(',', $nonOrderUsers):''}}" class="form-control">
    			<span class="help-inline">insert usernames separated ,
					<br/>if empty coupon will be valid for all users
				</span>
    		</div>
    	 </div>  

        <div class="form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm">{!!$button!!}</button>
                <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/coupons')}}'"><i class="fa fa-reply"></i>Cancel</button>
            </div>
        </div>
    </div>

</form>

