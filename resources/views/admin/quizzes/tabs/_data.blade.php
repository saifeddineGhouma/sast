<div class="row">
	@if($quiz->is_exam)
		<input type="hidden" name="exam" value="1"/>

		<div class="form-group">
			<label class="col-md-2 control-label">Price</label>
			<div class="col-md-10">
				<input type="text" name="price" class="form-control touchspin_2" value="{{$quiz->price or 0}}">
			</div>
		</div>
	@endif
	<div class="form-group">
		<label class="col-md-2 control-label">num questions</label>
		<div class="col-md-10">
			<input  type="text"  name="num_questions" class="form-control touchspin_3" value="{{$quiz->num_questions or 0}}">
		</div>
	</div>


	<div class="form-group">
		<label class="col-md-2 control-label">duration</label>
		<div class="col-md-10">
			<input  type="text"  name="duration" class="form-control touchspin_1" value="{{$quiz->duration or 0}}">

		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">pass mark</label>
		<div class="col-md-10">
			<input  type="text"  name="pass_mark" class="form-control touchspin_2" value="{{$quiz->pass_mark or 0}}">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">language</label>
		<div class="col-md-10">
			<select name="lang" class="select2">
				<option value=""></option>
				<option value="Ar" {{$quiz->lang == 'Ar' ? 'selected' : ''}}>Arabic</option>
				<option value="Fr" {{$quiz->lang == 'Fr' ? 'selected' : ''}}>French</option>
			</select>
		</div>
	</div>


</div>
