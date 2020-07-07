@extends('emails/master')

@section('content')
	<div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:center;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
      <span style="font-size:35px; color:#31b7e9 ;"> شكرا للدفع </span><br> <b> تم دفع هذه القيمة من أجل
      	@if (is_null($record->group_id))
      		طلب 
      	@else
      		باقة
      	@endif
      	 #</b> : <span style="color:#31b7e9;border-bottom:1px dotted #eee" >{{$record->id}}</span>
   
   </div>
   <div  style="font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
        <div style="background:#dcdcdc;width:100%;height:1px;display:block"></div>
    </div>
   <div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
     <b>رقم عملية الدفع </b> : <span style="color:#31b7e9;border-bottom:1px dotted #eee" >{{$record->reference}}</span><br>
	 <b>إجمالي المبلغ المدفوع :</b> 
	 <span style="color:#31b7e9;border-bottom:1px dotted #eee" >{{$record->total}} KWD</span> <br>
	 
   <b>Payment Method : </b>
	 <span style="color:#31b7e9;border-bottom:1px dotted #eee" >{{$record->payment_method}}</span>
   </div>
	<div  style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
	 <div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;">
	برجاء الدخول الى حسابك لمشاهدة التفاصيل
	</div>
	<br>
	<div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;">
            <a href=""  style="color:#fff;text-decoration:none;width:100%;font-family:arial;font-weight:700;text-align:center;border-radius:3px;display:inline-block;padding:12px 0;max-width:80%;min-width:180px;background:#31b7e9; margin:0 10%;" target="_blank"> دخول</a>
	</div>
     <br>
	 
	  <div  style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;">
        <b>لديك سؤال؟</b>
        لا تتردد فقط <a style="color:#31b7e9;text-decoration:underline" href="mailto:{{App('setting')->email}}" target="_blank"> إتصل بنا </a> في أقرب وقت
    </div>
	  <br><br>
	</div>
	
@stop