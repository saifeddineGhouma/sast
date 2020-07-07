<!-- BEGIN FORM-->
<?php
	$url="";
	
		if($method == 'add'){
			$button = "<i class='fa fa-check'></i> add ";
			$url = url('admin/packs/create');
		}else {
			$button = "<i class='fa fa-pencil'></i> edit";
			$url = url('admin/packs/edit/'.$packs->id);
			
		}
	?>
<form method="POST" id="form_pack" action="{{$url}}" class="form-horizontal form-bordered form-label-stripped" enctype="multipart/form-data">
    <div class="form-body">
		<input type="hidden" id="url" value="{{$url}}">
		<input type="hidden" id="method" value="{{$method}}">
		<input type="hidden" id="id" value="{{$method=='edit' ? $packs->id:'0'}}">
		<input type="hidden" name="lang" value="ar">
		
        {{csrf_field()}}
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
				<br>
				<div class="form-group">
					<label class="col-md-3 control-label">Title</label>
					<div class="col-md-6">
						<input  type="text"  name="title"  class="form-control" value="{{$method=='edit' ? $packs->titre:''}}">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="name">image</label>
					<div class="col-md-6">
						<div class="fileinput fileinput-new input-group" data-provides="fileinput">
							<div class="form-control" data-trigger="fileinput">
								<i class="glyphicon glyphicon-file fileinput-exists"></i>
								<span class="fileinput-filename"></span>
							</div>
							<span class="input-group-addon btn btn-default btn-file">
								<span class="fileinput-new">Select file</span>
								<span class="fileinput-exists">Change</span>
								<input type="file" name="image"></span>
							<a href="javascript:;" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
						</div>
						<div class="col-md-9">
							<?php if($method=="edit"){?>
								@include('admin.packs._images',array('packs'=>$packs))
							<?php }?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Course 1  <span style="color:red;">*</span></label>
					<div class="col-md-6">
						@if(!empty($packs))
							<select  name="course_id1" class="form-control">
								<option value=""></option>
								@foreach($courses as $course)
									@if($packs->cours_id1==$course->id)
										<option value="{{$course->id}}" selected>
									@else
										<option value="{{$course->id}}">
									@endif
										{{ $course->course_trans("ar")->name }}
									</option>
								@endforeach
							</select>
						@else
							<select  name="course_id1" class="form-control">
								<option value=""></option>
								@foreach($courses as $course)
									<option value="{{$course->id}}">
										{{ $course->course_trans("ar")->name }}
									</option>
								@endforeach
							</select>
						@endif
					</div>
				</div> 
				
				<div class="form-group">
					<label class="col-md-3 control-label">Course 2  <span style="color:red;">*</span></label>
					<div class="col-md-6">
						@if(!empty($packs))
							<select  name="course_id2" class="form-control">
								<option value=""></option>
								@foreach($courses as $course)
									@if($packs->cours_id2==$course->id)
										<option value="{{$course->id}}" selected>
									@else
										<option value="{{$course->id}}">
									@endif
										{{ $course->course_trans("ar")->name }}
									</option>
								@endforeach
							</select>
						@else
							<select  name="course_id2" class="form-control">
								<option value=""></option>
								@foreach($courses as $course)
									<option value="{{$course->id}}">
										{{ $course->course_trans("ar")->name }}
									</option>
								@endforeach
							</select>
						@endif
					</div>
				</div> 
				
				<div class="form-group">
					<label class="col-md-3 control-label">Price</label>
					<div class="col-md-6">
						<input  type="text"  name="price" class="form-control touchspin_1" value="{{$method=='edit' ? $packs->prix:'0'}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Content</label>
					<div class="col-md-6">
						<textarea cols="60"  name="ar_content" id="ar_content"  class="form-control maxlength-handler">{{$method=='edit' ? $packs->description:''}}</textarea>
						<span class="help-block"> max legnth 160 char </span>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="tab_2">
			dd
			</div>
		</div>

        <div class="form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm">{!!$button!!}</button>
                <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/packs')}}'"><i class="fa fa-reply"></i>Cancel</button>
            </div>
        </div>
    </div>

</form>

