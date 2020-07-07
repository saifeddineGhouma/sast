
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
								<input type="text" name="name_ar" class="form-control" value="{{$certificate->name_ar}}">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label">description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_ar"  class="form-control" maxlength="160">{{$certificate->description_ar}} </textarea>
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
							<label class="col-md-2 control-label">name <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" name="name_en" class="form-control" value="{{$certificate->name_en}}">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label">description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_en"  class="form-control" maxlength="160">{{$certificate->description_en}} </textarea>
							</div>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>
    
