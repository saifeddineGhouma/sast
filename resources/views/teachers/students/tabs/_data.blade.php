<div class="panel-body">

	<div class="row">
		<div class="form-group">
			<label class="col-md-2 control-label">health info</label>
			<div class="col-md-10">
				<textarea name="health_info" class="form-control">{{($method=='edit')?$student->health_info:null}}</textarea>
			</div>
		</div>
	</div>
</div>