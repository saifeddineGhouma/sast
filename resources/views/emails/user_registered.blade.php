@extends('emails/master')
@section('title')
	شكراً لتسجيلك
@stop

@section('content')
	<h2>شكرا لتسجيلك بالاكاديمية</h2>
	<div class="profile_writer">
		<div class="profile_img">
			<img src="{{asset('assets/front/img/email/post_profile.jpg')}}" alt="Profile Img">
		</div>
		<p class="profile_name"> {{ $user->full_name_ar }} </p>
		<p class="post_info">تم تسجيلك بنجاح</p>
		<img src="{{asset('assets/front/img/email/success.png')}}" alt="Success">
	</div>
	<div class="topic">

		<div class="topic_body2">

			<p class="topic_content">
				إحرص على تعبئة بيانات صحيحة في حسابك معنا لضمان تقديم خدمة افضل
			<ul>
				<li>تاكد من ادخال اسمك الصحيح بالعربي والانجليزي لانه سيتم طباعته على الشهادات</li>
				<li>تاكد من اضافة صورة من جواز سفرك/ هويتك كمرجع لاصدار الشهادة</li>
				<li>تاكد من ادخال عنوانك الصحيح</li>
				<li>راجع صفحة حسابي الخاصة بك ثم قم بتحديث بياناتك بشكل صحيح</li>
			</ul>
			</p>
		</div>
	</div>
	<a href="{{url(App('urlLang').'account')}}" class="visit">حسابي</a>

@stop

