    <table class="table table-striped table-bordered" id="table1">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Course </th>
                                <th>sujet</th>
                                <th>Fichie Pdf</th>
                                <th>Status</th>
                                <th class="text-center"> Date added </th>
                                <th > Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($study_cases as $study_case)
                                <tr>
                                    <td>{{$study_case->student->user->full_name_ar}}</td>
                                    <td>{{$study_case->student->user->email}}</td>
                                    <td>{{$study_case->course->course_trans('ar')->name}}</td>
                                    <td>
                                        {{$study_case->sujet->description}}

                                        </td>
                                        <td>
                                             
                                            

                                        
                                        <a href="{{asset('uploads/kcfinder/upload/image/studyCase/'.$study_case->document)}}" target="_blank">
                                            
                                            Document  

                                        </a>
                                        

                                        </td>
                                
                                
                                    <td> 

                                        
                                        {{($study_case->successful==1) ? 'success':'Refus'}}
                                        

                                    </td>
                                        <td>{{\Carbon\Carbon::parse($study_case->created_at)->format('m-d-Y')}}</td>
                                    <td>
                                        <a href="{{route('students.studycase.edit',$study_case->id)}}">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit student exam"></i>
                    </a>
                                    </td>

                                </tr>

                                @endforeach


                            </tbody>
                        </table>