@extends('emails/master')

@section('content')
	User {{ $name }} has commented :<br/> {{ $comment }} <br/> on {{ $courseName }} 
@stop


