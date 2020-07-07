<div class="table-responsive">
	<table id="courses" class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td>course</td>
          <td>active</td>
			@if($from_section=="exam")
				<td>attempts <br/>(zero no limits)</td>
			@endif
          <td></td>
        </tr>
      </thead>
      <tbody>
	      @foreach($exam->courses_exams as $course_exam)
		       <tr id="course-row{{$course_exam->id}}" data-id="{{$course_exam->id}}">
		          <td class="text-left">
					  <select  name="course_course_id_{{$course_exam->id}}" class="form-control select2">
						  @foreach($courses as $course)
							  <option value="{{$course->id}}" {{$course_exam->course_id == $course->id?"selected":null}}>
								  {{ $course->course_trans("ar")->name }}
							  </option>
						  @endforeach
					  </select>
		          </td>
		          <td>
					  <input type="checkbox" name="course_active_{{$course_exam->id}}" {{ $course_exam->active?"checked":null }}>
		          </td>
				   @if($from_section=="exam")
					   <td>
						   <input type="number" class="form-control" name="course_attempts_{{$course_exam->id}}" value="{{$course_exam->attempts}}">
					   </td>
				   @endif
		          <td class="text-left"><button type="button" onclick="$('#course-row{{$course_exam->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
		        </tr>                                 
	      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="{{$from_section=="exam"?3:2}}"></td>
          <td class="text-left"><button type="button" onclick="addCourse();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Course"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
      </tfoot>
    </table>
</div>
