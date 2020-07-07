
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
							<label class="col-md-2 control-label">question</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_question" class="form-control">{{$question_trans_ar->question}} </textarea>
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
							<label class="col-md-2 control-label">question</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_question" class="form-control">{{$question_trans_en->question}} </textarea>
							</div>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>
    
