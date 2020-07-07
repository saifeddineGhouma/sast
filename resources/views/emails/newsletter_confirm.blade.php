@extends('emails/master')
@section('title')
	النشرة الإخبارية
@stop
@section('content')

	<div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:left;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
         لقد قمت بطلب الاشتراك في النشرة البريدية لهذا البريد الالكتروني <b><a href="mailto:{{$email}}" target="_blank">{{$email}}</a></b><br> كوسيلة للاتصال بك، وحتى نتمكن من الحفاظ على خصوصيتك ولنتمكن من إتمام عملية التسجيل، نحتاج منك أن تقوم بالتأكيد على أنك تملك هذا البريد بالفعل ، ما عليك سوى الضغط على رابط تأكيد البريد الإلكتروني.
         <br> 
  		     <a href="{{url(App('urlLang').'newsletter-verification?mail='.$auth_key.'&&email='.$email)}}" style="background:#ea9b00;color:#fff;display:block;font-size:12px;font-weight:bold;min-height:24px;line-height:20px;padding-top:2px;text-align:center;text-decoration:none;width:130px" target="_blank" >أكد البريد الإلكتروني</a>
    </div>
	<div  style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
		 
	     <br>
		 اذا كنت تريد الاشتراك بالموقع كطالب برجاء زيارة صفحة التسجيل كطالب من خلال الرابط التالي :<br> https://swedish-academy.se/login
		  
	</div>
@stop