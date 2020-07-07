
	<ul class="nav nav-tabs">
        <li class="active">
			<a href="#tab_1" data-toggle="tab" aria-expanded="true">
				<img src="{{asset('assets/admin/img/flags/kw.png')}}">
				Arabic
			</a>
        </li>
       <li>
		   <a href="#tab_2" data-toggle="tab" aria-expanded="true">
			   <img src="{{asset('assets/admin/img/flags/gb.png')}}">
			   English
		   </a>
       </li>
   </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="tab_1">
			<div class="col-lg-12">
				<div class="panel">
					<div class="panel-heading">

					</div>
					<div class="panel-body">

						<div class="form-group">
							<label class="col-md-2 control-label">name <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" name="ar_name" class="form-control" value="{{$book_trans_ar->name}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" name="ar_slug" class="form-control slug" value="{{$book_trans_ar->slug}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">short description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_short_description"  class="form-control maxlength-handler" maxlength="160">{{$book_trans_ar->short_description}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">content</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_content" id="ar_content"  class="form-control maxlength-handler">{{$book_trans_ar->content}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">meta title</label>
							<div class="col-md-10">
								<input type="text"  name="ar_meta_title" class="form-control maxlength-handler" maxlength="60"
									   value="{{$book_trans_ar->meta_title}}">
								<span class="help-block"> maxlength 60 character</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">meta keyword</label>
							<div class="col-md-10">
								<input type="text" name="ar_meta_keyword" class="form-control" data-role="tagsinput" value="{{$book_trans_ar->meta_keyword}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">meta description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_meta_description"  class="form-control maxlength-handler" maxlength="160">{{$book_trans_ar->meta_description}} </textarea>
								<span class="help-block"> maxlength 160 character </span>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="tab-pane fade" id="tab_2">
			<div class="col-lg-12">
				<div class="panel">
					<div class="panel-heading">

					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-2 control-label">name </label>
							<div class="col-md-10">
								<input type="text" name="en_name" class="form-control" value="{{$book_trans_en->name}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" id="en_slug" name="en_slug" class="form-control slug" value="{{$book_trans_en->slug}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">short description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_short_description"  class="form-control maxlength-handler" maxlength="160">{{$book_trans_en->short_description}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">content</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_content" id="en_content"  class="form-control maxlength-handler">{{$book_trans_en->content}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">meta title</label>
							<div class="col-md-10">
								<input type="text"  name="en_meta_title" class="form-control maxlength-handler" maxlength="60"
									   value="{{$book_trans_en->meta_title}}">
								<span class="help-block"> maxlength 60 character</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">meta keyword</label>
							<div class="col-md-10">
								<input type="text" name="en_meta_keyword" class="form-control" data-role="tagsinput" value="{{$book_trans_en->meta_keyword}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">meta description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_meta_description"  class="form-control maxlength-handler" maxlength="160">{{$book_trans_en->meta_description}} </textarea>
								<span class="help-block"> maxlength 160 character </span>
							</div>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>
    
