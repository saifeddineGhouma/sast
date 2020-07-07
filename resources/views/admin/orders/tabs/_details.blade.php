<div class="row">
	<div class="col-md-6 col-sm-12">
		<div class="panel panel-primary filterable portlet box">
			<div class="panel-heading clearfix">
				<div class="panel-title pull-left">
					<div class="caption">
						<i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
						Order summary
					</div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-nomargin">
					<tbody>
					<tr>
						<td>Order id</td>
						<td>
							{{$order->id}}
						</td>
					</tr>
					<tr>
						<td>Total</td>
						<td>
							{{$order->total}}$
						</td>
					</tr>
					<tr>
						<td>Payment method</td>
						<td>
							{{$order->payment_method}}
						</td>
					</tr>
					<!-- old data -->
					@if(!empty($order->invoice))
						<tr>
							<td>Invoice</td>
							<td>
								<img src='{{asset("uploads/kcfinder/upload/image/".$order->invoice)}}' width="100px" height="100px" alt="no image"/>
							</td>
						</tr>
					@endif
					@if(!empty($order->copymoneyorder))
						<tr>
							<td>Invoice</td>
							<td>
								<img src='{{asset("uploads/kcfinder/upload/image/".$order->copymoneyorder)}}' width="100px" height="100px" alt="no image"/>
							</td>
						</tr>
					@endif

					<tr>
						<td>Number students</td>
						<td>{{$order->num_students}}</td>
					</tr>
					@if($order->points_value>0)
						<tr>
							<td>{{$order->points}} Reward Points exchanged with Value :</td>
							<td>{{$order->points_value}}$</td>
						</tr>
					@endif
					@if($order->coupon_value>0)
						<tr>
							<td>coupon : {{!empty($order->coupon)?$order->coupon->coupon_number:''}}</td>
							<td>{{$order->coupon_value}}% </td>
						</tr>
					@endif
					<tr>
						<td>Date added</td>
						<td>
							{{date("Y-m-d",strtotime($order->created_at))}}
						</td>
					</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12">
		@if(!empty($order->user))
			<div class="panel panel-primary filterable portlet box">
				<div class="panel-heading clearfix">
					<div class="panel-title pull-left">
						<div class="caption">
							<i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
							billing info
						</div>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-nomargin">
						<tbody>
						<tr>
							<td>Name </td>
							<td>
								{{$order->user->full_name_en}}
							</td>
						</tr>
						<tr>
							<td>Username </td>
							<td>
								{{$order->user->username}}
							</td>
						</tr>
						<tr>
							<td>Mobile</td>
							<td>
								{{$order->user->mobile}}
							</td>
						</tr>
						<tr>
							<td>Email address</td>
							<td>{{$order->user->email}}</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		@endif
	</div>
</div>

<h3 class="form-section">payments</h3>
<div id="reloaddiv">
	<table class="table table-striped table-bordered table-condensed">
		<thead>
		<th>reference</th>
		<th>payment id</th>
		<th>payment method</th>
		<th>status</th>
		<th>total</th>
		<th>date added</th>
		<th>Actions</th>
		</thead>
		<tbody>
        <?php
        $totalPaid = 0;
        ?>
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
					@if($order_onlinepay->payment_method=="banktransfer"||$order_onlinepay->payment_method=="agent")
						<br/>
						<a href="{{asset("uploads/kcfinder/upload/image/bank_transfers/".$order_onlinepay->banktransfer_image)}}" target="_blank">
							<img src='{{asset("uploads/kcfinder/upload/image/bank_transfers/".$order_onlinepay->banktransfer_image)}}' width="100px" height="100px" alt="no image"/>
						</a>
						@if(!empty($order_onlinepay->agent))
							<br/>
							{{ $order_onlinepay->agent->name }}
						@endif
					@endif
				</td>
				<td>
					{{$order_onlinepay->payment_status}}
                    <?php
                    if($order_onlinepay->payment_status == "paid")
                        $totalPaid += $order_onlinepay->total;
                    ?>
				</td>
				<td>
					{{$order_onlinepay->total}}
				</td>
				<td>
					{{ date("Y-m-d",strtotime($order_onlinepay->created_at)) }}
				</td>
				<td>
					@if($order_onlinepay->payment_method == "cash"||$order_onlinepay->payment_method == "banktransfer"||
					$order_onlinepay->payment_method == "agent")
						<a class="editpayment" data-toggle="modal" href="#modal-2" data-id="{{$order_onlinepay->id}}" data-total="{{$order_onlinepay->total}}"
						   data-payment_status="{{$order_onlinepay->payment_status}}">
							edit
						</a>
						<a data-toggle="modal" class="deletepayment" elementId="{{$order_onlinepay->id}}">
							remove
						</a>
					@endif
				</td>
			</tr>
		@endforeach
		@if($order->points_value>0)
            <?php
            //$totalPaid += $order->points_value;
            ?>
			<tr>
				<td colspan="4">{{$order->points}} Reward Points exchanged with Value :</td>
				<td>{{$order->points_value}}$</td>
				<td colspan="2"></td>
			</tr>
		@endif
		@if($order->coupon_value>0)
            <?php
				$valuec=($order->total/100)*$order->coupon_value;
				//$totalPaid += $valuec;
            ?>
			<tr>
				<td colspan="4">coupon : {{!empty($order->coupon)?$order->coupon->coupon_number:''}}</td>
				<td>{{$order->coupon_value}}% </td>
				<td colspan="2"></td>
			</tr>
		@endif
		<tr>
			<td colspan="7">
				@if($totalPaid >=$order->total)
					<div class="alert alert-success">
						Complete Paid
					</div>
				@else
					<a data-toggle="modal" href="#modal-2" class="addpayment">
						add payment
					</a>
					<div class="alert alert-danger">
						{{$order->total-$totalPaid}}$
						remaining not paid
					</div>
				@endif
			</td>
		</tr>
		</tbody>
	</table>
</div>
<table class="table table-striped table-bordered table-condensed">
	@include("admin.orders._products",array("method"=>"edit"))
</table>
