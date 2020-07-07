@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.books_compte')}}</title>
@stop
@section("styles")

@stop

@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp 

@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:{{ $dir }}" >
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account') }}">{{trans('home.mon_compte_header')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.books_compte')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container" style="direction:{{ $dir }}" >
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between">
                        <div class="table-responsive" style="text-align: justify">
                            @if(!$books->isEmpty())
                                <table class="table table_striped_col" id="order-table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="head_col" style="text-align: {{$alignText}}"></th>
                                        <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.nom_livre')}}</th>
                                        <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.short_description')}}</th>
                                        <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.operation')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($books as $book)
                                        <?php
                                            $book_trans = $book->book_trans(Session()->get('locale'));
                                            if(empty($book_trans))
                                                $book_trans = $book->book_trans('ar');
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="{{ asset('uploads/kcfinder/upload/image/'.$book->image) }}" alt="no image" width="70px"/>
                                            </td>
                                            <td>
                                                {{ $book_trans->name }}
                                            </td>
                                            <td>
                                                {{ $book_trans->short_description }}
                                            </td>
                                            <td>
                                                <a href="https://swedish-academy.se/telecharge.php?pdf={{$book->pdf_book}}">{{trans('home.download_livre')}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>{{trans('home.no_books')}} </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    @include("front.account.js.active_link_js")
@stop


