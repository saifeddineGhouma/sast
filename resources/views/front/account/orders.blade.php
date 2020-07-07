@extends('front/layouts/master')

@section('meta')
	<title> {{trans('home.mes_demandes')}} </title>
@stop
@section("styles")

@stop
@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp
@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:{{ $dir }}" >
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url(App('urlLang').'account') }}">{{trans('home.mon_compte_header')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.mes_demandes')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container" style="direction:{{ $dir }}">
            <div class="row justify-content-between" >
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between"  style="text-align: justify;">
                        <div class="table-responsive">
                            <table class="table table_striped_col" id="order-table">
                                <thead>
                                <tr>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.num_order')}}</th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.method_paiement')}}</th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.total')}}</th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.date_ajout')}}</th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.operation')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($myorders as $order)
                                    <tr>
                                        <td>#{{$order->id}}</td>
                                        <td>
                                            {{ $order->payment_method }}
                                        </td>
                                        <td>
                                            {{$order->total}}$<br/>
                                            <span>{{trans('home.total_paid')}}</span>: {{$order->totalPaid()}}$
                                        </td>
                                        <td>{{ date("Y-m-d",strtotime($order->created_at)) }}</td>
                                        <td>
                                            <a href="{{url(App('urlLang').'account/view/'.$order->id)}}" class="view-order">{{trans('home.show_demande')}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $myorders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    @include("front.account.js.active_link_js")
@stop


