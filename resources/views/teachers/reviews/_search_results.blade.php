<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>   
        	<th>course</th>
            <th>client</th>
            <th>comment</th>
            <th>rating</th>
            <th>status</th>
            <th>date added</th>
            <th class="text-center"> actions </th>
        </tr>
    </thead>
    <tbody>
 		@if(!$reviews->isEmpty())
	 		@foreach($reviews as $u)
	        <tr>            
	            <td>
	            	{{$u->course->course_trans(App("lang"))->name}}
	            </td>
	            <td>
					@if(!empty($u->user))
	            		{{$u->user->username}}
					@endif
	            </td>	           
	            <td>
	            	{{$u->comment}}
	            </td>	            
	            <td>
	            	{{$u->value}}
	            </td>
	            <td>
	            	{!! $u->getStatus($u->approved,$u->id) !!}	 
	            </td>
	             <td class="center"> 
	            	{{ date("Y-m-d",strtotime($u->created_at)) }}
	           </td>
	            <td>	
					
					<a href="{{url('teachers/reviews/reply')}}/{{$u->id}}">
						Reply
					</a>   
	               
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>