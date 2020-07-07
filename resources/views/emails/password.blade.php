@extends('emails/master')
@section('title')
	Password
@stop
@section('content')
    <?php
    $segment1 = app()['request']->segment(1);
    if($segment1 == "admin")
        $link = url('admin/password/reset', $token);
    else {
        $link = url('password/reset', $token);
    }
    ?>
	<h2>
		قام شخص ما بارسال طلب استعادة كلمة المرور
	</h2>
	<div class="lock">
		<img src="{{asset('assets/front/img/email/pass_lock.png')}}" alt="Pass Lock">
		<p class="notestxt"> يرجى الضغط على الرابط التالي لادخال كلمة مرور جديدة</p>
	</div>
	<a href="{{ $link }}" class="reset_pass" target="_blank">استعادة كلمة المرور</a>
	<p class="message_error">( اذا كنت لم تطلب استعادة كلمة المرور فبرجاء اهمال هذه الرسالة ولن يتم تغير كلمة المرور )</p>

@stop