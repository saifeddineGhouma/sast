<table class="table table-striped table-bordered" id="table1">
    <thead>
        <tr>   
        	<th>order id</th>
            <th>client</th>
            <th>book</th>
            <th>total</th>
			<th>status</th>
            <th>date added</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
 		@if(!$orders->isEmpty())
	 		@foreach($orders as $u)
	        <tr>            
	            <td>
	            	{{$u->id}}		         	
	            </td>
	            <td>
	            	@if(!empty($u->user))
	            		{{ $u->user->username}}	
	            	@endif			         	
	            </td>
	           
	             <td>
					 @if(!empty($u->book))
						 {{ $u->book->book_trans('ar')->name}}
					 @endif
				 </td>
	            <td>
	            	{{$u->total}}$
	            </td>
				<td>
					{{$u->payment_status}}
				</td>
	             <td class="center"> 
	            	{{ date("Y-m-d",strtotime($u->created_at)) }}
	           </td>
	            <td>
	            	<a href="{{url('admin/book-orders/edit/'.$u->id)}}">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit order"></i>
                    </a>
					<a data-toggle="modal" class="deleteorder" elementId="{{$u->id}}">
						<i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete order"></i>
					</a>
	            </td>
	        </tr>
	        @endforeach
       @endif
    </tbody>
</table>