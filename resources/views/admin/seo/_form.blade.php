
		<input type="hidden" id="id" name="id" value="{{$method=='edit' ? $seo->id:'0'}}">
		
		<div class="form-actions left" style="float: right;">
	        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">
	            <i class="fa fa-check"></i> Save</button>
	        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/seo')}}'"><i class="fa fa-reply"></i> Cancel</button>
	    </div>	
	    
	    <div class="clearfix"></div>
	    <div class="tabbable-bordered">
            <div class="tab-content">
                <div class="form-group">
					<label class="col-md-2 control-label">Page</label>
					<div class="col-md-4">
						<input type="text" name="page" disabled class="form-control" value="{{$seo->page}}">
					</div>
				</div>
                <div class="form-group">
					<label class="col-md-2 control-label">Title SEO <span style="color:red;">*</span></label>
					<div class="col-md-4">
						<input type="text" name="title_seo" equired class="form-control" value="{{$seo->title_seo}}">
					</div>
				</div>
                <div class="form-group">
					<label class="col-md-2 control-label">Description SEO <span style="color:red;">*</span></label>
					<div class="col-md-4">
						<input type="text" name="description_seo" equired class="form-control" value="{{$seo->description_seo}}">
					</div>
				</div>
                <div class="form-group">
					<label class="col-md-2 control-label">Keywords SEO <span style="color:red;">*</span></label>
					<div class="col-md-4">
						<input type="text" name="keyword_seo" equired class="form-control" value="{{$seo->keyword_seo}}">
					</div>
				</div>
            </div>
           
        </div>