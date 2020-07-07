<div class="panel-body">
	<div class="row">
		<div class="col-md-6">
			<a>
	    		<div class="fileinput-new thumbnail" onclick="openKCFinder($('#image-img'),$('#image'))" 
	    		data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">
			    	<img src="{{($method=='edit')?asset('uploads/kcfinder/upload/image/'.$testimonial->image):null}}" id="image-img">
			    	<input type="hidden" name="image" id="image" value="{{($method=='edit')?$testimonial->image:null}}"/>
			    </div>
		    </a>
		    <a class="btn btn-file" onclick="openKCFinder($('#image-img'),$('#image'))">Select image</a> 
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-2 control-label">website</label>
				<div class="col-md-10">
					 <input type="text" name="website" class="form-control" value="{{($method=='edit')?$testimonial->website:null}}"/>       	
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">active</label>
				<div class="col-md-10">
					<input type="checkbox" name="active" class="form-control" {{$method=="add"?"checked":null}} {{($method=="edit" && $testimonial->active)?"checked":null}}>		        	
				</div>
			</div>
		</div>
	</div>	
</div>