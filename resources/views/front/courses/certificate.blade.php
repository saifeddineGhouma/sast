@extends('front/layouts/master')

@section('meta')
	<title>شهادة {{ $student_name }}</title>
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
                        <li class="breadcrumb-item">
                            <a href="#" onclick="return false;">  certificates</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>شهادة {{ $student_name }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container padding-50">
        <div class="row">
            <div class="col-md-6" style="margin: auto">

                <ul class="profile">
                    <li>    <label class="col-md-6">الدورة :</label>   {{ $course_name }}    </li>
                    <li>    <label class="col-md-6"> أصدار الشهادة :</label>  {{ $studentCertificate->date }}  </li>
                    <li>    <label class="col-md-6"> الاسم  :</label>       {{ $student_name }}   </li>
                    @if(!empty($studentCertificate->student)&&!empty($studentCertificate->student->user))
                        @if(!empty($studentCertificate->student->user->government))
                            <li><label class="col-md-6">البلد :</label> {{ $studentCertificate->student->user->government->country->country_trans("en")->name }}  </li>
                        @endif
                        <li>    <label class="col-md-6">الجنس :</label> {{ $studentCertificate->student->user->gender }} <i class="fa fa-venus" aria-hidden="true"></i> </li>
                    @endif
                    <li>    <label class="col-md-6">المدرب :</label>   {{ $studentCertificate->teacher_name }}    </li>
                </ul>

            </div>
        </div>
    </div> 


@stop

@section('scripts')

@stop


