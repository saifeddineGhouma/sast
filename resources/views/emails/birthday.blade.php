@extends('emails/master')
@section('title')
	النشرة الإخبارية
@stop
@section('content')
	<br><br> 
	{{$name}},أسرة الأكادمية السويدية للتدريب الرياضي تتمنى لكم عيد ميلاد سعيد و عمر مديد وموفور الصحة 
	<br>
	{{$name}}, Swedish Academy of Sports Training wishes you a happy birthday and a long life  !

	بهاته المناسبة السعيدة تهدي لك الأكاديمية كوبون تخفيضي بقيمة 30 دولار على أي دورة أو كتاب على موقع الأكاديمية
	<br>
   كود الكوبون     :  {{$coupon_code}}
@stop