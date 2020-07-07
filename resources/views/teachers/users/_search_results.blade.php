<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>   
        	<th>username</th>        
            <th>name</th>
            <th>type</th>
            <th> email</th>            
            <th> status</th>
            <th> created_at</th>
            <th class="text-center"> Actions </th>
        </tr>
    </thead>
    <tbody>
 		@if(!$users->isEmpty())
	 		@foreach($users as $u)
	        <tr>
	        	<td>
	            	{{ $u->username}}				         	
	            </td>
	            <td>
	            	{{ $u->full_name_ar}}
	            </td>
	            <td>
	            	
	            </td>
	             <td>
	            	{{$u->email}}				         	
	            </td>	            
	            <td>
	            	{!! $u->getStatus($u->active,$u->id) !!}<br/>
	            	<?php $count = $u->newsletter_subscibers->count();?>
	            	@if($count>0)
	            		<span class="label label-sm label-info" style="margin-top:5px;display: inline-block;">  Subscribed</span>
	            	@else
	            		<span class="label label-sm label-info" style="margin-top:5px;display: inline-block;"> unSubscribed</span>
	            	@endif	            	            	
	            </td>
	             <td class="center"> 
	            	{{ date("Y-m-d",strtotime($u->created_at)) }}
	           </td>
	            <td>
	            	<a href="{{url('/admin/users/edit/'.$u->id)}}">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit user"></i>
                    </a>
                    <a href="{{url('/admin/users/view/'.$u->id)}}">
                        <i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view user"></i>
                    </a>
                    @if($u->id!=1)
                        <a data-toggle="modal" class="deletuser" elementId="{{$u->id}}">
                            <i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i>
                        </a>
                    @endif
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>