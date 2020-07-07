<div class="form-body">
	<div class="row">
		<div class="form-group">
			<label class="control-label col-md-3">phone number</label>
			<div class="col-md-9">
				<input  type="text" name="phone" id="phone" class="form-control" value="{{$setting->phone}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">mobile number</label>
			<div class="col-md-9">
				<input  type="text" name="mobile" id="mobile" class="form-control" maxlength="14" value="{{$setting->mobile}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">email</label>
			<div class="col-md-9">
				<input  type="email" name="email" class="form-control" value="{{$setting->email}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Vat</label>
			<div class="col-md-9">
				<input  type="text"  name="vat" class="form-control touchspin_2" value="{{$setting->vat or 0}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2">points price</label>
			<div class="col-md-10">
				<label class="col-md-1 control-label">every</label>
				<div class="col-md-5">
					<input  type="text" name="points" value="{{$setting->points}}" class="form-control touchspin_3">
				</div>
				<label class="col-md-1 control-label">equal</label>
				<div class="col-md-5">
					<input  type="text"  name="points_value" value="{{$setting->points_value}}" class="form-control touchspin_1">
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">max points to exchange </label>
			<div class="col-md-9">
				<input type="text" name="max_points_replace" class="form-control touchspin_3"  value="{{$setting->max_points_replace}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">paypal client id</label>
			<div class="col-md-9">
				<input  type="text" name="paypal_client_id" class="form-control" value="{{$setting->paypal_client_id}}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">paypal secret</label>
			<div class="col-md-9">
				<input  type="password" name="paypal_secret" class="form-control" value="{{$setting->paypal_secret}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">map </label>
			<div class="col-md-9">
				<textarea cols="60" name="map" class="form-control">{{ $setting->map }}</textarea>
			</div>
		</div>
	</div>
	

	
	
	{{-- <div class="form-group">
		<label class="control-label col-md-3">longitude(google map)</label>
		<div class="col-md-9">
			<input  type="text" name="longitude" class="form-control" value="{{$setting->longitude}}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">latitude(google map)</label>
		<div class="col-md-9">
			<input  type="text" name="latitude" class="form-control" value="{{$setting->latitude}}">
		</div>
	</div>--}}
</div>