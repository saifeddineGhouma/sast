    <thead>
      <tr>
      	<th>{{trans('home.product_id')}}</th>
        <th>{{trans('home.product')}}</th>
		<th>{{trans('home.product_type')}}</th>
        <th>{{trans('home.num_students')}}</th>
        <th>{{trans('home.total')}}</th>
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

    	<tfoot>
		    @if($order->points_value>0)
		    	<tr>	    		
			        <td colspan="2">{{$order->points}} Reward Points exchanged with Value :</td>       
			        <td class="p-price-column" colspan="2" >-{{$order->points_value}} </td>
			    </tr>
		    @endif
		    @if($order->coupon_value>0)
		    	<tr>	    		
			        <td colspan="2">coupon : {{!empty($order->coupon)?$order->coupon->coupon_number:''}}</td>       
			        <td class="p-price-column" colspan="2" >-{{$order->coupon_value}} </td>
			    </tr>
		    @endif
			<tr>			
		        <td colspan="2">{{trans('home.total')}}</td>
		        <td colspan="2" >{{$order->total}} </td>
		    </tr>  
    	</tfoot>
    </tbody>
