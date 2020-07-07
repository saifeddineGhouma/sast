<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>
            <th>client</th>
            <th>course</th>
			<th>Question</th>
            <th>replies</th>
			<th>status</th>
            <th>date added</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
 		@if(!$courseQuestions->isEmpty())
	 		@foreach($courseQuestions as $u)
	        <tr>
	            <td>
	            	@if(!empty($u->user))
	            		{{ $u->user->username}}
					@else
						admin
	            	@endif			         	
	            </td>
	             <td>
					 @if(!empty($u->course))
						 {{ $u->course->course_trans('ar')->name}}
					 @endif
				 </td>
				<td>
					{!! $u->discussion !!}
				</td>
	            <td>
	            	{{$u->replies()->count()}}
	            </td>
				<td>
					{!! $u->getStatus($u->active,$u->id) !!}
				</td>
	             <td class="center"> 
	            	{{ date("Y-m-d",strtotime($u->created_at)) }}
	           </td>
	            <td>
	            	<a href="{{url('admin/forum/edit/'.$u->id)}}">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit forum"></i>
                    </a>
					<a data-toggle="modal" class="deleterecord" elementId="{{$u->id}}">
						<i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete forum"></i>
					</a>
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>