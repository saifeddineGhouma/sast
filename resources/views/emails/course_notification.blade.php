@extends('emails/master')
@section('title')
	النشرة الإخبارية
@stop
@section('content')
	<br><br>
	Hello {{$username}}, <br/>
	Your course {{$courseName}} ends in {{$days}} day(s) so be sure to finish all your exams before this date.
@stop