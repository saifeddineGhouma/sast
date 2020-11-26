<table class="table table-striped table-bordered" id="table1" >
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Course </th>
                                <th>Demande de stage</th>
                                <th>Evaluation de stage</th>
                                <th>Status</th>
                                <th class="text-center"> Date added </th>
                                <th > Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($stages as $stage)
                                <tr>
                                    <td>{{$stage->user->full_name_en}}--{{$stage->id}}</td>
                                    <td>{{$stage->user->email}}</td>
                                    <td>{{$stage->course->course_trans('ar')->name}}</td>
                                    <td>
                                       @foreach($stage->user->user_stage as $stage_user)
                                              
                                               <a href="{{asset('uploads/kcfinder/upload/image/stage/'.$stage_user->demande_stage)}}" target="_blank">
                                            
                                             stage   

                                                </a> <br/>

                                        @endforeach
                                    
                                        

                                        </td>
                                        <td>
                                        
                                        
                                         @foreach($stage->user->user_stage as $stage_user)
                                              
                                               <a href="{{asset('uploads/kcfinder/upload/image/stage/'.$stage_user->evaluation_stage)}}" target="_blank">
                                            
                                             Evalution de stage 

                                                </a> <br/>

                                        @endforeach

                                        </td>
                                
                                
                                    <td> 
                                        @php 
                                    
                                        if($stage->valider==1)
                                        {
                                            $badge='success';
                                            $status='Valid' ;
                                        }elseif($stage->valider==0){
                                            $badge='info';
                                            $status='EnCours';


                                    }else{
                                            $badge='danger';
                                            $status='Invalid';

                                }
                                        
                                        

                                        @endphp
                                        
                                            
                                        
                                        <span class="badge badge-{{$badge}}">{{$status}}</span>

                                    </td>
                                        <td>{{\Carbon\Carbon::parse($stage->created_at)->format('m-d-Y')}}</td>
                                    <td>
                                @php 
                                    
                                        if($stage->valider==1)
                                        {
                                            $badge='success';
                                            $status='Valid' ;
                                        }elseif($stage->valider==0){
                                            $badge='info';
                                            $status='EnCours';


                                    }else{
                                            $badge='danger';
                                            $status='Invalid';

                                }
                                        
                                        

                                        @endphp
                                        
                                            

                                                <a href="{{route('students.stage.edit',$stage->id)}}">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit student stage"></i>
                    </a>
                                        
                                        
                                    </td>

                                </tr>

                                @endforeach


                            </tbody>
                        </table>
<!-------------js ajax change status courses------------------->

<script type="text/javascript">
	
	$('.activeIcon').click(activeIcon_click)
	function activeIcon_click(){
    
    var id = $(this).data('id');
    var this1 =$(this);
    swap(id,'active',this1);
   }
function swap(state,field,this1){
    var sp = state.split('-');
    var newsate = true;
    var onstate = "on";
    var offstate = "off";

    if(sp[0]==onstate){
        this1.html('<span class="label label-sm label-danger"> not active</span>');
        this1.data('id',state.replace(sp[0],offstate));
        newsate = false;
    }else{
        this1.html('<span class="label label-sm label-success"> active </span>');
        this1.data('id',state.replace(sp[0],onstate));
        newsate = true;
    }
    var _token = '<?php echo csrf_token(); ?>';

    $.ajax({
        url: "{{ url('/admin/courses/updatestateajax') }}",
        type:  'POST',
        data: {_token:  _token,sp: sp[1],newsate: newsate,field: field},
        success: function(result){
        }

    });

}

</script>