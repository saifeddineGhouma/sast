@extends('front/layouts/master')

@section('meta')
	<title> {{trans('home.demande_aide')}} </title>
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
                            <span>{{trans('home.demande_aide')}} </span>
                        </li>
                    </ol>
                </nav> 
            </div>
        </div>
    </div>

    <div class="account-area">
        <div class="container filter_container" style="direction:{{ $dir }}" >
            <div class="row justify-content-between"> 
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between row-account">
						<div class="col-xs-12">
							<div class="col-xs-4">
								<a href="{{ url(App('urlLang').'account/ticket/success') }}/{{$ticket->id}}" class="btn btn-md btn-success svme">{{trans('home.prob_solved')}} </a>
							</div>
							<div class="col-xs-4">
								<a href="{{ url(App('urlLang').'account/ticket/warning') }}/{{$ticket->id}}" class="btn btn-md btn-warning svme">{{trans('home.prob_not_solved')}}</a>
							</div>
						</div>
						<div class="area-content col-xs-12">
							<table class="table table-striped table-bordered" id="table1">
								<thead>
									<tr>
										<th style="text-align: {{$alignText}}">{{trans('home.from')}}</th>
										<th style="text-align: {{$alignText}}">{{trans('home.text_probleme')}}</th>
										<th scope="col" class="head_col" style="text-align: {{$alignText}}">{{trans('home.date_ajout')}}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($tickets as $item)
										<tr>
											<td>
												@if($item->user_id==0)
													Admin
												@else
													{{$ticket->user->username}}
												@endif
											</td>
											<td>
												{{$item->message}}
											</td>
											<td>{{$item->created_at}}</td>
										</tr>
									@endforeach
									<tr>
										<td>{{$ticket->user->username}}</td>
										<td>
											{{$ticket->titre}}
											<br>
											{{$ticket->message}}
										</td>
										<td>{{$ticket->created_at}}</td>
									</tr>
								</tbody>
							</table>
							<form  id="info_form" method="post" action="{{ url(App('urlLang').'account/ticket/create2') }}" enctype="multipart/form-data">
								{!! csrf_field() !!}
								<input type="hidden" value="{{$ticket->id}}" name="ticket_id" />
								<div class="form-group" style="text-align: {{$alignText}}">
									<label class="form-label">{{trans('home.text_probleme')}} <span>*</span></label>
									<textarea class="form-control" name="message" ></textarea>
								</div>
								<input type="submit" class="btn btn-md btn-success svme" value="{{trans('home.save')}}">
							</form>
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


