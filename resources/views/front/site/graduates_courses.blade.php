@extends('front/layouts/master')

@section('meta')
    <title>@lang('navbar.certifiated')</title>

@stop

@section('content')
    @php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
    @php $textalign = session()->get('locale') === "ar" ? "rtl" : "left" @endphp
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction : {{ $dir }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>@lang('navbar.gratuated')</span> <span>({{ $year }})</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="container padding-50" dir="{{ $dir }}">
    <h2 style="text-align:{{ $textalign }}"><span>@lang('navbar.gratuated')</span> <span>({{ $year }})</span></h2>
         <form  id="info_form" method="get" action="{{ url(App('urlLang').'graduates') }}" enctype="multipart/form-data" autocomplete="on" >
            @if(session()->get('locale') === "ar")

            <div class="col-xs-12 userlogedin text-right">
                <div class="col-md-8">
                    <div class="form-group autocomplete"  >
                        <input type="text" placeholder="@lang('navbar.searchByNameOrCertificat')" class="form-control search-name"  id="myInput" name="code"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="submit" class="btn btn-md btn-success svme" value="@lang('navbar.search')">
                    </div>
                </div>
            </div>
            @else
            <div class="col-xs-12 userlogedin text-right">
                <div class="col-md-4">
                        <div class="form-group">
                            <input type="submit" class="btn btn-md btn-success svme" value="@lang('navbar.search')">
                        </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group autocomplete"  >
                        <input type="text" placeholder="@lang('navbar.searchByNameOrCertificat')" class="form-control search-name"  id="myInput" name="code"/>
                    </div>
                </div>

            </div>



            @endif
        </form>
        @if(!$courses->isEmpty())
            <table class="table">
                <thead>
                <tr>
                <th width="10%" style="text-align: {{ $textalign }}">#</th>
                <th style="text-align: {{ $textalign }}"> @lang('navbar.session') </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <?php
                            $name="";
                            if(isset($course->course_trans(session()->get('locale'))->name))
                                $name = $course->course_trans(session()->get('locale'))->name;
                            else {
                                $name = $course->course_trans("ar")->name;
                            }
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }} </td>
                            <td> <a href="{{ url(App('urlLang').'graduates?year='.$year.'&course_id='.$course->id) }}">{{$name}}</a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>


@stop

@section('scripts')


@stop


