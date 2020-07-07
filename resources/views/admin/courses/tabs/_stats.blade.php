
<div class="row">

	<div class="form-group">

		<label class="col-md-3 control-label">Ratings  ({{ $course->ratings()->count() }})</label>

		<div class="col-md-9">

			5 stars <b>({{ $course->sumRating(5) }})</b> - 4 stars <b>({{ $course->sumRating(4) }})</b> - 3 stars <b>({{ $course->sumRating(3) }})</b> - 2 stars <b>({{ $course->sumRating(2) }})</b> - 1 star <b>({{ $course->sumRating(1) }}) </b>

		</div>

	</div>
	<div class="form-group">

		<label class="col-md-3 control-label">Total Orders</label>

		<div class="col-md-9">

			{{ $course->orders()->count() }}  ({{ $course->orders()->where('orders.created_at', '>', (new \Carbon\Carbon)->submonths(1) )->count() }}   in the last 30 days  )

		</div>

	</div>
	<div class="form-group">

		<label class="col-md-3 control-label">Paid Orders</label>

		<div class="col-md-9">

			{{ $course->orders()->join('order_onlinepayments','orders.id','=','order_onlinepayments.order_id')->where('order_onlinepayments.payment_status','paid')->count() }}  ({{ $course->orders()->join('order_onlinepayments','orders.id','=','order_onlinepayments.order_id')->where('order_onlinepayments.payment_status','paid')->where('orders.created_at', '>', (new \Carbon\Carbon)->submonths(1) )->count() }}   in the last 30 days  )

		</div>

	</div>
	<div class="form-group">

		<label class="col-md-3 control-label">Certified students</label>

		<div class="col-md-9">

			{{ $course->students_certificates()->count() }} ({{ $course->students_certificates()->where('created_at', '>', (new \Carbon\Carbon)->submonths(1) )->count() }}   in the last 30 days  )

		</div>

	</div>
</div>