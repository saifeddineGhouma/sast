@extends('admin/layouts/master')


@section('header_styles')	
	
@endsection

@section('content')

<!-- Main content -->
<section class="content-header">
    <h1>Not Authorized</h1>
    <ol class="breadcrumb">
        <li class="active">
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-color="#333" data-hovercolor="#333"></i> Dashboard
            </a>
        </li>
    </ol>
</section>



<!-- BEGIN CONTAINER -->
<section class="content">
    <div class="row">
        You aren't Authorized to Enter this Page
    </div>
</section>
@endsection

@section("footer_scripts")
 
@endsection
