
	<ul class="nav nav-tabs">
        <li class="active">
			<a href="#tab_1" data-toggle="tab" aria-expanded="true">
				<img src="{{asset('assets/admin/img/flags/kw.png')}}">
				Arabic
			</a>
        </li>
       <li>
		   <a href="#tab_2" data-toggle="tab" aria-expanded="true">
			   <img src="{{asset('assets/admin/img/flags/gb.png')}}">
			   English
		   </a>
       </li>
   </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="tab_1">
			<div class="col-lg-12">
				<div class="panel">
					<div class="panel-heading">

					</div>
					<div class="panel-body">

						<div class="form-group">
							<label class="col-md-2 control-label">name <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" name="ar_name" class="form-control" value="{{$course_trans_ar->name}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" name="ar_slug" class="form-control slug" value="{{$course_trans_ar->slug}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">short description </label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_short_description"  class="form-control maxlength-handler" maxlength="160">{{$course_trans_ar->short_description}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">ad</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_ad"  class="form-control">{{$course_trans_ar->ad}} </textarea>
							</div>
						</div>

						{{-- add description  --}}

						
						<div class="form-group">
							<label class="col-md-2 control-label">Description the exams </label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_all_exam" id="description_all_exam"  class="ckeditor">{{$course->description_all_exam}} </textarea>
							</div>
						</div>
						

						{{-- add quizzes --}}
						<div class="form-group">
							<label class="col-md-2 control-label">Description the quizzes</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_quiz" id="description_quiz" class="ckeditor">{{$course->description_quiz}} </textarea>
							</div>
						</div>
						
							{{--  --}}
						
						<div class="form-group">
							<label class="col-md-2 control-label">Description final exam</label>
							<div class="col-md-10">
								<textarea cols="60"  name="desciption_exam" id="desciption_exam" class="ckeditor">{{$course->desciption_exam}} </textarea>
							</div>
						</div>
						
							{{--  --}}
						
						<div class="form-group">
							<label class="col-md-2 control-label">Description video exam</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_exam_video" id="description_exam_video" class="ckeditor">{{$course->description_exam_video}} </textarea>
							</div>
						</div> 
						
								{{--  --}}
						<div class="form-group">
							<label class="col-md-2 control-label">Description Stage</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_stage" id="description_stage" class="ckeditor">{{$course->description_stage}} </textarea>
							</div>
						</div>
						     <!---start study case description--->
						<div class="form-group">
							<label class="col-md-2 control-label">Description Study case</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_study_case" id="description_study_case" class="ckeditor">{{$course->description_study_case}} </textarea>
							</div>
						</div>
									
						
								<!---end --->


						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_online_ar" data-toggle="tab" aria-expanded="true">
									online
								</a>
							</li>
							<li>
								<a href="#tab_presence_ar" data-toggle="tab" aria-expanded="true">
									classroom
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab_online_ar">
								<div class="form-group">
									<label class="col-md-2 control-label">content</label>
									<div class="col-md-10">
										<textarea cols="60"  name="ar_content_online" id="ar_content_online"  class="form-control">{{$course_trans_ar->content_online}} </textarea>
									</div>
								</div>
							</div>
					
							<div class="tab-pane fade" id="tab_presence_ar">
								<div class="form-group">
									<label class="col-md-2 control-label">content</label>
									<div class="col-md-10">
										<textarea cols="60"  name="ar_content_classroom" id="ar_content_classroom"  class="form-control">{{$course_trans_ar->content_classroom}} </textarea>
									</div>
								</div>
								
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label">meta title</label>
							<div class="col-md-10">
								<input type="text"  name="ar_meta_title" class="form-control maxlength-handler" maxlength="60"
									   value="{{$course_trans_ar->meta_title}}">
								<span class="help-block"> maxlength 60 character</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">meta keyword</label>
							<div class="col-md-10">
								<input type="text" name="ar_meta_keyword" class="form-control" data-role="tagsinput" value="{{$course_trans_ar->meta_keyword}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">meta description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="ar_meta_description"  class="form-control maxlength-handler" maxlength="160">{{$course_trans_ar->meta_description}} </textarea>
								<span class="help-block"> maxlength 160 character </span>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!---- anglais-->
        <div class="tab-pane fade" id="tab_2">
			<div class="col-lg-12">
				<div class="panel">
					<div class="panel-heading">

					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-2 control-label">name </label>
							<div class="col-md-10">
								<input type="text" name="en_name" class="form-control" value="{{$course_trans_en->name}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">slug <span style="color:red;">*</span></label>
							<div class="col-md-10">
								<input type="text" id="en_slug" name="en_slug" class="form-control slug" value="{{$course_trans_en->slug}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">short description En</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_short_description"  class="form-control maxlength-handler" maxlength="160">{{$course_trans_en->short_description}} </textarea>
								<span class="help-block"> max legnth 160 char </span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">ad</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_ad"  class="form-control">{{$course_trans_en->ad}} </textarea>
							</div>
						</div>
						<!----anglais ---->
							{{-- add description  --}}

						
						<div class="form-group">
							<label class="col-md-2 control-label">Description the exams </label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_all_exam_en" id="description_all_exam_en"  class="ckeditor">{{$course->description_all_exam_en}} </textarea>
							</div>
						</div>
						

						{{-- add quizzes --}}
						<div class="form-group">
							<label class="col-md-2 control-label">Description the quizzes</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_quiz_en" id="description_quiz_en" class="ckeditor">{{$course->description_quiz_en}} </textarea>
							</div>
						</div>
						
							{{--  --}}
						
						<div class="form-group">
							<label class="col-md-2 control-label">Description final exam</label>
							<div class="col-md-10">
								<textarea cols="60"  name="desciption_exam_en" id="desciption_exam_en" class="ckeditor">{{$course->desciption_exam_en}} </textarea>
							</div>
						</div>
						
							{{--  --}}
						
						<div class="form-group">
							<label class="col-md-2 control-label">Description video exam</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_exam_video_en" id="description_exam_video_en" class="ckeditor">{{$course->description_exam_video_en}} </textarea>
							</div>
						</div> 

						<div class="form-group">
							<label class="col-md-2 control-label">Description Stage</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_stage_en" id="description_stage_en" class="ckeditor">{{$course->description_stage_en}} </textarea>
							</div>
						</div>
						     <!---start study case description--->
						<div class="form-group">
							<label class="col-md-2 control-label">Description Study case</label>
							<div class="col-md-10">
								<textarea cols="60"  name="description_study_case_en" id="description_study_case_en" class="ckeditor">{{$course->description_study_case_en}} </textarea>
							</div>
						</div>


						<!--end -->

						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_online_en" data-toggle="tab" aria-expanded="true">
									online
								</a>
							</li>
							<li>
								<a href="#tab_presence_en" data-toggle="tab" aria-expanded="true">
									classroom
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab_online_en">
								<div class="form-group">
									<label class="col-md-2 control-label">content</label>
									<div class="col-md-10">
										<textarea cols="60"  name="en_content_online" id="en_content_online"  class="form-control">{{$course_trans_en->content_online}} </textarea>
									</div>
								</div>
							</div>
							
							<div class="tab-pane fade" id="tab_presence_en">
								<div class="form-group">
									<label class="col-md-2 control-label">content</label>
									<div class="col-md-10">
										<textarea cols="60"  name="en_content_classroom" id="en_content_classroom"  class="form-control">{{$course_trans_en->content_classroom}} </textarea>
									</div>
								</div>
							</div>










						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">meta title</label>
							<div class="col-md-10">
								<input type="text"  name="en_meta_title" class="form-control maxlength-handler" maxlength="60"
									   value="{{$course_trans_en->meta_title}}">
								<span class="help-block"> maxlength 60 character</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">meta keyword</label>
							<div class="col-md-10">
								<input type="text" name="en_meta_keyword" class="form-control" data-role="tagsinput" value="{{$course_trans_en->meta_keyword}}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">meta description</label>
							<div class="col-md-10">
								<textarea cols="60"  name="en_meta_description"  class="form-control maxlength-handler" maxlength="160">{{$course_trans_en->meta_description}} </textarea>
								<span class="help-block"> maxlength 160 character </span>
							</div>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>
    
