@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.view_order')}}  </title>
@stop
@section("styles")

@stop
@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp
@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media"  style="direction:{{ $dir }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account') }}">{{trans('home.mon_compte_header')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account/orders') }}">{{trans('home.mes_demandes')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.view_order')}} </span>#{{$order->id}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container"  style="direction:{{ $dir }}">
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between row-account">
                        <div class="page-title">
                            <h2>{{trans('home.order')}}: <span>#{{$order->id}}</span></h2>
                        </div>

                        <div class="wishlist-item table-responsive">
                            <table class="table table-bordered table-responsive cart_summary vwordr" style="text-align: {{$alignText}}">
                                <tbody>
                                <tr>
                                    <th style="text-align: {{$alignText}}">{{trans('home.order')}} #</th>
                                    <td>{{$order->id}}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: {{$alignText}}"> {{trans('home.total')}}</th>
                                    <td>
                                        {{ $order->total }}$
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: {{$alignText}}">{{trans('home.method_paiement')}}   </th>
                                    <td>
                                        {{$order->payment_method}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: {{$alignText}}">{{trans('home.date_ajout')}} </th>
                                    <td>
                                        {{ date("Y-m-d",strtotime($order->created_at)) }}
                                    </td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" rowspan="2">

                                        <div class="clearfix"></div>
                                        <table class="order-table order-products" style="text-align: {{$alignText}}">
                                            <thead>
                                            <th style="text-align: {{$alignText}}">{{trans('home.reference')}}</th>
                                            <th style="text-align: {{$alignText}}">{{trans('home.payment_id')}}</th>
                                            <th style="text-align: {{$alignText}}">{{trans('home.payment_method')}}</th>
                                            <th style="text-align: {{$alignText}}" width="12%">{{trans('home.statut')}}</th>
                                            <th style="text-align: {{$alignText}}">{{trans('home.total')}}</th>
                                            <th style="text-align: {{$alignText}}" width="14%">{{trans('home.date_paiement')}}</th>
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
                                                            <img src='{{asset("uploads/kcfinder/upload/image/bank_transfers/".$order_onlinepay->banktransfer_image)}}' width="100px" height="100px" alt="no invoice"/>

                                                            @if($order_onlinepay->payment_status=="not_paid")
                                                                <img src='{{asset("/uploads/bank_transfers/".$order->banktransfer_image)}}' width="100px" height="100px" alt="no image"/>

                                                                @if (count($errors) > 0)
                                                                    <div class="alert alert-danger">
                                                                        <ul>
                                                                            @foreach ($errors->all() as $error)
                                                                                <li>{{ $error }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                                <form method="post" id="banktransfer-form" action="{{url(App('urlLang').'account/banktransfer')}}" enctype="multipart/form-data">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="orderpayment_id" value="{{$order_onlinepay->id}}"/>
                                                                    <input type="file" name="banktransfer_image" accept="image/x-png,image/gif,image/jpeg" max-size="1000000">
                                                                    <button class="button" type="submit">upload</button>
                                                                </form>

                                                            @endif
                                                        @else
                                                            @if($order_onlinepay->payment_status=="not_paid")
                                                                @if($order->payment_method=='paypal')
                                                                    <a class="btn btn-cool order_pay" data-id="{{ $order_onlinepay->id }}" data-loading-text="{{trans('home.saving')}}">{{trans('home.pay_now')}}</a>
                                                                @endif
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
                                                        <?php
                                                        $totalPaid += $order_onlinepay->payonline;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        {{ date("Y-m-d",strtotime($order_onlinepay->created_at)) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6">
                                                    @if($totalPaid>=$order->total)
                                                        <div class="alert alert-success">
                                                            Complete Paid
                                                        </div>
                                                    @else
                                                        <div class="alert alert-danger">
                                                            {{$order->total-$totalPaid}}$

                                                            {{trans('home.remaining_not_paid')}}

                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                </tfoot>
                            </table>

                            <h3 class="products-heading" style="text-align: justify">{{trans('home.order_products')}}</h3>
                            <div class="panel-body">
                                <table class="table table-bordered table-responsive cart_summary">
                                    @include("admin.orders._products",array("method"=>"account"))
                                </table>
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
    $(".order_pay").click(function(){
        var orderpayment_id = $(this).data("id");
        var btn = $(this);
        $.ajax({
            url: "{{url(App('urlLang').'checkout/pay')}}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"orderpayment_id": orderpayment_id},
            beforeSend: function(){
                btn.button('loading');
            },
            success: function( message ) {
                var indexhttp = message.search("http");
                if(indexhttp==0);
                location.href = message;
            },
            complete: function() {
                btn.button('reset');
            }
        });
    });
    $('#banktransfer-form').submit(function(e){

        $('#banktransfer-form > input[type=file][max-size]').each(function(){
            if(typeof this.files[0] !== 'undefined'){
                var maxSize = parseInt($(this).attr('max-size'),10);

                size = this.files[0].size;
                isOk = maxSize > size;

                if(!isOk){
                    e.preventDefault();
                    $('#banktransfer-form').append('<span class="help-block">حجم الملف كبير جدا</span>');
                }
            }
        });
    });
</script>
@stop


