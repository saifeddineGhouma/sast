@extends('front/layouts/master')

@section('meta')
	<title>@lang('navbar.certificat') {{ $student_name }}</title>
@stop

@section('content')
    @php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
    @php $textalign = session()->get('locale') === "ar" ? "right" : "left" @endphp
    <div class="training_purchasing" >
        <div class="container training_container">
            <div class="media" style="direction : {{ $dir }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" onclick="return false;">  certificates</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>@lang('navbar.certificat') {{ $student_name }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container padding-50" >
        <div class="row" >
            <div class="col-md-6" style="margin: auto">
                @if(session()->get('locale') === "ar" )

                <ul class="profile" style="text-align : {{ $textalign }}">
                    <li >    <label class="col-md-6">  @lang('navbar.session') :</label>   {{ $course_name }}    </li>
                    <li>    <label class="col-md-6"> @lang('navbar.licencedate') :</label>  {{ $studentCertificate->date }}  </li>
                    <li>    <label class="col-md-6"> @lang('navbar.nom')  :</label>       {{ $student_name }}   </li>
                    @if(!empty($studentCertificate->student)&&!empty($studentCertificate->student->user))
                        
                        <li>    <label class="col-md-6">@lang('navbar.sexe') :</label> {{ $studentCertificate->student->user->gender }} <i class="fa fa-venus" aria-hidden="true"></i> </li>
                    @endif
                    <li>    <label class="col-md-6">@lang('navbar.coach') :</label>   {{ $studentCertificate->teacher_name }}    </li>
                </ul>
                @else 
                <ul class="profile" style="text-align : {{ $textalign }}">
                        <li style="direction : {{ $dir }}">    <label class="col-md-6 pull-left">  @lang('navbar.session') :</label>   {{ $course_name }}    </li>
                        <li style="direction : {{ $dir }}">    <label class="col-md-6 pull-left"> @lang('navbar.licencedate') :</label>  {{ $studentCertificate->date }}  </li>
                        <li style="direction : {{ $dir }}">    <label class="col-md-6 pull-left"> @lang('navbar.nom')  :</label>       {{ $student_name }}   </li>
                        @if(!empty($studentCertificate->student)&&!empty($studentCertificate->student->user))
                            
                            <li style="direction : {{ $dir }}">    <label class="col-md-6 pull-left">@lang('navbar.sexe') :</label> {{ $studentCertificate->student->user->gender }} <i class="fa fa-venus" aria-hidden="true"></i> </li>
                        @endif
                        <li style="direction : {{ $dir }}">    <label class="col-md-6 pull-left">@lang('navbar.coach') :</label>   {{ $studentCertificate->teacher_name }}    </li>
                    </ul>
                @endif



            </div>
        </div>
    </div>


@stop

@section('scripts')

@stop


