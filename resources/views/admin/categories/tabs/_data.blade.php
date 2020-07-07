<div class="row">
	<div class="form-group">
		<div class="col-md-6">
			<a>
				<div class="fileinput-new thumbnail" onclick="openKCFinder($('#image-img'),$('#image'))"
					 data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">
					<img src="{{asset('uploads/kcfinder/upload/image/'.$category->image)}}" id="image-img">
					<input type="hidden" name="image" id="image" value="{{$category->image}}"/>
				</div>
			</a>
			<a class="btn btn-file" onclick="openKCFinder($('#image-img'),$('#image'))">Select Logo</a>
		</div>
	</div>
</div>
