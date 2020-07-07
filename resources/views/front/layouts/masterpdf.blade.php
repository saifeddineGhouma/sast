<!DOCTYPE html>
<html lang="ar-sa">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!------------->
	<link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/front/img/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/front/img/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/front/img/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/front/img/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/front/img/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/front/img/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/front/img/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/front/img/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/front/img/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('assets/front/img/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/front/img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/front/img/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/front/img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/front/img/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('assets/front/img/favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">

	<!--------------->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/swiper.min.css')}}">

	@yield("styles")
	<style>
		.display-none{display:none;}
		#fc_widget{margin-top: 0px !important;}

	</style>
	
</head>

<body>
	
	
	@yield("content")

	
	<script src="{{asset('assets/front/js/jquery.js')}}"></script>
	<script src="{{asset('assets/front/js/jquery-ui.min.js')}}"></script>
	<script src="{{asset('assets/front/js/popper.min.js')}}"></script>
	<script src="{{asset('assets/front/js/bootstrap.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/front/js/swiper.min.js')}}"></script>
	<script src="{{asset('assets/front/js/script.js')}}"></script>
	@include("front.layouts.js._newsletter_js")
	@yield("scripts")
</body>
</html>	