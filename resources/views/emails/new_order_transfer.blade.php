@extends('emails/master')

@section('content')
	<div style="line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px">
		@if(empty($provider))
			A payment has been processed on cash or bank transfer. please check it in your control panel
		@else
			An order via {{ $provider }} has been paid (ref : {{ $ref }})
		@endif
    </div>
    </div>
	  <br><br>
	</div>
@stop      