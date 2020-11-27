<table class="table table-striped table-bordered" id="table1" >
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Course </th>
                                <th>Status</th>
                            
                                <th > Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                              @if(!empty($courses_special))
                                @foreach($courses_special as $course_special)
                                <tr>
                                    <td>{{$course_special->student->user->full_name_en}}</td>
                                    <td>{{$course_special->student->user->email}}</td>
                                    <td>{{ $course_special->course->course_trans('ar')->name }}</td>
                                 <td>
                                     @php 
                                         /* if($course_special->status =="waiting")
                                           $badge="info";
                                           if($course_special->status =="success")
                                           $badge="success";
                                           if($course_special->status =="failed")
                                           $badge="danger";*/

                                        @endphp
                                        <span class="label label-sm label-{{-- $badge --}}">{{$course_special->status}}</span>

                                    </td>
                                    <td>

                                        <a href="{{route('courses_special.edit',$course_special->id)}}">
                                               <button type="button" name="search" id="filterBtn" class="btn btn-warning "  data-loading-text="<li class='fa fa-edit'></li> ">
                                                        <li class="fa fa-edit"></li>  
                                               </button>  
                                        </a>


                                        
                                       <button type="button"  id="{{$course_special->id}}" class="btn btn-danger remove"  data-loading-text="<li class='fa fa-trash'></li> " onclick="confirmDelete({{ $course_special->id}})">
                                                <li class="fa fa-trash"></li>  
                                       </button>  
                               




                                       
                                    </td>
                                     
                                            


                                </tr>

                                @endforeach
                                @endif


                            </tbody>
                        </table>
<!-------------js ajax change status courses------------------->

<script>
  $(document).on('click', '.remove1', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
     var csrf_token=$('meta[name="csrf_token"]').attr('content');
    swal({
            title: "Are you sure!",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            showCancelButton: true,
        },
        function() {
            $.ajax({
                type: "POST",
                url: "{{url('/destroy')}}",
                data: {id:id},
                success: function (data) {
                              //
                    }         
            });
    });
});
</script>