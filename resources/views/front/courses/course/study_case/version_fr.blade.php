@if(!empty($user))
<!----user  logged-->
	<p>
    description francais
    
    </p>
     <div class="alert alert-info  text-center"> <a href="">Telecharge fichier</a></div>
      <h5 >sujet : <span id="sujets_description" style="font-size: 16px">{{$sujet->description}}</span> </h5>
       @if($passed>0)
        <ul class="list-group" style="width: 500px;margin:auto;">
            @foreach($user->studycase()->where('courses_id',$course->id)->where('document','!=','')->get() as $studycase)
              <li class="list-group-item">file<span style="float: left" onclick="return confirm('Are you sure you want to delete this file?');"><a href="{{route('delete.studycase',$studycase->id)}}"><i class="fa fa-trash"></i></a></span>
              </li>
            @endforeach
             
        </ul>
                                     
                                   
        @else
     
         <form class="border" style="padding:50px" action="{{route('post.study.case')}}" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}


            <input type="hidden" name="sujets_id" value="{{ $sujet->id }}">
            <input type="hidden" name="courses_id" value="{{ $course->id }}">

           
            <div class="col-md-6" ><input type="file" name="document"  ></div>
             <div class="col-md-6" >:upload fichier</div>
              <div class="form-group">
             
              <div class="col-md-8"> 
                  <textarea class="form-control" name="user_message" rows="5" id="comment"></textarea>
              </div> 
              <div class="col-md-4"> <label for="commantaire">:Commantaire  </label></div> 
              
            </div>
            

            <button class="btn btn-danger btn-block quiz_question_end" type="submit">envoyer fichier</button>
        </form>  
     
        @endif

<!----user not logged-->
@else
	<p>
	description francais
	</p>
	<p><a href="{{route('login')}}">سجل الدخول</a></p>
@endif