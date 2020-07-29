@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp

<div class="filteration_method_head"  style="direction:{{ $dir }}">
	<p>{{ trans('home.filtre_courses_sidbar') }}</p> 
</div>
<div class="filteration_method_content">
	<div class="row justify-content-between price_rate_filter">
		<div class="col-12">
			@if($type=="all-courses")
				<p>{{ trans('home.all_courses_filtre_sidbar') }}</p>
			@else
				<p>{{ $cat_trans->name }}</p>
			@endif
                <?php 
                if($type=="all-courses"){
                    $subcats = \App\Category::get();
                }else{
                    $subcats = $category->subcat;
                }


                function recurseCat($subcat){
                    $subcat_trans = $subcat->category_trans(session()->get('locale'));
                    if(empty($subcat_trans))
                        $subcat_trans = $subcat->category_trans("en");

                    $name = $subcat_trans->name;

                    echo '<div class="form-check">
								<input class="form-check-input cat_check" type="checkbox" data-id="'.$subcat->id.'">
								<label class="form-check-label">'.$subcat_trans->name.'</label>
							</div>';
                }
                ?>
				@if(!is_null($subcats)&&$subcats->count()>0)
					@if($type=="category")
						<div class="form-check">
							<input class="form-check-input cat_check" type="checkbox" data-id="{{ $category->id }}">
							<label class="form-check-label">{{ $cat_trans->name }}</label>
						</div>
					@endif
					@foreach($subcats as $subcat)
						{!! recurseCat($subcat) !!}
					@endforeach

				@endif
		</div>
	</div>
	<div class="row justify-content-between price_rate_filter">
		<div class="col-12">
			<p>{{ trans('home.type_cours') }}</p>
			<div class="form-check">
				<input class="form-check-input type_check" type="checkbox" value="online">
				<label class="form-check-label">{{ trans('home.online') }} </label>
			</div>
			<div class="form-check">
				<input class="form-check-input type_check" type="checkbox" value="presence">
				<label class="form-check-label"> {{ trans('home.classroom') }} </label>
			</div>
		</div>
	</div>
	<div class="row justify-content-between price_rate_filter">
		<div class="col-12">
			<p> {{ trans('home.price') }}</p>
		</div>
		<div class="col-5">
			<span class="slider_text_range"> {{ trans('home.to') }}</span>
			<input type="text" id="amount_two" value="{{$maxPrice}}" style="text-align: justify">
		</div>
		<div class="col-5" >
			<span class="slider_text_range">{{ trans('home.from') }}</span>
			<input type="text" id="amount_one" value="{{$minPrice}}"  style="text-align: justify">
		</div>
		<div class="col-12">
			<div id="slider-range_one"></div>
		</div>
	</div>
</div>