<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>
			<th>#</th>
        	<th>thumb</th>
            <th>name</th>
            <th>categories </th>
            <th>type</th>
            <th>period</th>
            <th>Student</th>
            <th>Certificated</th>
            <th>status</th>
            <th> date added </th>
            <th class="text-center"> Actions </th>
        </tr>
    </thead>
    <tbody>
 		@if(!$courses->isEmpty())
	 		@foreach($courses as $key=>$item)
	        <tr>
				<td>{{ $item->id }}</td>
	        	<td>
	        		@if(!empty($item->image))
					 	<img src="{{asset('uploads/kcfinder/upload/image/'.$item->image)}}" style="width:60px;"/>
					 @else
					 	no thumbnail
					 @endif 	
	        	</td>  
	            <td>
	            	{{ $item->course_trans("ar")->name}}<br/>
					({{ $item->views()->count() }}) view
	            </td>
	            <td>
	            	@foreach($item->categories as $category)
	            		{{$category->category_trans("ar")->name}}
						@if (!$loop->last)
							,
						@endif
	            	@endforeach
	            </td>
	            <td>
					@foreach($item->courseTypes as $courseType)
						@if($courseType->type=="online")
							{{$courseType->type}}
						@else
							classroom
						@endif
						@if (!$loop->last)
							,
						@endif
					@endforeach
	            </td>
		        <td>
		        	{{ $item->period }}
		        </td>
		        <td>
		        	{{ $item->StudentByCourses }}
		        </td>
		        <td>
		        	{{ $item->StudentCertifacated }}
		        </td>
		        <td>
		        	{!! $item->getStatus($item->active,$item->id) !!}
		        </td>
	            <td> 
	            	created at<br/>
	            	{{ date("Y-m-d",strtotime($item->created_at)) }}<br/>
	            	last update <br/>
	            	{{ date("Y-m-d",strtotime($item->updated_at)) }}
	            </td>
	            <td>
	            	@if(!$deleted)
						<a href="{{ action('Admin\coursesController@edit', $item->id) }}">
							<i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit course"></i>
						</a>
						<a data-toggle="modal" class="deleterecord" elementId="{{$item->id}}">
							<i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete course"></i>
						</a>
	                @else	                	
	                	<a data-toggle="modal" class="restore" elementId="{{$item->id}}">
	                        <i class="livicon" data-name="undo" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="restore course"></i>
	                    </a>
	                @endif   
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>