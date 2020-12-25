<?php
$totalPrice = 0;
//print_r($cart);
?>
<table id="cart" class="table cart-tble table-condensed" style="direction: {{ $dir }} " >
    <thead>
    <tr>
        <th style="width:50%" class="text-center" >@lang('navbar.product')</th>
        <th style="width:10%" class="text-center">@lang('navbar.price')</th>
        <th style="width:8%"  class="text-center">@lang('navbar.qte')</th>
        <th style="width:22%" class="text-center">@lang('navbar.total')</th>
        <th style="width:10%"></th>
    </tr>
    </thead>
    <tbody>
	
    @foreach($cart as $key=>$cart_pro)
        <?php
        $type = "book";
        $product_id = 0;
        if(isset($cart_pro['coursetypevariation_id'])){
            $type = "course";
            $courseTypeVariation = \App\CourseTypeVariation::findOrFail($cart_pro['coursetypevariation_id']);
            $courseType = $courseTypeVariation->courseType;
            $course = $courseType->course;
            $course_trans = $course->course_trans(session()->get('locale'));
            if(empty($course_trans))
                $course_trans = $course->course_trans("ar");
            $product_id = $cart_pro['coursetypevariation_id'];
        }elseif(isset($cart_pro['quiz_id'])){
            $type = "quiz";
            $quiz = \App\Quiz::findOrFail($cart_pro['quiz_id']);
            $quiz_trans = $quiz->quiz_trans(session()->get('locale'));
            if(empty($quiz_trans))
                $quiz_trans = $quiz->quiz_trans("ar");
            $product_id = $cart_pro['quiz_id'];
        }elseif(isset($cart_pro['pack_id'])){
            $type = "packs";
            $packs = \App\Packs::findOrFail($cart_pro['pack_id']);
            $product_id = $cart_pro['pack_id'];
        }else{
            $book = \App\Book::findOrFail($cart_pro['book_id']);
            $book_trans = $book->book_trans(session()->get('locale'));
            if(empty($book_trans))
                $book_trans = $book->book_trans("ar");
            $product_id = $cart_pro['book_id'];
        }
        ?>
        <tr>
            <td data-th="@lang('navbar.product')">
				
				@if(isset($cart_pro['coursetypevariation_id']))
					@foreach($course->courseDiscounts as $courseDiscount)
						@if($courseDiscount->num_students == $cart_pro["quantity"])
							@php ($pourc = $courseDiscount->discount)
						@endif
					@endforeach
				@endif

                <div class="row">
                    @if($type=="course")
                        <div class="col-sm-3 hidden-xs">
                            <img src="{{asset('uploads/kcfinder/upload/image/'.$course->image)}}" alt="{{ $course_trans->name }}" class="cart-img"/>
                        </div>
                        <div class="col-sm-9">
                            <a href="{{ url(App('urlLang').'courses/'.$courseType->id) }}"><h4>{{ $course_trans->name }} - {{ trans('home.'.$courseType->type) }}</h4></a>
                            <p>{{ $course_trans->short_description }}</p>
                        </div>
                    @elseif($type=="quiz")
                        <p>{{ $quiz_trans->name }}</p>
                    @elseif($type=="packs")
                        <p>{{ $packs->titre }}</p>
                    @else
                        <div class="col-sm-3 hidden-xs">
                            <img src="{{asset('uploads/kcfinder/upload/image/'.$book->image)}}" alt="{{ $book_trans->name }}" class="cart-img"/>
                        </div>
                        <div class="col-sm-9">
                            <a href="{{ url(App('urlLang').'books/'.$book_trans->slug) }}"><h4>{{ $book_trans->name }}</h4></a>
                            <p>{{ $book_trans->short_description }}</p>
                        </div>
                    @endif
                </div>
            </td>
            <td data-th="@lang('navbar.price')">
                <?php 
                    $setting = App('setting');
                    $vat = $setting->vat*($cart_pro["price"]/100);
                ?>
                ${{ floor($cart_pro["price"]+$vat) }}
            </td>
            <td data-th="@lang('navbar.qte')">
                <input type="number" class="form-control text-center input_qte"  
                 onChange="$('#btnUpdate_{{$product_id}}').click()"
                max="" min="1" id="quantity_{{$product_id}}" name="quantity_{{$product_id}}" value="{{$cart_pro['quantity']}}">
            </td>
            <td class="text-center">
                <?php
                    $cart_pro["total"] = floor($cart_pro["price"]+$vat)*$cart_pro['quantity'];
					if(isset($pourc)){
						$cart_pro["total"] = $cart_pro["total"] - (($cart_pro["total"]/100) * $pourc);
					}
					
                    $totalPrice+=$cart_pro["total"];
                ?>
                ${{ $cart_pro["total"] }}
            </td>
            <td class="actions" data-th="">
                <button style="display:none" class="btn btn-info btn-sm btn_update" data-type="{{ $type }}"
                        @if($type=="course")
                        data-coursetypevariation_id='{{$cart_pro["coursetypevariation_id"]}}'
                        @elseif($type=="quiz")
                            data-quiz_id='{{$cart_pro["quiz_id"]}}'
                        @elseif($type=="packs")
                            data-quiz_id='{{$cart_pro["pack_id"]}}'
                        @else
                        data-book_id='{{$cart_pro["book_id"]}}'
                        @endif
                        id="btnUpdate_{{$product_id}}"
                ><i class="fa fa-refresh"></i></button>
                <button class="btn btn-danger btn-sm product_delete" data-type="{{ $type }}"
                        @if($type=="course")
                        data-coursetypevariation_id='{{$cart_pro["coursetypevariation_id"]}}'
                        @elseif($type=="quiz")
                            data-quiz_id='{{$cart_pro["quiz_id"]}}'
                        @elseif($type=="packs")
                            data-quiz_id='{{$cart_pro["pack_id"]}}'
                        @else
                        data-book_id='{{$cart_pro["book_id"]}}'
                        @endif
                ><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
    @endforeach

    </tbody>
    <?php 
        $next = session()->get('locale') === "ar" ? "left" : "right";
        $back = session()->get('locale') === "ar" ? "right" : "left";
    
    ?>

    @if(isset($fromPage)&&$fromPage=="cart")
        <tfoot>
        <tr>
        <td><a href="{{ url(App('urlLang').'all-courses') }}" class="btn btn-warning pull-{{$back}}"><i class="fa fa-angle-{{ $back }}"></i> @lang('navbar.previous')</a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong> @lang('navbar.totalprice') <span class="pricenovat">{{ $totalPrice }} $</span></strong></td>

        @if(auth()->check())
        <td><a href="{{ url(App('urlLang').'checkout') }}" class="btn btn-success btn-block">@lang('navbar.next') <i class="fa fa-angle-{{$next}}"></i></a></td>
        @else
          <td><a href="{{ url(App('urlLang').'checkout_anlogged') }}" class="btn btn-success btn-block">@lang('navbar.next') <i class="fa fa-angle-{{$next}}"></i></a></td>

        @endif



        </tr>
        </tfoot>
    @endif
</table>