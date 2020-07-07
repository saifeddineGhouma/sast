<table class="table table-striped table-bordered" id="table1">

    <thead>

        <tr>   

        	<th>thumb</th>        

            <th>title</th>

            <th>type</th>

            <th>slug</th>            

            <th>publisher</th>

            <th>status</th>

            <th>created_at</th>

            <th class="text-center"> Actions </th>

        </tr>

    </thead>

    <tbody>

 		@if(!$news->isEmpty())

	 		@foreach($news as $u)

	        <tr>            

	            <td>

	            	<img src="{{asset('uploads/kcfinder/upload/image/'.$u->thumbnail)}}" id="image-img"

	            	style="width:50px;">	         	

	            </td>

	            <td>

					@if(!empty($u->news_trans("ar")))

	            	{{$u->news_trans("ar")->title}}

						@endif

	            </td>

	            <td>

					@if(!empty($u->type))

	            		{{$u->type}}
	            	@else
	            		N/A
					@endif

	            </td>

	            <td>

					@if(!empty($u->news_trans("ar")))

	             	{{$u->news_trans("ar")->slug}}

						@endif

	            </td>	            

	            <td>

	            	@if(!empty($u->publisher))

	            		{{$u->publisher->name}}

	            	@endif

	            </td>

	            <td>

	            	{!! $u->getStatus($u->active,$u->id) !!}

	            </td>

	            <td class="center"> 

	            	{{ date("Y-m-d",strtotime($u->created_at)) }}

	           </td>

	            <td>

	            	<a href="{{url('/admin/news/edit/'.$u->id)}}">

                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit news"></i>

                    </a>                   

                     <a data-toggle="modal" class="deletenews" elementId="{{$u->id}}">

                        <i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete news"></i>

                    </a> 	               

	            </td>

	        </tr>

	        @endforeach

       @endif

    </tbody>

</table>