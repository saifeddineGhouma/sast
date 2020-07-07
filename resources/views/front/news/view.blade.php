@extends('front/layouts/master')

@section('meta')
    <title>{{$news_trans->title}}</title>
    <meta name="keywords" content="{{$news_trans->meta_keyword}}" />
    <meta name="description" content="{{$news_trans->meta_description}}">
@stop

@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction : {{ session()->get('locale') === 'ar' ? 'rtl' : 'ltr' }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                             <!-- <span>الأخبار</span>  -->
                          <span>{{$type_news}} </span> 

                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{$news_trans->title}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div> 

 <!--    <div class="blog-head">
        <h2>أخبارنا</h2>
        <img src="{{asset('assets/front/imgimg/line_copy_w.png')}}"/>
    </div> -->

    <div class="container">

    <div class="row row-single-blog">
        <div class="col-md-12">

            <div class="title-blog" style = "direction: {{ session()->get('locale') === 'ar' ? 'rtl' : 'ltr' }}">
                <h3>{{$news_trans->title}}</h3>
            </div>
            <img src="{{asset('uploads/kcfinder/upload/image/'.$news->image)}}" class="img-blog"/>

            <div class="calendar"><i class="fa fa-calendar"></i> {{date("Y-m-d",strtotime($news->created_at))}}</div>
            {!! $news_trans->content !!}
        </div>
    </div>

    </div>

@stop

@section('scripts')

@stop


