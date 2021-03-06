@extends('front/layouts/masterpdf')
@section('styles')

@stop

@section('content')
	
	<div class="container">
		<div class="col-md-12">
			<div class="col-md-12" align="right"> 
				<br>
				<a class="btn btn-info printOrder">print</a>
				<input type="hidden" id="id" value="{{$order->id}}">
			</div>
			<div class="panel">
				<div class="panel-body" style="margin-top: 20px;">
					<div class="panel-body" style="margin-top: 20px;">
						<div class="row">
							<div class="col-xs-6 text-left">
								<h1>INVOICE</h1>
								<h1><small>Order #{{$order->id}}</small></h1>
							</div>
							<div class="col-xs-6 text-right">
								<h1>
									<img src="https://swedish-academy.se/uploads/kcfinder/upload/image/thumbnails/web_logo.png" style="width:75px">
									{{ App('setting')->settings_trans("en")->site_name }}
								</h1>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4>From: {{ App('setting')->settings_trans("en")->site_name }}</h4>
								</div>
								<div class="panel-body">
									<b>Mobile:</b> {{ App('setting')->mobile }}<br>
									<b>E-mail:</b> {{ App('setting')->email }}
								</div>
							</div>
						</div>
						<div class="col-xs-5 col-xs-offset-2 text-right">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4>To : {{$user->full_name_ar}}</h4>
								</div>
								<div class="panel-body">
									Phone:{{$order->user->phone}} <br>
									Mobile number : {{$order->user->mobile}}
									<p></p>
								</div>
							</div>
						</div>
					</div> <!-- / end client details section -->

					<table class="table table-bordered">
						<thead>
							<tr>
								<th>رقم المنتج</th>
								<th>المنتج</th>
								<th>نوع المنتج</th>
								<th>عدد الطلاب</th>
								<th>الإجمالي</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$total_price = 0;
								$product_details = '';
								$url = "";
							?>

							@foreach($order->orderproducts as $orderproduct)
								<tr>
									<td rowspan="{{$orderproduct->num_students}}">
										@if(!empty($orderproduct->course_id))
											{{$orderproduct->course_id}}
										@elseif(!empty($orderproduct->quiz_id))
											{{$orderproduct->quiz_id}}
										@elseif(!empty($orderproduct->book_id))
											{{$orderproduct->book_id}}
										@endif
									</td>
									<td rowspan="{{$orderproduct->num_students}}">
										<?php
											if(!empty($orderproduct->course_id)&&!empty($orderproduct->course)){
												$product_details = $orderproduct->course->course_trans(App("lang"))->name;
												if(!empty($orderproduct->coursetype_variation)){
													$courseTypeVairiation = $orderproduct->coursetype_variation;
													$product_details .= "<br/>".$courseTypeVairiation->courseType->type;
													if(!empty($courseTypeVairiation->teacher))
														$product_details .= " ".$courseTypeVairiation->teacher->teacher_trans(App('lang'))->name;
													$url = url(App('urlLang').'courses/'.$courseTypeVairiation->coursetype_id);
												}
											}elseif(!empty($orderproduct->quiz_id)&&!empty($orderproduct->quiz)){
												$quiz_trans = $orderproduct->quiz->quiz_trans(App("lang"));
												if(!empty($quiz_trans)){
													$product_details = $quiz_trans->name;
													$url = "";
												}
											}
											elseif(!empty($orderproduct->book_id)&&!empty($orderproduct->book)){
												$book_trans = $orderproduct->book->book_trans(App("lang"));
												if(!empty($book_trans)){
													$product_details = $book_trans->name;
													$url = url(App('urlLang').'books/'.$book_trans->slug);
												}
											}

										?>
										<a href="{{ $url }}">
											{!! $product_details !!}
											@if(!empty($orderproduct->files))
												@foreach(explode( ',', $orderproduct->files) as $fileName)
													<br>
													<a href="/uploads/kcfinder/upload/files/experience/{{$fileName}}">Experience proof</a>
												@endforeach
											@endif
										</a>
									</td>
									<td>
										@if(!empty($orderproduct->course_id))
											Course
										@elseif(!empty($orderproduct->quiz_id))
											Exam
										@elseif(!empty($orderproduct->book_id))
											Book
										@endif
									</td>
									<td>
										{{$orderproduct->num_students}}<br/>
										@if(isset($method)&&$method=="edit")
											<div class="form-group">
												<label class="col-md-2 control-label">students</label>
												<div class="col-md-10">
													<select  name="student_ids_{{$orderproduct->id}}[]" id="student_ids_{{$orderproduct->id}}" class="form-control select2" multiple aria-hidden="true" maxlength="{{$order->num_students}}">
														@foreach($students as $student)
															<option value="{{$student->id}}"
																	{{ $orderproduct->orderproducts_students()->where("orderproducts_students.student_id",$student->id)->count()>0?"selected":null }}>
																{{ $student->user->full_name_ar }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											@foreach($orderproduct->students as $student)
												{{ $student->user->full_name_ar }}
											@endforeach
										@endif
									</td>
									<td>
										{{$orderproduct->total}}
									</td>
								</tr>
								<?php
									$total_price += $orderproduct->total;
								?>
								<tr>
									<td colspan="3">
										<table>
											<thead>
											<tr>
												<th>#</th>
												<th>اسم المستخدم
												</th>
												<th>الاسم بالكامل</th>
												<th>البريد الإلكتروني</th>
												<th>رقم الجوال</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>1</td>
												<td>{{ $order->user->username }}</td>
												<td>{{ $order->user->full_name_ar }}</td>
												<td>{{ $order->user->email }}</td>
												<td>{{ $order->user->mobile }}</td>
											</tr>
											@foreach($orderproduct->orderproducts_unstudents as $unstudent)
												<tr>
													<td>{{ $loop->iteration + 1 }}</td>
													<td>{{ $unstudent->username }}</td>
													<td>{{ $unstudent->full_name }}</td>
													<td>{{ $unstudent->email }}</td>
													<td>{{ $unstudent->mobile }}</td>
												</tr>
											@endforeach

											</tbody>
										</table>
									</td>
								</tr>
							@endforeach
							
						</tbody>
						<tfoot>
							@if($order->points_value>0)
								<tr>	    		
									<td colspan="2">{{$order->points}} Reward Points exchanged with Value :</td>       
									<td class="p-price-column" colspan="3" >-{{$order->points_value}}$</td>
								</tr>
							@endif
							@if($order->coupon_value>0)
								<tr>	    		
									<td colspan="2">Coupon : {{!empty($order->coupon)?$order->coupon->coupon_number:''}}</td>       
									<td class="p-price-column" colspan="3" >-{{$order->coupon_value}}% </td>
								</tr>
							@endif
							<tr>
								<td colspan="2">VAT</td>
								<td class="p-price-column" colspan="3"><?php echo $order->vat; ?>$</td>
							</tr>
							<tr>			
								<td colspan="2">{{trans('home.total')}}</td>
								<td colspan="3" >{{$order->total}} </td>
							</tr>  
						</tfoot>
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
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		$(".printOrder").click(printdiv);
		function printdiv() {
			var id = $("#id").val();
			var iFrame = document.createElement('iframe');
			iFrame.style.position = 'absolute';
			iFrame.style.left = '-99999px';
			iFrame.src = "https://swedish-academy.se/report"+"/"+id;
			iFrame.onload = function() {
			  function removeIFrame(){
				document.body.removeChild(iFrame);
				document.removeEventListener('click', removeIFrame);
			  }
			  document.addEventListener('click', removeIFrame, false);
			};

			document.body.appendChild(iFrame);
		 
		};
	</script>
@stop