@extends('emails/master')

@section('content')
	<div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
      الاسم: {{$name}}<br/>
		الايميل: {{$email}}<br/>
		الموبايل: {{ $mobile }}<br/>
		الرسالة: {{$message1}}

    </div>
@stop


