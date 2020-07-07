<div class="row">
	<div class="col-md-6 col-sm-12">
		<div class="panel panel-primary filterable portlet box">
			<div class="panel-heading clearfix">
				<div class="panel-title pull-left">
					<div class="caption">
						<i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
						order summary
					</div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-nomargin">
					<tbody>
					<tr>
						<td>order id</td>
						<td>
							{{$order->id}}
						</td>
					</tr>
					<tr>
						<td>vat</td>
						<td>
							{{$order->vat}}$
						</td>
					</tr>
					<tr>
						<td>total</td>
						<td>
							{{$order->total}}$
						</td>
					</tr>
					<tr>
						<td>payment method</td>
						<td>
							{{$order->payment_method}}
							@if($order->payment_method=="banktransfer"||$order->payment_method=="creditcard")
								<br/>
								<img src='{{asset("uploads/kcfinder/upload/image/bank_transfers/".$order->banktransfer_image)}}' width="100px" height="100px" alt="no image"/>
							@elseif($order->payment_method!="cash")
								<span>ref :</span> {{$order->ref}}<br/>
								<span>payid :</span> {{$order->payid}}
							@endif
						</td>
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
							<td>{{$order->coupon_value}} </td>
						</tr>
					@endif
					<tr>
						<td>date added</td>
						<td>
							{{date("Y-m-d",strtotime($order->created_at))}}
						</td>
					</tr>
					<tr>
						<td>payment status</td>
						<td>
				             	<span class="label label-sm label-info">
			             			{{$order->payment_status}}
				             	</span>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<div class="col-md-4">
									<input type="checkbox" name="paid" {{($order->payment_status=="paid")?"checked":null}}>Paid

								</div>
							</div>
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
							<td>name </td>
							<td>
								{{$order->user->full_name_ar}}
							</td>
						</tr>
						<tr>
							<td>username </td>
							<td>
								{{$order->user->username}}
							</td>
						</tr>
						<tr>
							<td>mobile</td>
							<td>
								{{$order->user->mobile}}
							</td>
						</tr>
						<tr>
							<td>email address</td>
							<td>{{$order->user->email}}</td>
						</tr>
						<tr>
							<td>book</td>
							<td>
								@if(!empty($order->book))
									{{$order->book->book_trans("ar")->name}}
								@endif
							</td>
						</tr>

						</tbody>
					</table>
				</div>
			</div>
		@endif
	</div>
</div>
