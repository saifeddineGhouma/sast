@if(!empty($user))
<!----user not logged-->
	<p>
    إعداد تقرير علمي كتابي عن إحدى الحالات او المواضيع الرياضية المتعلقة باللياقة البدنية يتم اختياره بطريقة عشوائية من مجموعة عناوين وحالات معدة مسبقا من قبل الاكاديمية. ويتم مناقشته لمدة 15 دقيقة مع مشرف الدورة بعد تحديد موعد مسبق معه. نسبة نجاح الطالب في هذه المهمة 80%. يمكن ايجاد موضوع التقرير العلمي عند اختيار الحالة من الاسفل
    
    </p>
     <div class="alert alert-info  text-center"> <a href="">تحميل الملف </a></div>
      <h5 >الموضوع  : <span id="sujets_description">{{$sujet->description}}</span> </h5>
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

            <div class="col-md-2">رفع الملفات :</div>
            <input type="file" name="document"  >
            <div class="form-group"> الملاحظات   :
                <textarea class="form-control" name="user_message" rows="5" id="comment"></textarea>
            </div>

            <button class="btn btn-danger btn-block quiz_question_end" type="submit">رفع الملف </button>
        </form>   
        @endif

<!----user not logged-->
@else
	<p>
	إعداد تقرير علمي كتابي عن إحدى الحالات او المواضيع الرياضية المتعلقة باللياقة البدنية يتم اختياره بطريقة عشوائية من مجموعة عناوين وحالات معدة مسبقا من قبل الاكاديمية. ويتم مناقشته لمدة 15 دقيقة مع مشرف الدورة بعد تحديد موعد مسبق معه. نسبة نجاح الطالب في هذه المهمة 80%. يمكن ايجاد موضوع التقرير العلمي عند اختيار الحالة من الاسفل

	</p>
	<p><a href="{{route('login')}}">سجل الدخول</a></p>
@endif