<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>
        	<th>Image</th>   
            <th>Full Name En </th>
            <th>Email</th>
            <th>Username</th>
            <th>Langue </th>
            <th>Created_at</th>
            <th class="text-center"> Actions </th>
        </tr>
    </thead>
    <tbody>
 		@if(!$students->isEmpty())
	 		@foreach($students as $u)
	        <tr>
	        	<td>
	        		@if(!empty($u->user->image))
					 	<img src="{{asset('/uploads/kcfinder/upload/image/users/'.$u->user->image)}}" style="width:50px;"/>
					 @else
					 	No image
					 @endif 	
	        	</td>  
	     
	            <td>
	            	{{ $u->user->full_name_en}}
	            </td>
	            <td>
	            	{{ $u->user->email}}
	            </td> 
	            <td>
	            	<a href="{{url('admin/users/view/'.$u->id)}}">{{$u->user->username}}</a>				         	
	            </td>
	            <td><i class="fa fa-language lang_edit" aria-hidden="true" data-id="{{$u->user->id}}" style="cursor: pointer;"></i>
	            	@php 
	            	$lang=(!empty($u->user->user_lang)) ? $u->user->user_lang->lang_stud : '' ;

	            	@endphp
                    <span  id="lang_value_{{$u->user->id}}">{{$lang}}</span></td>
	            <td class="center"> 
	            	{{ date("Y-m-d",strtotime($u->created_at)) }}
	            </td>
	            <td>
	            	<a href="{{url('/admin/students/edit/'.$u->id)}}">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit student"></i>
                    </a>
					@if($u->id!=1)
						<a data-toggle="modal" class="deletestudent" elementId="{{$u->id}}">
							<i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete student"></i>
						</a>
					@endif
					<!----bloque student --->
					@if($u->id!=1)
					 
						@if($u->user->blocked==0)
								<a data-toggle="modal" class="blockedstudent" elementId="{{$u->id}}">
									<i class="fa fa-block" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete student">block</i>
								</a>
								
						@else 

								<a data-toggle="modal" class="blockedstudent" elementId="{{$u->id}}">
									<i class="fa fa-block" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete student">unblock </i>
								</a>

						@endif

				    @endif

				<!---------end bloque ------>
					<a href="{{ url('/admin/login-user/'.$u->id) }}" target="_blank">login</a>
					
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>

<script type="text/javascript">
$('.lang_edit').click(function(){

	let id=$(this).attr("data-id");
	editlang(id);
});
function editlang(id)
{
	$.ajax({
		 url: '{{ route('update.lang') }}',
		 data: {id},
		 type: "get",
		
		success: function(data){

             $('#lang_value_'+id).text(data.result)
            // $('#lang_value_'+id).append(data.result)test_return
             console.log(data.result)
		}
	});

}

	</script>
