@extends('front/layouts/master')

@section('meta')
	<title> {{trans('home.mes_certificats')}} </title>
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
                            <span> {{trans('home.mes_certificats')}} </span>
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
                    <div class="row justify-content-between row-account">
                        <div class="table-responsive">
                            @if(!empty($studentCertificates))
                                <table class="table table_striped_col" id="order-table" >
                                    <thead>
                                    <tr>
                                        <th scope="col" class="head_col" style="text-align: {{$alignText}}" >{{trans('home.la_certif')}}</th>
                                        <th scope="col" class="head_col" style="text-align: {{$alignText}}" > {{trans('home.le_cours')}}</th>
                                      
                                        <th scope="col" class="head_col" style="text-align: {{$alignText}}" >{{trans('home.date_certif')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($studentCertificates as $studentCertificate) 
                                            <?php
                                                $course_name = $studentCertificate->course_name;
                                                if(!is_null($studentCertificate->course))
                                                    $course_name = $studentCertificate->course->course_trans(session()->get('locale'))->name;
                                                $exam_name = $studentCertificate->exam_name;
                                                if(!is_null($studentCertificate->exam))
                                                    $exam_name = $studentCertificate->exam->quiz_trans(session()->get('locale'))->name;
                                            ?>
                                             @if(in_array($studentCertificate->course_id, [496, 502]))
                                            
                                             @else
                                            <tr>
                                                <td>
                                                    <a href="{{ asset('uploads/kcfinder/upload/image/'.$studentCertificate->image) }}" target="_blank">
                                                        <img src="{{ asset('uploads/kcfinder/upload/image/'.$studentCertificate->image) }}" alt="no image" width="70px"/></a>
                                                </td>
                                                <td>
                                                    {{ $course_name }}
                                                </td>
                                            
                                                <td>{{ $studentCertificate->date }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                    
                                @else
                                    <p>لا يوجد شهادات </p>
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


