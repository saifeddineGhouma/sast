<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>           	
        	<th>Username</th>
            <th>Full name</th>
            <th>Course </th>
            <th>Exam</th>
            <th>Type</th>
            <th>Status</th>
            <th>Date added </th>
            <th class="text-center">Actions </th>
        </tr>
    </thead>
    <tbody>
 		@if(!$studentExams->isEmpty())
	 		@foreach($studentExams as $key=>$item)
				@php
					$user = App\User::find($item->student_id);
					$course = App\Course::find($item->course_id);
					$course_name = $item->course_name;
					if(!empty($course))
						$course_name = $course->course_trans('ar')->name;
					$exam_name = $item->exam_name;
					if($item->type=="video"){
						$exam = App\VideoExam::find($item->exam_id);
						if(!empty($exam))
							$exam_name = $exam->videoexam_trans('ar')->name;
					}else{
						$exam = App\Quiz::find($item->exam_id);
						if(!empty($exam))
							$exam_name = $exam->quiz_trans('ar')->name;
					}

				@endphp
	        <tr>    
	        	<td>
	        		{{ $user->username }}
	        	</td>  
	            <td>
					{{ $user->full_name_en  }}
	            </td>
	            <td>
	            	{{ $course_name }}
	            </td>
	            <td>
					{{ $exam_name }}
	            </td>
		        <td>
					{{ $item->type }}
		        </td>
		        <td>
					@if($item->status == "pending" || $item->status == "processing")
						<span class="label label-sm label-info">{{ $item->status }}</span>
					@elseif($item->status == "completed")
						<span class="label label-sm label-success">{{ $item->status }}</span>
					@else
						<span class="label label-sm label-danger">{{ $item->status }}</span>
					@endif
		        </td>
	            <td>
	            	{{ date("Y-m-d",strtotime($item->created_at)) }}
	            </td>
	            <td>
					<a href="{{ action('Admin\studentsexamsController@edit', $item->id) }}">
						<i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit student exam"></i>
					</a>
					<a data-toggle="modal" class="deleterecord" elementId="{{$item->id}}" data-type="{{ $item->type }}">
						<i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete student exam"></i>
					</a>
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>