<div class="panel-body">

	<div class="row">

		<div class="col-md-6">

			<a>

	    		<div class="fileinput-new thumbnail" onclick="openKCFinder($('#thumb-img'),$('#thumb'))" 

	    		data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">

			    	<img src="{{($method=='edit')?asset('uploads/kcfinder/upload/image/'.$news->thumbnail):null}}" id="thumb-img">

			    	<input type="hidden" name="thumbnail" id="thumb" value="{{($method=='edit')?$news->thumbnail:null}}"/>

			    </div>

		    </a>

		    <a class="btn btn-file" onclick="openKCFinder($('#thumb-img'),$('#thumb'))">Select thumbnail</a>

		    

			

		</div>

		<div class="col-md-6">

			<a>

	    		<div class="fileinput-new thumbnail" onclick="openKCFinder($('#image-img'),$('#image'))" 

	    		data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">

			    	<img src="{{($method=='edit')?asset('uploads/kcfinder/upload/image/'.$news->image):null}}" id="image-img">

			    	<input type="hidden" name="image" id="image" value="{{($method=='edit')?$news->image:null}}"/>

			    </div>

		    </a>

		    <a class="btn btn-file" onclick="openKCFinder($('#image-img'),$('#image'))">Select image</a>

		</div>

	</div>

	<div class="form-group">

		<label class="col-md-2 control-label">active</label>

		<div class="col-md-10">

			<input type="checkbox" name="active" class="form-control" {{$method=="add"?"checked":null}} {{($method=="edit" && $news->active)?"checked":null}}>		        	

		</div>

	</div>

	<div class="form-group">

		<label class="col-md-2 control-label">Type</label>

		<div class="col-md-10">
			@isset($news)
				<select name="type" class="form-control">
					<option>Choose type</option>
					<option value="news" {{ $news->type=="news"?"selected":null }} >News</option>
					<option value="article" {{ $news->type=="article"?"selected":null }} >Article</option>
				</select>	
			@else
				<select name="type" class="form-control">
					<option>Choose type</option>
					<option value="news">News</option>
					<option value="article">Article</option>
				</select>
			@endisset        	

		</div>

	</div>

</div>