@extends('teachers/layouts/master')

@section('title')
	View {{ $course->course_trans("ar")->name }}
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
  	<link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/vendors/x-editable/css/bootstrap-editable.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/pages/user_profile.css')}}" rel="stylesheet" type="text/css"/>
@endsection
                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>View Course: {{ $course->course_trans("ar")->name }} </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/teachers/courses')}}">courses</a>
        </li>       
        <li class="active">View Course: {{ $course->course_trans("ar")->name }}</li>
    </ol>
</section>

<div class="panel panel-primary filterable portlet box">
    <div class="panel-heading clearfix">
        <div class="panel-title pull-left">
            <div class="caption">
                <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                View Course: {{ $course->course_trans("ar")->name }}
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <br/>
                    <div class="col-md-6">
                        <div class="col-md-4">
                            thumb
                        </div>
                        <div class="col-md-8">
                            @if(!empty($course->image))
                                <img src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" style="width:60px;"/>
                            @else
                                no thumbnail
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-4">
                            name
                        </div>
                        <div class="col-md-8">
                            {{ $course->course_trans("ar")->name}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-4">
                            type
                        </div>
                        <div class="col-md-8">
                            {{ $courseTypeVariation->courseType->type }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-4">
                            period
                        </div>
                        <div class="col-md-8">
                            {{ $course->period }}
                        </div>
                    </div>
                </div>
                @if($courseTypeVariation->courseType->type == "presence")
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-4">
                                country
                            </div>
                            <div class="col-md-8">
                                @if(!empty($courseTypeVariation->government))
                                    <?php
                                    $currentCountry = $courseTypeVariation->government->country;
                                    ?>
                                    {{$currentCountry->country_trans("en")->name}}-
                                    {{$courseTypeVariation->government->government_trans("en")->name}}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-4">
                                date range
                            </div>
                            <div class="col-md-8">
                                {{ $courseTypeVariation->date_from }} to {{ $courseTypeVariation->date_to }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-4">
                            certificate
                        </div>
                        <div class="col-md-8">
                            {{ $courseTypeVariation->certificate->name_ar }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-8">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="form-section">Students</h3>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>image</th>
                        <th>name ar</th>
                        <th>name en</th>
                        <th>username</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseTypeVariation->students() as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>
                                @if(!empty($student->user->image))
                                    <img src="{{asset('/uploads/users/'.$student->user->image)}}" style="width:50px;"/>
                                @else
                                    no image
                                @endif
                            </td>
                            <td>
                                {{ $student->user->full_name_ar }}
                            </td>
                            <td>{{ $student->user->full_name_en }}</td>
                            <td>{{ $student->user->username }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>




@endsection    
@section("footer_scripts")	
<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	<script  src="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/x-editable/jquery.mockjax.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/vendors/x-editable/bootstrap-editable.js')}}" type="text/javascript"></script>
  

@endsection
