<div class="col-lg-12 course_discussion courses_more_info_content">
    <div class="content_header_one">
        <p style="text-align: {{ $textalign }}">@lang('navbar.disscussion')</p>
        
    </div>
    <div id="accordion" style="text-align: {{ $textalign }}">
        @foreach($courseQuestions as $courseQuestion)
            <div class="card discussion_card card_deactive">
                <div class="card-header row" id="heading_{{$courseQuestion->id}}" style="background: #d9e8da !important;">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsereply_{{$courseQuestion->id}}" aria-expanded="true" aria-controls="collapse_{{$courseQuestion->id}}">
                        <div class="col-2 header_img">
                            <h5 class="mb-0">
                                <div class="link_img">
                                    @if(!empty($courseQuestion->user))
                                        <img src="{{ asset("uploads/kcfinder/upload/image/users/".$courseQuestion->user->image) }}" >
                                    @else
                                        <img src="{{asset('assets/front/img/user1.jpg')}}" >
                                    @endif
                                </div>
                            </h5>
                        </div>
                        <div class="col-9 header_content">
                            @if(!empty($courseQuestion->user))
                                <span class="header_content_name">{{ $courseQuestion->user->username }}</span>
                            @else
                                <span class="header_content_name">أدمين</span>
                            @endif
                            <span class="header_content_date">{{ date("Y-m-d",strtotime($courseQuestion->created_at)) }}</span>
                            <p>{!! $courseQuestion->discussion !!}</p>
                        </div>
                        <div class="col-1 header_col">
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                            <i class="fa fa-angle-up" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
                <div id="collapsereply_{{$courseQuestion->id}}" class="collapse" aria-labelledby="heading_{{$courseQuestion->id}}" data-parent="#accordion">
                    @foreach($courseQuestion->replies()->where('active',1)->get() as $reply)
                        @if(!$loop->first)
                            <div class="line_spetare"></div>
                        @endif
						@if(!empty($reply->user) and !empty($reply->type))
							<div class="card-body" style="background: #fff0b5 !important;">
						@elseif(!empty($reply->user) and empty($reply->type))
							<div class="card-body" style="background: #d9e8da !important;">
						@else
							<?php
								if(!empty($reply->admin_id)){
									$admin_idd = $reply->admin_id;
									$role = DB::table('role_admin')
											->join('roles', 'role_admin.role_id', '=', 'roles.id')
											->where('admin_id', $admin_idd)->first();
							?>
								<div class="card-body" style="background: #f9e0df !important;">
							<?php }else{ ?>
								<div class="card-body" style="background: #c8e1f5 !important;">
							<?php } ?>
						@endif
                            <div class="col-2 body_img">
                                <h5 class="mb-0">
                                    <div class="link_img">
                                        @if(!empty($reply->user))
                                            <img src="{{ asset("uploads/kcfinder/upload/image/users/".$reply->user->image) }}" style="top: -27px;left: 90%;">
                                        @else
                                            <img src="{{asset('assets/front/img/discussion_link_img_2.png')}}" style="top: -27px;left: 90%;">
                                        @endif
                                    </div>
                                </h5>
                            </div>
                            <div class="col-10 body_content">
                                <span class="body_content_name">
                                    @if(!empty($reply->user))
                                        {{ $reply->user->username}}
                                    @else
										<?php
											if(!empty($reply->admin_id)){
												$admin_idd = $reply->admin_id;
												$role = DB::table('role_admin')
														->join('roles', 'role_admin.role_id', '=', 'roles.id')
														->where('admin_id', $admin_idd)->first();
												if($role->name=="Super admin"){
													echo __('navbar.directeur');
												}else{
													echo __('navbar.admin');
												}
											}else{
												echo __('navbar.admin');
											}
										?>
                                    @endif
                                </span>
                                <p>{!! $reply->discussion !!}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="card-body row">
                        <div class="col-10 body_content">
                            @if(Auth::check())
                                <form method="post" class="reply-form" action='{{url(App("urlLang")."courses/save-reply/".$courseQuestion->id)}}'>
                                    <div class="reply-message"></div>
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <textarea class="add_comment" name="discussion" placeholder="@lang('navbar.addcomment')"></textarea>
                                    </div>

                                    <button type="submit" class="insert_comment">اضف</button>
                                </form>
                            @else
                                <a href="{{ url(App('urlLang').'login') }}" class="btn">@lang('navbar.loginToComment')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
            <div class="card-body row">
                <div class="col-10 body_content">
                    @if(Auth::check())
                        <form method="post" class="reply-form" action='{{url(App("urlLang")."courses/save-reply/".$course->id)}}'>
                            <div class="reply-message"></div>
                            {!! csrf_field() !!}
                            <input type="hidden" name="quistionType" value="course"/>
                            <div class="form-group">
                            <textarea class="add_comment" name="discussion" placeholder="@lang('navbar.addcomment')"></textarea>
                            </div>

                            <button type="submit" class="insert_comment">@lang('navbar.add')</button>
                        </form>
                    @else
                        <a href="{{ url(App('urlLang').'login') }}" class="btn">@lang('navbar.loginToComment')</a>
                    @endif
                </div>
            </div>
    </div>
</div>