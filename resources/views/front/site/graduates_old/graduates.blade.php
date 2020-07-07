@extends('front/layouts/master')

@section('meta')
	<title>الخريجون</title>

@stop

@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>الخريجون</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container padding-50">
        <div class="well table-toolbar">
            <form id="search_form" name="search_form" method="get">
                <input type="hidden" name="start" value="0"/>
                <input type="hidden" name="length" value="40"/>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label bold"> السنة</label>
                            <select id="year" name="year" class="form-control">
                                @for($i=$currentYear;$i>=2015;$i--)
                                    <option value="{{$i}}" {{($i==$currentYear)?'selected':null}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label class="control-label bold">الدورات</label>
                            <select name="course_id" id="course_id" class="form-control" >
                                <option value="0">اختر الدورة</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}">{{$course->course_trans(App("lang"))->name or null}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" id="filterBtn" class="btn green demo-loading-btn col-md-6" style="margin-top: 50px;" data-loading-text="<li class='fa fa-search'></li> searching...">
                            <li class="fa fa-search"></li> بحث
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="row">
            <div class="col-md-12" id="graduates_content">
            </div>
        </div>
    </div>


@stop

@section('scripts')

    @include("front.site.js.graduates_js")
@stop


