@if(!empty($user))
<!----user not logged-->
	<p style="text-align:left">
@lang('navbar.header_study_case')    
    </p>
     <div class="alert alert-info  text-center"> <a href="">@lang('navbar.upload_file') </a></div>
      <h5 >@lang('navbar.sujet')  : <span id="sujets_description">{{$sujet->description}}</span> </h5>
       @if($passed>0)
        <ul class="list-group" style="width: 500px;margin:auto;">
            @foreach($user->studycase()->where('courses_id',$course->id)->where('document','!=','')->get() as $studycase)
              <li class="list-group-item"> التقرير<span style="float: left" onclick="return confirm('Are you sure you want to delete this file?');"><a href="{{route('delete.studycase',$studycase->id)}}"><i class="fa fa-trash"></i></a></span>
              </li>
            @endforeach
             
        </ul>
                                     
                                   
        @else
         <form action="{{route('post.study.case')}}" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}


            <input type="hidden" name="sujets_id" value="{{ $sujet->id }}">
            <input type="hidden" name="courses_id" value="{{ $course->id }}">

            <div class="col-md-2">@lang('navbar.upload_file'):</div>
            <input type="file" name="document"  >
            <div class="form-group"> @lang('navbar.notes')    :
                <textarea class="form-control" name="user_message" rows="5" id="comment"></textarea>
            </div>

            <button class="btn btn-danger btn-block quiz_question_end" type="submit">@lang('navbar.upload_file') </button>
        </form>   
        @endif

<!----user not logged-->
@else
	<p>
      @lang('navbar.header_study_case')
	</p>
	<p><a href="{{route('login')}}">سجل الدخول</a></p>
@endif