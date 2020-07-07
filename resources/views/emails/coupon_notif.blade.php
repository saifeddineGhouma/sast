@extends('emails/master')

@section('content')
<div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">

	مرحبا   {{$user_name}},
	<br>
	تبعا للتعديلات الجديدة التي حصلت في نظام الأكاديمية و بما أنكم سبق و درستم المستويات الثلاث الأولى من دورة المدرب الشخصي 
	<br>
	نود اعلامكم أننا قررنا منحكم كوبون تخفيضي بقيمة 150 دولار صالح لمدة سنة واحدة ابتداءا  من اليوم يمكنكم استعماله في أي دورة من دوراتنا الأون لاين.
	كود الكوبون  <b> "{{$coupon_code}}" </b>
	<br>
	 مع تمنياتنا لكم بكامل التوفيق و النجاح
</div>
@stop