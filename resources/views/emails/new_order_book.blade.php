@extends('emails/master')

@section('content')
	<div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
		,{{$name}} مرحبا<br/>
        نرحب بكم في الاكاديمية السويدية للتدريب الرياضي ونعلمكم ان طلبك بالرقم <b style="color:#31b7e9;border-bottom:1px dotted #eee" >{{$orderId}}</b>
        <span style="margin:0px 7px;">تم بنجاح     </span>
    </div>
	{{-- <table class="table table-striped table-bordered table-condensed">
		@include("admin.orders._products",array("method"=>"account"))
	</table> --}}
	<div  style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
	 <div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;">
	
	<br>
	<strong>

    يمكنك تحميل الكتاب   <a href="https://www.swedish-academy.se/uploads/kcfinder/upload/file/{{$pdf_book}}" style ='color: red;'> من هنا </a><br>
   </strong>
	</div>
	
	<br>
	  <div  style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;">
        <b>لديك سؤال؟</b>
        لا تتردد فقط <a style="color:#31b7e9;text-decoration:underline" href="mailto:{{App('setting')->email}}" target="_blank"> إتصل بنا </a> 
   <br/>
   حظا موفقا
    </div>
	  <br><br>
	</div>
@stop      