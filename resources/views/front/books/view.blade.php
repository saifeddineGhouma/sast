@extends('front/layouts/master')

@section('meta')
    <title>{{!empty($book_trans->meta_title)?$book_trans->meta_title:$book_trans->name}}</title>
    <meta name="keywords" content="{{$book_trans->meta_keyword}} " />
    <meta name="description" content="{{$book_trans->meta_description}} ">
@stop

@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp

@section('content')
    <!-- Start book -->
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:{{ $dir }}">
                <img class="align-self-center ml-3" src="{{asset('uploads/kcfinder/upload/image/'.$book->image)}}" alt="{{ $book_trans->name }}">
                <div class="media-body align-self-center">
                    <a href="#" onclick="return false;" class="training_link" style="display: flex;">{{ $book_trans->name }}</a>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url(App('urlLang').'books') }}"> {{trans('home.books_compte')}}</a> 
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <span>{{ $book_trans->name }}</span>
                            </li>
                        </ol>
                    </nav>

                </div>
 
            </div>
        </div>  
    </div>
    <!-- End book -->
    @include('common.errors')

    <div class="book-body text-center">
        <div class="container">
            <div class="row book-intro"> 
                <div class="col-md-6 book-details">
                    <h3>{{ $book_trans->name }}</h3>
                    <p>{{ $book_trans->short_description }}</p>
                    <div class="row book-price">
 
                        <div class="col-6">
                            @if($book->price>0)  
                                <div class="book_info">
                                    @if(!$isPaid)
                                        <form id="cart-form" class="search_form incourse" method="post" action="{{ url(App('urlLang').'cart/add-to-cart') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <p>
                                                <button type="submit" class="buy_book_now"> إضافة إلى السلة</button>
                                            </p>
                                        </form>
                                    @else
                                        <div class="alert alert-success alertweb"><i class="fa fa-exclamation-circle"></i>
                                        <p>
                                            {{-- <form > lehnaaa   --}}
                                            <strong> لقد تم دفع ثمن الكتاب بنجاح </strong>
                                            {{-- {{ url(App('urlLang').'books/download/'.$book->id) }} 
                                            {{route('getDownload', $book->id)}}--}}
                                            {{-- "https://swedish-academy.se/telecharge.php?pdf={{$book->pdf_book}}" --}}
                                            </form>
                                        </p>
                                        </div>
                                    @endif
                                    <a href="/uploads/kcfinder/upload/file/{{ $book->pdf_book_summary }}" target="_blank">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        <p>تحميل الملخص</p>
                                    </a> 
                                    @if(!$isPaid)
                                        <span>$ {{ $book->price+App('setting')->vat*$book->price/100 }}</span>
                                    @else
                                        <a href="/uploads/kcfinder/upload/file/{{$book->pdf_book}}" target="_blank">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;"></i>
                                            <p>تحميل الكتاب</p>
                                        </a> 
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="col-6">
                            @if($book->indicative_price>0)
                                <div class="book_info">
                                    <p><a href="{{ $book->buy_link }}" target="_blank" class="buy_book_now">اشتري الأن</a></p>
                                    <i class="fa fa-book" aria-hidden="true"></i>
                                    <p>النسخة الورقية</p>
                                    <span>{{ $book->indicative_price }} $</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="meta-price media-body align-self-center">
                                @if($book->points >0&&!($book->indicative_price>0))
                                    <span class="points-on-course"><span><i class="fa fa-gift"></i> {{ $book->points }} نقطة مجانية على هذا الكتاب</span>
                                    <i class="repls">يمكنك إستبدال النقاط المجمعة والحصول على كوبون خصم</i>
                                    <a href="" target="_blank">تعرف على برنامج النقاط والمكافئات</a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 book-images">
                    <img src="{{asset('uploads/kcfinder/upload/image/'.$book->image)}}"/>
                </div>
            </div>

            <div class="courses_more_info">
                <div class="row more_info_one justify-content-between">
                    <div class="col-lg-12 courses_more_info_content">
                        <div class="content_header_one">
                            <p>{{ $book_trans->name }}</p>
                        </div>
                        {!! $book_trans->content !!}
                    </div>


                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

@stop


