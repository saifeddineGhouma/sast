@extends('front/layouts/master')

@section('meta')
	@if(!empty($metaData))
		<title>{{$metaData->title}}</title>
		<meta name="keywords" content="{{$metaData->keyword}}" />
		<meta name="description" content="{{$metaData->description}}">
	@endif
@stop
@section('styles')

@stop
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@section('content')
	<div class="training_purchasing">
		<div class="container training_container">
			<div class="media" style="direction: {{$dir}};">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span>{{ trans('home.page_faq') }} </span>
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>

	<div class="container"  >
		<div class="row">
			<div class="col-md-12">
				<div class="panel-group faq" id="accordion" style="direction: {{$dir}};"> 
					@foreach($faqs as $faq)
						<div class="panel panel-default">

							<div class="panel-heading" id="headingOne">

								<h6 class="panel-title" style="text-align: justify">
									<a data-toggle="collapse" data-parent="#accordion" href="#panel{{ $faq->id  }}" aria-expanded="false" class="collapsed"  style="text-align: justify"> 
										{{$loop->iteration}} .{{ $faq->faq_trans(session()->get('locale'))['question'] }}
									</a>
								</h6>
							</div>
							<div id="panel{{ $faq->id  }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body" style="text-align: justify">
									<p>{!! $faq->faq_trans(session()->get('locale'))['answer'] !!}</p>
								</div>
							</div>
						</div>
					@endforeach
				</div>

			</div>
		</div>
	</div>


@stop



@section('scripts')

@stop

