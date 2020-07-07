@extends('emails/master')

@section('content')
     <div  style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
	 <div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;">
	مرحبا {{$name}}, <br/>
	سيتم إبلاغك عبر الايميل لأي تحديثات جديدة تتم على هذا الطلب  
	<br>

	</div>
	
	<br>
	  <div  style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;">
        <b>لديك سؤال؟</b>
        لا تتردد فقط <a style="color:#31b7e9;text-decoration:underline" href="mailto:{{App('setting')->email}}" target="_blank"> إتصل بنا </a> في أقرب وقت
    </div>
	  <br><br>
	</div>
@stop    