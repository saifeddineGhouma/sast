<div class="row">

	<div class="form-group">

		<div class="col-md-6">

			<div class="form-group">

				<label class="col-md-2 control-label">categories</label>

				<div class="col-md-10">

					<select  name="category_ids[]" id="category_ids" class="form-control select2 select2-hidden-accessible" multiple aria-hidden="true" >

						@foreach($categories as $category)

							<option value="{{$category->id}}"

									{{ $course->categories()->where("categories.id",$category->id)->count()>0?"selected":null }}>

								{{ $category->category_trans("ar")->name }}

							</option>

						@endforeach

					</select>

				</div>

			</div>



			{{-- <div class="form-group">

				<label class="col-md-2 control-label">Vat</label>

				<div class="col-md-10">

					<input  type="text"  name="vat" class="form-control touchspin_1" value="{{$course->vat or 0}}">

				</div>

			</div>--}}



			<div class="form-group">

				<label class="col-md-2 control-label">Period</label>

				<div class="col-md-10">

					<input  type="text"  name="period" class="form-control" value="{{$course->period or 0}}">



				</div>

			</div>

			<div class="form-group">

				<label class="col-md-2 control-label">Video</label>

				<div class="col-md-10">

					<input  type="text" id="video" name="video" class="form-control" value="{{ $course->video }}">

					<a onclick="openKCFinderLink($('#video'))">browse server</a>

				</div>

			</div>

			<div class="form-group">

				<label class="col-md-2 control-label">Promo Points</label>

				<div class="col-md-10">

					<input type="text" name="promo_points" class="form-control touchspin_3" value="{{$course->promo_points or 0}}">

				</div>

			</div>

		</div>

		<div class="col-md-6">

			<a>

				<div class="fileinput-new thumbnail" onclick="openKCFinder($('#image-img'),$('#image'))"

					 data-trigger="fileinput" style="width: 200px; height: 150px;margin-bottom: 0px;">

					<img src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" id="image-img">

					<input type="hidden" name="image" id="image" value="{{$course->image}}"/>

				</div>

			</a>

			<a class="btn btn-file" onclick="openKCFinder($('#image-img'),$('#image'))">Select Thumbnail</a>

		</div>

	</div>

</div>

<div class="row">

	<div class="form-group">

		<label class="col-md-3 control-label">Needs professional experience</label>

		<div class="col-md-9">

			<input type="checkbox" name="needsExperience" {{$course->needsExperience==true?'checked':null}}/>

		</div>

	</div>
	<div class="form-group">

		<label class="col-md-3 control-label">Experienced Course</label>

		<div class="col-md-9">

			<select  name="parent_id" class="form-control">

				<option value=""></option>

				@foreach($experiencedCourses as $experiencedCourse)

					<option value="{{$experiencedCourse->id}}"

							{{ $course->parent_id==$experiencedCourse->id?"selected":null }}>

						{{ $experiencedCourse->course_trans("ar")->name }}

					</option>

				@endforeach

			</select>
			
			<br>

			<select  name="parent_id2" class="form-control">

				<option value=""></option>

				@foreach($experiencedCourses as $experiencedCourse)

					<option value="{{$experiencedCourse->id}}"

							{{ $course->parent_id2==$experiencedCourse->id?"selected":null }}>

						{{ $experiencedCourse->course_trans("ar")->name }}

					</option>

				@endforeach

			</select>

		</div>

	</div>







	<div class="form-group">

		<label class="col-md-3 control-label">Language</label>

		<div class="col-md-9">

			<select  name="language" class="form-control">

				<option value="arabic" {{ $course->language == "arabic"?"selected":null }}>Arabic</option>

				<option value="english" {{ $course->language == "english"?"selected":null }}>English</option>

			</select>

		</div>

	</div>



	<div class="form-group">

		<label class="col-sm-3 control-label">Status</label>

		<div class="col-sm-9">

			<select name="active" class="form-control">

				<option value="1" {{ $course->active?'selected':null }}>Active</option>

				<option value="0" {{ !$course->active?'selected':null }}>Not Active</option>

			</select>

		</div>

	</div>

</div>