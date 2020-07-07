@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.mes_points')}}</title>
@stop
@section("styles")

@stop
@php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $alignText = session()->get('locale') === "ar" ? "right" : "left" @endphp
@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:{{ $dir }}">
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
                            <span>{{trans('home.mes_points')}}</span>
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
                        <div class="area-content col-xs-12" style="text-align: justify;">
                            <?php $sumPoints = 0;?>
                            @if(!$points->isEmpty())
                                <table class="table table-striped cart-list">
                                    <thead>
                                    <tr>
                                        <th style="text-align: {{$alignText}}">
                                            {{trans('home.product')}}
                                        </th>
                                        <th style="text-align: {{$alignText}}">
                                            {{trans('home.points')}}
                                        </th>
                                    </tr>
                                    </thead> 
                                    <tbody>

                                    @foreach($points as $point)
                                        <tr>
                                            <td>
                                                <?php
                                                $url = "";
                                                $product_details="";
                                                $orderproduct = $point->orderproduct;
                                                if(!empty($orderproduct->course_id)&&!empty($orderproduct->course)){
                                                    $product_details = $orderproduct->course->course_trans(Session()->get('locale'))->name;
                                                    if(!empty($orderproduct->coursetype_variation)){
                                                        $courseTypeVairiation = $orderproduct->coursetype_variation;
                                                        $product_details .= "<br/>".$courseTypeVairiation->courseType->type;
                                                        if(!empty($courseTypeVairiation->teacher))
                                                            $product_details .= " ".$courseTypeVairiation->teacher->teacher_trans(Session()->get('locale'))->name;
                                                        $url = url(App('urlLang').'courses/'.$courseTypeVairiation->coursetype_id);
                                                    }
                                                }elseif(!empty($orderproduct->book_id)&&!empty($orderproduct->book))
                                                    $book_trans = $orderproduct->book->book_trans(Session()->get('locale'));
                                                if(!empty($book_trans)){
                                                    $product_details = $book_trans->name;
                                                    $url = url(App('urlLang').'books/'.$book_trans->slug);
                                                }
                                                ?>
                                                <a href="{{ $url }}">
                                                    {!! $product_details !!}
                                                </a>
                                            </td>
                                            <td>
                                                {{$point->points}}
                                                <?php $sumPoints+=$point->points;?>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <p>{{trans('home.total_reward_points')}} : {{$sumPoints}}</p>
                            <?php
                            $orderspoints = $user->orders()->whereIn("orders.id",$paidOrder_ids)
                                ->select(DB::raw('sum(points) as sumPoints'))->first()->sumPoints;
                            if(empty($orderspoints))
                                $orderspoints=0;
                            ?>
                            <p>{{trans('home.total_dismissed_points')}}: {{$orderspoints}}</p>

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


