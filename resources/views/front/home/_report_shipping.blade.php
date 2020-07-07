<div class="panel-body" style="margin-top: 20px;">
	<div class="col-xs-6 text-left">
		<h1>INVOICE</h1>
		<h1><small>Order #{{$order->id}}</small></h1>
	</div>
	<div class="col-xs-6 text-right">
		<h1>
			<img src="{{asset('uploads/kcfinder/upload/image/'.App('setting')->settings_trans("en")->logo)}}" style="width:75px">
				{{ App('setting')->settings_trans("en")->site_name }}
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-5">
		<div class="panel panel-default">
			<div class="panel-heading">
			    <h4>From: {{ App('setting')->settings_trans("en")->site_name }}</h4>
			</div>
			<div class="panel-body">
				<b>mobile:</b> {{ App('setting')->mobile }}<br />
                <b>email:</b> {{ App('setting')->email }}
			</div>
		</div>
	</div>
    <div class="col-xs-5 col-xs-offset-2 text-right">
      <div class="panel panel-default">
              <div class="panel-heading">
                <h4>To : {{$order->user->full_name_ar}}</h4>
              </div>
              <div class="panel-body">
				 phone: {{$order->user->phone}}<br />
				  mobile number : {{$order->user->mobile}}
                </p>
              </div>
            </div>
    </div>
</div> <!-- / end client details section -->

<table class="table table-bordered">
	@include("front.home._products",array("method"=>"view"))
</table>




<div class="row">
	<div class="col-xs-5">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h4>Payment details</h4>
			</div>
			<div class="panel-body">
			    <p>
					@if(!empty($order->course))
						{{$order->course->course_trans("ar")->name}}-
						{{$order->coursetype}}
					@endif
				</p>
				<table class="table">
					<thead>
					<tr>
						<th>reference</th>
						<th>payment id</th>
						<th>payment method</th>
						<th>status</th>
						<th>total</th>
						<th>date added</th>
					</tr>
					</thead>
					<tbody>
					@foreach($order->order_onlinepayments as $order_onlinepay)
						<tr>
							<td>
								{{$order_onlinepay->ref}}
							</td>
							<td>
								{{$order_onlinepay->payid}}
							</td>
							<td>
								{{$order_onlinepay->payment_method}}
								@if($order_onlinepay->payment_method=="banktransfer")
									<br/>
									<img src='{{asset("uploads/kcfinder/upload/image/bank_transfers/".$order_onlinepay->banktransfer_image)}}' width="100px" height="100px" alt="no image"/>
								@endif
							</td>
							<td>
								{{$order_onlinepay->payment_status}}
							</td>
							<td>
								{{$order_onlinepay->total}}
							</td>
							<td>
								{{ date("Y-m-d",strtotime($order_onlinepay->created_at)) }}
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-xs-7">
		<div class="span7">
			<div class="panel panel-info">
			    <div class="panel-heading">
			      <h4>Recipient's Name <span><i>Package delivered to </i></span></h4>
				  
			    </div>
			    <div class="panel-body">
				
			      <p>
			        Name : <br><br>
			        Dated : <br> <br>
					The Recipient's Signature :  <br> <br>
			        
			      </p>
			  
			    </div>
			</div>
		</div>
	</div>
</div>