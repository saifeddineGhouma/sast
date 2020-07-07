@extends('front/layouts/master')

@section('meta')
	<title>طلباتي للمساعدة</title>
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
                            <span> {{trans('home.demande_aide')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container" style="direction:{{ $dir }}">
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
					<div class="row justify-content-between row-account">
						<div class="col-md-3">
							<div align="left">
								<a href="{{ url(App('urlLang').'account/ticket/add') }}" class="btn btn-md btn-warning svme">{{trans('home.new_request')}} </a>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12">
							<div class="table-responsive" style="text-align: justify">
								<table class="table table_striped_col" id="order-table">
									<thead>
										<tr>
											<th scope="col" class="head_col" style="text-align: {{$alignText}}"> {{trans('home.num_order')}} </th>
											<th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.title')}}</th>
											<th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.date_ajout')}}</th>
											<th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.statut')}} </th>
											<th scope="col" class="head_col" style="text-align: {{$alignText}}"></th>
										</tr>
									</thead>
									<tbody>
										@foreach($tickets as $ticket)
											<tr>
												<td>{{$ticket->id}}</td>
												<td>{{$ticket->titre}}</td>
												<td>{{$ticket->created_at}}</td>
												<td>
													@if($ticket->resolu==1) 
														{{trans('home.prob_solved')}} 
													@elseif($ticket->resolu==2)
														{{trans('home.prob_not_solved')}}	
													@elseif($ticket->resolu==3)
														{{trans('home.prob_close')}}
													@endif
												</td>
												<td><a href="{{ url(App('urlLang').'account/ticket/add') }}/{{$ticket->id}}">{{trans('home.detail_ticket')}}</a></td>
											</tr>
										@endforeach
									</tbody>
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
    @include("front.account.js.active_link_js")
@stop


