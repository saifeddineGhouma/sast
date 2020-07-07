@extends('front/layouts/master')

@section('meta')
	<title>@lang('navbar.cart')   </title>
	<meta name="keywords" content="{{$metaData->keyword}}" />
	<meta name="description" content="{{$metaData->description}}">
@stop
@section('styles')

@stop
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@section('content')
	<div class="training_purchasing">
		<div class="container training_container">
			<div class="media" style="direction: {{ $dir }} ">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span>@lang('navbar.cart')</span>
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>

<div class="container" id="shopping-cart-page">
<h1 style =" direction :{{ $dir }}" ><i class="fa fa-shopping-basket" style="margin-left:5px;margin-right: 5px"></i>@lang('navbar.cart')</h1>
	@if(!is_null($cart)&&!empty($cart))
       @include("front.cart._cart",["fromPage"=>"cart"])
	@else
		<h3>{{trans('home.shopping_cart_empty')}}     <br/> <span class="sub-header">{{trans('home.no_items_shopping_cart')}}</span></h3>
		<a href="{{URL::previous()}}" class="button backtoshop">{{trans('home.back_previous_page')}}</a>
	@endif
</div>




@stop



@section('scripts')
	<script>

        jQuery(".product_delete").click(productDelete);
        function productDelete(){
            var type =$(this).data("type");
            var data = null;
            if(type=="course"){
                var coursetypevariation_id = jQuery(this).data("coursetypevariation_id");
                data = {coursetypevariation_id: coursetypevariation_id};
			}else if(type=="quiz"){
                var quiz_id = jQuery(this).data("quiz_id");
                data = {quiz_id: quiz_id};
            }else{
                var book_id = jQuery(this).data("book_id");
                data = {book_id: book_id};
			}
            jQuery.ajax({
                url:'{{url(App("urlLang")."cart/deletefromcart/")}}',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                beforeSend: function(){
					$("#content_loading").modal("show");
                },
                success: function( result ) {
                    if(result[0]=="success"){
                        $("span.bskt").html(result[1]);
                    }

                    jQuery('#shopping-cart-page').load(document.URL +  ' #shopping-cart-page',function(responseText, textStatus, XMLHttpRequest){
                        jQuery(".product_delete").click(productDelete);
                        jQuery(".btn_update").click(productUpdate);
                    });

                },
                complete: function(  ) {
                    $("#content_loading").modal("hide");
                }
            });
        }



        jQuery(".btn_update").click(productUpdate);
        function productUpdate(){
            var btn = jQuery(this);
            var type =$(this).data("type");
            var data = null;
            var quantity1 = 0;
            if(type=="course"){
                var coursetypevariation_id = jQuery(this).data("coursetypevariation_id");
                var quantity = $("#quantity_"+coursetypevariation_id).val();
                data = {coursetypevariation_id: coursetypevariation_id,quantity: quantity};
                quantity1 = quantity;
            }else if(type=="quiz"){
                var quiz_id = jQuery(this).data("quiz_id");
                var quantity = $("#quantity_"+quiz_id).val();
                data = {quiz_id: quiz_id,quantity: quantity};
                quantity1 = quantity;
            }else{
                var book_id = jQuery(this).data("book_id");
                var quantity = $("#quantity_"+book_id).val();
                data = {book_id: book_id,quantity: quantity};
                quantity1 = quantity;
            }
			if(quantity1>0){
                jQuery.ajax({
                    url: '{{url(App("urlLang")."cart/updatecart/")}}',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    beforeSend: function(){
                        $("#content_loading").modal("show");
                    },
                    success: function( result ) {
                        if(result[0]=="success"){
                            $("span.bskt").html(result[1]);
                        }

                        jQuery('#shopping-cart-page').load(document.URL +  ' #shopping-cart-page',function(responseText, textStatus, XMLHttpRequest){
                            jQuery(".product_delete").click(productDelete);
                            jQuery(".btn_update").click(productUpdate);
                        });
                    },
                    complete: function(  ) {
                        $("#content_loading").modal("hide");
                    }
                });
			}

        }

	</script>
@stop

