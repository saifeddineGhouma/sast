
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
								<input type="text" name="ar_name" class="form-control" value="{{$quiz_trans_ar->name}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" name="ar_slug" class="form-control slug" value="{{$quiz_trans_ar->slug}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">short description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_short_description"  class="form-control maxlength-handler" maxlength="160">{{$quiz_trans_ar->short_description}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">finish message</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_finish_message" id="ar_finish_message"  class="form-control">{{$quiz_trans_ar->finish_message}} </textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">finish message pass</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_finish_message_pass" id="ar_finish_message_pass"  class="form-control">{{$quiz_trans_ar->finish_message_pass}} </textarea>
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
								<input type="text" name="en_name" class="form-control" value="{{$quiz_trans_en->name}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" id="en_slug" name="en_slug" class="form-control slug" value="{{$quiz_trans_en->slug}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">short description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_short_description"  class="form-control maxlength-handler" maxlength="160">{{$quiz_trans_en->short_description}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">finish message</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_finish_message" id="en_finish_message"  class="form-control">{{$quiz_trans_en->finish_message}} </textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">finish message pass</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_finish_message_pass" id="en_finish_message_pass"  class="form-control">{{$quiz_trans_en->finish_message_pass}} </textarea>
							</div>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>
    
