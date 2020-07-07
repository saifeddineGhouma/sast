@extends('admin/layouts/master')



@section('title')

	Edit Publication

@endsection



@section("header_styles")

<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">

 <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />



@endsection



@section('content')



<!-- Content Header (Page header) -->

<section class="content-header">

    <!--section starts-->

    <h1>Edit {{$news->type}} {{$news->news_trans("ar")->name}}</h1>

    <ol class="breadcrumb">

        <li>

            <a href="{{url('/admin')}}">

                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>

                Dashboard

            </a>

        </li>

        <li class="active">publications</li>

    </ol>

</section>

<!--section ends-->

<section class="content">

    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-primary filterable portlet box">

            	 <div class="panel-heading clearfix">

	                    <div class="panel-title pull-left">

                           <div class="caption">

		                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>

		                        Edit {{$news->type}} {{$news->news_trans("en")->name}}

		                    </div>

	                    </div>

	                </div>

          		

                <div class="panel-body">

                	@if(Session::has('news_updated'))

				        <div class="alert alert-success">

				            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

				            {{ Session::get('news_updated') }}

				        </div>

				    @endif

				    @if (count($errors) > 0)

	                <div class="alert alert-danger">

	                    <ul>

	                        @foreach ($errors->all() as $error)

	                        <li>{{ $error }}</li>

	                        @endforeach

	                    </ul>

	                </div>

	                @endif

	                @include("admin.news._form",array("method"=>"edit"))

                </div>

           </div>

	    </div>

	</div>

</section>

 

@endsection



@section("footer_scripts")

<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>





<script src="{{asset('assets/admin/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>

<script  src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>

<script  src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>

<script  src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>

	

<script src="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/admin/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>

@include("admin.news.js.form_js")

@endsection

