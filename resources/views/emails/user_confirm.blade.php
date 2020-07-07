@extends('emails/master')
@section('title')
	Email Activate
@stop

@section('content')
	<h2>
		لإستكمال تسجيلك برجاء تفعيل بريدك الالكتروني
	</h2>
	<div class="lock">
		<img src="{{asset('assets/front/img/email/email_active.png')}}" alt="Pass Lock">
		<p class="notestxt"> يرجى الضغط على الرابط التالي لتفعيل بريدك الالكتروني</p>
	</div>
	<a href="{{url(App('urlLang').'user-verification?mail='.$user->auth_key.'&&email='.$user->email)}}" class="reset_pass">اضغط هنا لتفعيل حسابك</a>
	<p class="message_error">( تفعيل الايميل مهم للتاكد من انك صاحب الحساب وسيتم مراسلتك عبره )</p>

@stop

