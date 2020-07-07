<div class="form-group">   
    <div class="col-md-9">
        <div class="radio-list">
            <label>
                <input type="radio" name="choose_user" value="exist" checked/>
                exist users  </label>
            <label>
                <input type="radio" name="choose_user" value="new" />
                new user </label>
        </div>
    </div>
</div>
<div id="exist_div">
	<div class="form-group">
		<label class="col-md-2 control-label">user</label>
		<div class="col-md-9">
			<select class="form-control select2" id="user_id" name="user_id">
				<option value="">choose user</option>
				@foreach($users as $user)
					<option value="{{$user->id}}" {{$method=='edit' && $student->id==$user->id?"selected":null}}>{{$user->username}}</option>
				@endforeach
			</select>															
		</div>
		<div class="col-md-1"></div>
	</div>
	<div class="row" id="user_details">
		
	</div>
</div>
<div id="new_div" class="display-none">
	@include("admin.users._form_fields",array("method"=>"add"))
</div>
