@extends('front/layouts/master')

@section('meta')
    <?php
    $setting = App("setting");
    $setting_trans = $setting->settings_trans(session()->get('locale'));
    if(empty($setting_trans))
        $setting_trans = $setting->settings_trans('en');
    ?>
    <title>{{$type_news}}</title>
    <meta name="keywords" content="{{$setting_trans->meta_keyword}}" />
    <meta name="description" content="{{$setting_trans->meta_description}}">
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
                        <li class="breadcrumb-item active" aria-current="page">
                          
                          <span>{{$type_news}} </span>
 
                        </li>
                    </ol> 
                </nav> 
            </div>
        </div> 
    <!--  -->
    </div> 

    <div class="container container-blog">
        @php  $textalign= session()->get('locale') === "ar" ? "right" : "left";
        $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ;
        $float= session()->get('locale') === "ar" ? "left" : "right";
         @endphp

        <div class="row">
            <p>
				@if ($code_img === '1')
					<img src="https://swedish-academy.se/assets/front/img/Article.png" alt="" width="100%">
				@else
					<img src="https://swedish-academy.se/assets/front/img/News.jpg" alt="" width="100%">
				@endif
            </p>  
        </div>
        @foreach($newsData as $news)
            <div class="row row-blog" style="direction:{{$dir}}">
                <div class="col-md-4">
                    <img src="{{asset('uploads/kcfinder/upload/image/'.$news->thumbnail)}}" class="img-blog"  style="height: 15em" />
                </div>
                <div class="col-md-8">
                <div class="title-blog" style = "direction: {{ session()->get('locale') === 'ar' ? 'rtl' : 'ltr' }}">
                    <a href="{{url(App('urlLang').'publication/'.$news->type.'/'.$news->news_trans(session()->get('locale'))->slug)}}"> <h3 style="text-align: {{$textalign}}">{{$news->news_trans(session()->get('locale'))->title}}</h3> </a>
                    </div>
                    <div class="calendar" style="text-align: {{$textalign}}" ><i class="fa fa-calendar"></i>  {{ date("Y-m-d",strtotime($news->created_at)) }}</div>
                    
                    <p style="text-align: {{$textalign}};direction: {{$dir}}">{{ $news->news_trans(session()->get('locale'))->short_description }}</p>
                    <a  href="{{url(App('urlLang').'publication/'.$news->type.'/'.$news->news_trans(Session::get('locale'))->slug)}}" class="view_more" style="height: inherit;float: {{$float}};margin-top:10%">@lang('academy.more')</a>
                </div>
            </div>
        @endforeach
        {{ $newsData->links() }}
 
    </div> 

@stop 

@section('scripts')

@stop


