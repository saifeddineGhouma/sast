<div class="col-lg-12 course_teacher courses_more_info_content">
    <div class="content_header_one">
        <p style="text-align: {{ $textalign }}">@lang('navbar.Coachs')</p>
    </div>
    <div class="company_courses ">
        <div class="row" style="direction: {{ $dir }}">
            @foreach($courseType->couseType_variations as $courseTypeVariation)
                <?php
                    $teacher_trans = $courseTypeVariation->teacher->teacher_trans(session()->get('locale'));
                    if(empty($teacher_trans))
                        $teacher_trans = $courseTypeVariation->teacher->teacher_trans('ar');
                ?>
                <div class="col-lg-4 col-md-4 zoom">
                    <div class="card card_style_one">
                        <img class="card-img-top" src="{{asset('uploads/kcfinder/upload/image/users/'.$courseTypeVariation->teacher->user->image)}}" alt="Card image cap">
                        <div class="card-body ">
                            <h5 class="card-title">
                                <a href="#" onclick="return false;">{{ $courseTypeVariation->teacher->user->{'full_name_'.session()->get('locale')} }}</a>
                            </h5>
                            <p class="card-text">{{ $teacher_trans->job }}</p>

                            @foreach($courseTypeVariation->teacher->socials as $social)
                                <a href="{{ $social->link }}" target="_blank"><i class="{{$social->font}}" aria-hidden="true"></i></a>
                            @endforeach
                            <div class="more_info">
                                <p>{{ $teacher_trans->about }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div> 