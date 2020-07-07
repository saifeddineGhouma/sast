@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp
<div class="table-responsive">
    <table class="table table_striped_col">
  <thead>
    <tr>
      <th style="text-align: {{$alignText}}">{{trans('home.num_coupon')}}</th>
      <th style="text-align: {{$alignText}}">{{trans('home.remise_coupon')}}</th>
      <th style="text-align: {{$alignText}}">{{trans('home.debut_de')}}</th>
      <th style="text-align: {{$alignText}}" width="15%">{{trans('home.to')}}</th>
      <th style="text-align: {{$alignText}}">{{trans('home.totale_grand')}}</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($coupons as $coupon)
  		<tr>
          <td>
          		{{$coupon->coupon_number}}
          </td>
          <td>
          		{{$coupon->discount}} $
          </td>
          <td>
          		{{$coupon->date_from}}
          </td>
          <td>
          		{{$coupon->date_to}}
          </td>
          <td>
          		{{$coupon->ordertotal_greater}} $
          </td>
           
        </tr>
  	@endforeach 
  </tbody>
</table>
</div>