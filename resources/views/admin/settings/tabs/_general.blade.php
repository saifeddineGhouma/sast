
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
                        <?php
                        $ar_setting = $setting->settings_trans('ar');
                        ?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-2 control-label">site name </label>
									<div class="col-md-10">
										<input type="text" id="name" name="ar_site_name" class="form-control" value="{{(!empty($ar_setting))?$ar_setting->site_name:null}}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">time work</label>
									<div class="col-md-10">
										<input type="text" name="ar_time_work" class="form-control" value="{{(!empty($ar_setting))?$ar_setting->time_work:null}}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">address </label>
									<div class="col-md-10">
										<textarea cols="60"  name="ar_address"  class="form-control">{{(!empty($ar_setting))?$ar_setting->address:null}}</textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="col-md-6">
										<a>
											<div class="fileinput-new thumbnail" onclick="openKCFinder($('#logo-img-ar'),$('#ar_logo'))"
												 data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">
												<img src="{{asset('uploads/kcfinder/upload/image/'.$ar_setting->logo)}}" id="logo-img-ar">
												<input type="hidden" name="ar_logo" id="ar_logo" value="{{$ar_setting->logo}}"/>
											</div>
										</a>
										<a class="btn btn-file" onclick="openKCFinder($('#logo-img-ar'),$('#ar_logo'))">Select Logo</a>
									</div>
								</div>
							</div>
						</div>

						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">footer about</label>
								<div class="col-md-10">
									<textarea class="form-control" name="ar_footer_about"  rows="4">{{(!empty($ar_setting))?$ar_setting->footer_about:null}}</textarea>
								</div>
							</div>
						</div>

						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">footer copyright</label>
								<div class="col-md-10">
									<textarea class="form-control" name="ar_footer_text"  rows="4">{{(!empty($ar_setting))?$ar_setting->footer_text:null}}</textarea>
								</div>
							</div>
						</div>

						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">contact description</label>
								<div class="col-md-10">
									<textarea class="form-control" name="ar_contact_description"  rows="4">{{$setting->settings_trans('ar')->contact_description}}</textarea>
								</div>
							</div>
						</div>


						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">index section</label>
								<div class="col-md-10">
									<textarea class="form-control editor"  id="ar_index_section" name="ar_index_section"  rows="4">{{$setting->settings_trans('ar')->index_section}}</textarea>

								</div>
							</div>
						</div>

						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">index section2</label>
								<div class="col-md-10">
									<textarea class="form-control editor"  id="ar_index_section2" name="ar_index_section2"  rows="4">{{$setting->settings_trans('ar')->index_section2}}</textarea>

								</div>
							</div>
						</div>

						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_index_ar" data-toggle="tab"> home </a>
							</li>
							@foreach($metaData_ar as $metaData)
								<li>
									<a href="#tab_ar_{{$metaData->page}}" data-toggle="tab"> {{$metaData->page}} </a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_index_ar">
								<div class="row">
									<div class="form-group">
										<label class="col-md-2 control-label">meta title</label>
										<div class="col-md-10">
											<input type="text"  name="ar_meta_title" class="form-control maxlength-handler" maxlength="60"
												   value="{{(!empty($ar_setting))?$ar_setting->meta_title:null}}">
											<span class="help-block"> maxlength 60 character</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">meta keyword</label>
										<div class="col-md-10">
											<input type="text" name="ar_meta_keyword" class="form-control" data-role="tagsinput" value="{{(!empty($ar_setting))?$ar_setting->meta_keyword:null}}">
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">meta description</label>
										<div class="col-md-10">
											<textarea cols="60"  name="ar_meta_desc"  class="form-control maxlength-handler" maxlength="160">{{(!empty($ar_setting))?$ar_setting->meta_description:null}} </textarea>
											<span class="help-block"> maxlength 160 character </span>
										</div>
									</div>
								</div>
							</div>
							@foreach($metaData_ar as $metaData)
								<div class="tab-pane" id="tab_ar_{{$metaData->page}}">
									<div class="row">
										<div class="form-group">
											<label class="col-md-2 control-label">meta title</label>
											<div class="col-md-10">
												<input type="text"  name="meta_title[{{$metaData->id}}]" class="form-control maxlength-handler" maxlength="60"
													   value="{{$metaData->title}}">
												<span class="help-block"> maxlength 60 character</span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">meta keyword</label>
											<div class="col-md-10">
												<input type="text" name="meta_keyword[{{$metaData->id}}]" class="form-control" data-role="tagsinput" value="{{$metaData->keyword}}">
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label">meta description</label>
											<div class="col-md-10">
												<textarea cols="60"  name="meta_description[{{$metaData->id}}]"  class="form-control maxlength-handler" maxlength="160">{{$metaData->description}} </textarea>
												<span class="help-block"> maxlength 160 character </span>
											</div>
										</div>
									</div>
								</div>
							@endforeach
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
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-2 control-label">site name </label>
									<div class="col-md-10">
										<input type="text" id="name" name="en_site_name" class="form-control" value="{{$setting->settings_trans('en')->site_name}}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">time work</label>
									<div class="col-md-10">
										<input type="text" name="en_time_work" class="form-control" value="{{ $setting->settings_trans('en')->time_work }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">address </label>
									<div class="col-md-10">
										<textarea cols="60"  name="en_address"  class="form-control">{{$setting->settings_trans('en')->address}}</textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="col-md-6">
										<a>
											<div class="fileinput-new thumbnail" onclick="openKCFinder($('#logo-img-en'),$('#en_logo'))"
												 data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">
												<img src="{{asset('uploads/kcfinder/upload/image/'.$setting->settings_trans('en')->logo)}}" id="logo-img-en">
												<input type="hidden" name="en_logo" id="en_logo" value="{{$setting->settings_trans('en')->logo}}"/>
											</div>
										</a>
										<a class="btn btn-file" onclick="openKCFinder($('#logo-img-en'),$('#en_logo'))">Select Logo</a>
									</div>
								</div>
							</div>
						</div>

						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">footer about</label>
								<div class="col-md-10">
									<textarea class="form-control" name="en_footer_about"  rows="4">{{$setting->settings_trans('en')->footer_about}}</textarea>
								</div>
							</div>
						</div>

						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">footer copyright</label>
								<div class="col-md-10">
									<textarea class="form-control" name="en_footer_text"  rows="4">{{$setting->settings_trans('en')->footer_text}}</textarea>
								</div>
							</div>
						</div>

						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">contact description</label>
								<div class="col-md-10">
									<textarea class="form-control" name="en_contact_description"  rows="4">{{$setting->settings_trans('en')->contact_description}}</textarea>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">index section</label>
								<div class="col-md-10">
									<textarea class="form-control editor"  id="en_index_section" name="en_index_section"  rows="4">{{$setting->settings_trans('en')->index_section}}</textarea>

								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group last">
								<label class="col-md-2 control-label">index section</label>
								<div class="col-md-10">
									<textarea class="form-control editor"  id="en_index_section2" name="en_index_section2"  rows="4">{{$setting->settings_trans('en')->index_section2}}</textarea>

								</div>
							</div>
						</div>

						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_index" data-toggle="tab"> home </a>
							</li>
							@foreach($metaData_en as $metaData)
								<li>
									<a href="#tab_{{$metaData->page}}" data-toggle="tab"> {{$metaData->page}} </a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_index">
								<div class="row">
									<div class="form-group">
										<label class="col-md-2 control-label">meta title</label>
										<div class="col-md-10">
											<input type="text"  name="en_meta_title" class="form-control maxlength-handler" maxlength="60"
												   value="{{$setting->settings_trans('en')->meta_title}}">
											<span class="help-block"> maxlength 60 character</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">meta keyword</label>
										<div class="col-md-10">
											<input type="text" name="en_meta_keyword" class="form-control" data-role="tagsinput" value="{{$setting->settings_trans('en')->meta_keyword}}">
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">meta description</label>
										<div class="col-md-10">
											<textarea cols="60"  name="en_meta_desc"  class="form-control maxlength-handler" maxlength="160">{{$setting->settings_trans('en')->meta_description}} </textarea>
											<span class="help-block"> maxlength 160 character </span>
										</div>
									</div>
								</div>
							</div>
							@foreach($metaData_en as $metaData)
								<div class="tab-pane" id="tab_{{$metaData->page}}">
									<div class="row">
										<div class="form-group">
											<label class="col-md-2 control-label">meta title</label>
											<div class="col-md-10">
												<input type="text"  name="meta_title[{{$metaData->id}}]" class="form-control maxlength-handler" maxlength="60"
													   value="{{$metaData->title}}">
												<span class="help-block"> maxlength 60 character</span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">meta keyword</label>
											<div class="col-md-10">
												<input type="text" name="meta_keyword[{{$metaData->id}}]" class="form-control" data-role="tagsinput" value="{{$metaData->keyword}}">
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label">meta description</label>
											<div class="col-md-10">
												<textarea cols="60"  name="meta_description[{{$metaData->id}}]"  class="form-control maxlength-handler" maxlength="160">{{$metaData->description}} </textarea>
												<span class="help-block"> maxlength 160 character </span>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>


					</div>
				</div>
			</div>

        </div>
    </div>
    
