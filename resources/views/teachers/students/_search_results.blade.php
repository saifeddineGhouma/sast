<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>
        	<th>image</th>   
        	<th>name ar</th>
            <th>name en</th>
           	<th>email</th>
            <th>user</th>
            <th>created_at</th>
        </tr>
    </thead>
    <tbody>
 		@if(!$students->isEmpty())
	 		@foreach($students as $u)
	        <tr>
	        	<td>
	        		@if(!empty($u->user->image))
					 	<img src="{{asset('/uploads/users/'.$u->user->image)}}" style="width:50px;"/>
					 @else
					 	no image
					 @endif 	
	        	</td>  
	            <td>
	            	{{ $u->user->full_name_ar}}
	            </td>
	            <td>
	            	{{ $u->user->full_name_en}}
	            </td>
	            <td > 
	            	{{ $u->user->email }}
	            </td>
	            <td>
	            	<a href="{{url('teachers/users/view/'.$u->id)}}">{{$u->user->username}}</a>				         	
	            </td>
	            <td class="center"> 
	            	{{ date("Y-m-d",strtotime($u->created_at)) }}
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>