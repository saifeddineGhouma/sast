<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="col-md-2 control-label">sort order</label>
			<div class="col-md-10">
				<input  type="number" name="sort_order" class="form-control" value="{{$question->sort_order or 1}}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Points</label>
			<div class="col-md-10">
				<input  type="text"  name="points" class="form-control touchspin_1" value="{{$question->points or 1}}">
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<div class="col-md-6">
				<a>
					<div class="fileinput-new thumbnail" onclick="openKCFinder($('#image-img'),$('#image'))"
						 data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">
						<img src="{{asset('uploads/kcfinder/upload/image/'.$question->image)}}" id="image-img">
						<input type="hidden" name="image" id="image" value="{{$question->image}}"/>
					</div>
				</a>
				<a class="btn btn-file" onclick="openKCFinder($('#image-img'),$('#image'))">Select image</a>
			</div>
		</div>
	</div>
</div>
