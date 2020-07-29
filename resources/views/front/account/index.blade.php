@extends('front/layouts/master')

@section('meta')
	<title>{{trans('home.mon_compte_header')}}</title>
@stop
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
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
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>{{trans('home.mon_compte_header')}}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area" >
        <div class="container filter_container" style="direction:{{ $dir }}" >
            <div class="row justify-content-between">
                @include("front.account._sidebar")
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between row-account" style="text-align: justify;">
                        <div class="col-md-3">
                          <!--   @if(!empty($user->image))
                                 <img src="{{ asset("uploads/kcfinder/upload/image/users/".$user->image) }}"
                                     class="user-img mx-auto d-block" alt="{{ $user->{'full_name_'.Session::get('locale')} }}"/>
                            @else
                                <img src="{{asset('assets/front/img/user1.jpg')}}"  alt="{{ Auth::user()->{'full_name_'.Session::get('locale')} }}"  style="width: 30px;border-radius: 20px;"/>
                            @endif -->
                            @if(empty($user->image))
                                @if($user->gender =='male')
                                    <img src="{{asset('assets/front/img/user_m.png')}}" class="user-img mx-auto d-block"
                                     alt="{{ $user->{'full_name_'.Session::get('locale')} }}">
                                @elseif ($user->gender =='female')
                                      <img src="{{asset('assets/front/img/user_f.png')}}" class="user-img mx-auto d-block"
                                     alt="{{ $user->{'full_name_'.Session::get('locale')} }}">
                                @endif      

                            @else

                                <img src="{{ asset("uploads/kcfinder/upload/image/users/".$user->image) }}"
                                     class="user-img mx-auto d-block" alt="{{ $user->{'full_name_'.Session::get('locale')} }}"/>
                               
                            @endif
                        </div>
                        <div class="col-md-6 user-name">
                            <h4>{{ $user->{'full_name_'.Session::get('locale')} }}</h4>
                            @if(!empty($user->student))
                                <p>{{trans('home.etudiant')}}</p>
                            @endif
                            <p>                       {{trans('home.your_link_promotional')}}
                                <span class="procode">{{ url(App('urlLang').'promo/'.$user->id) }}</span>
                                <span class="help-inline procode2">{{trans('home.give_link_to_student')}}  </span>
                            </p>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="{{ url(App('urlLang').'logout') }}">
                                <div class="logout-icon">
                                    <i class="fa fa-power-off"></i>
                                </div>
                                <h6 class="logout-link">{{trans('home.logout')}} </h6>
                            </a>
                        </div>
                    </div>


                    <div class="row justify-content-between row-account" >
                        <div class="col text-center">
                            <div class="card bg-dark card_style_one text-white">
                                <img class="card-img" src="{{ asset('assets/front/img/Layer%205.png') }}" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-shopping-cart"></i></h5>
                                    <p class="card-text">{{ $countOrders }}</p>
                                </div>
                            </div>
                            <h5>{{trans('home.total_orde')}}</h5>
                        </div>
                        <div class="col text-center">
                            <div class="card bg-dark card_style_two text-white">
                                <img class="card-img" src="{{ asset('assets/front/img/Layer%205.png') }}" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-certificate"></i></h5>
                                    <p class="card-text">0</p>
                                </div>
                            </div>
                            <h5>{{trans('home.free_cours')}}</h5>
                        </div>
                        <div class="col text-center">
                            <div class="card bg-dark card_style_three text-white">
                                <img class="card-img" src="{{ asset('assets/front/img/Layer%205.png') }}" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-certificate"></i></h5>
                                    <p class="card-text">{{ $countPaidCourses }}</p>
                                </div>
                            </div>
                            <h5>{{trans('home.paid_cours')}}</h5>
                        </div>
                        <div class="col text-center">
                            <div class="card bg-dark card_style_four text-white">
                                <img class="card-img" src="{{ asset('assets/front/img/Layer%205.png') }}" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-graduation-cap"></i></h5>
                                    <p class="card-text">{{ $countCertificates }}</p>
                                </div>
                            </div>
                            <h5>{{trans('home.certif_delivre')}}</h5>
                        </div>
                    </div>

                    <div class="filteration_content">
                        <div class="row justify-content-between content_head">
                            <div class="table-responsive">
                                <table class="table table_striped_col">
                                <thead>
                                <tr>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}}" width="5%">#
                                    </th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}};">{{trans('home.product')}}</th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}};">{{trans('home.product_type')}}</th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}};" width ="15%">{{trans('home.statut')}}</th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}};">{{trans('home.nbr_student')}} </th>
                                    <th scope="col" class="head_col" style="text-align: {{$alignText}};">{{trans('home.total_withou_tva')}}</th>
                                    <th scope="col " class="head_col" style="text-align: {{$alignText}};" width="14%">{{trans('home.date')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ordersProducts as $orderproduct)
                                    <tr>
                                        @php 
                                            $page = empty(Request::get('page')) ?  1 : Request::get('page');
                                            $i = (($page-1) * 5) + $loop->iteration ; 
                                        @endphp
                                         
                                         
                                        <td class="row_head">{{ $i }}</td>
                                        <?php $page++; ?>
                                        <td>
                                            <?php
                                                $url = "";
                                            $product_details="";
                                            if(!empty($orderproduct->course_id)&&!empty($orderproduct->course)){
                                                $product_details = $orderproduct->course->course_trans(Session::get('locale'))->name;
                                                if(!empty($orderproduct->coursetype_variation)){
                                                    $courseTypeVairiation = $orderproduct->coursetype_variation;
                                                    $product_details .= "<br/>".$courseTypeVairiation->courseType->type;
                                                    if(!empty($courseTypeVairiation->teacher))
                                                        $product_details .= " ".$courseTypeVairiation->teacher->teacher_trans(Session::get('locale'))->name;
                                                    $url = url(App('urlLang').'courses/'.$courseTypeVairiation->coursetype_id);
                                                }elseif(!empty($orderproduct->course)){
                                                    $courseType = $orderproduct->course->courseTypes()->first();
                                                    $url = url(App('urlLang').'courses/'.$courseType['id']);
                                                }
                                            }elseif(!empty($orderproduct->quiz_id)&&!empty($orderproduct->quiz)){
                                                $quiz_trans = $orderproduct->quiz->quiz_trans(Session::get('locale'));
                                                if(!empty($quiz_trans)){
                                                    $product_details = $quiz_trans->name;
                                                    $url = "";
                                                }
                                            }elseif(!empty($orderproduct->pack_id)){
												$packs = \App\Packs::findOrFail($orderproduct->pack_id);
												$product_details = $packs->titre;
												$url = url(App('urlLang').'packs/'.$packs->id);
                                            }elseif(!empty($orderproduct->book_id)&&!empty($orderproduct->book)){
                                                $book_trans = $orderproduct->book->book_trans(Session::get('locale'));
                                                if(!empty($book_trans)){
                                                    $product_details = $book_trans->name;
                                                    $url = url(App('urlLang').'books/'.$book_trans->slug);
                                                }
                                            }
                                            ?>
                                            <a href="{{ $url }}"> 
                                                {!! $product_details !!}
                                            </a> 
                                        </td>
                                        <td>
                                            @if(!empty($orderproduct->course_id))
                                            {{trans('home.cours_compte')}}
                                            @elseif(!empty($orderproduct->quiz_id))
                                            {{trans('home.exam_compte')}}
                                            @elseif(!empty($orderproduct->book_id))
                                             {{trans('home.livre_compte')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($orderproduct->isTotalPaid())
                                                <span class="btn btn-confirm">{{trans('home.paiement_confirmer')}}</span>
                                            @elseif($orderproduct->payment_method=="banktransfer"||$orderproduct->payment_method=="agent")
                                                <span class="btn btn-not-confirm">{{trans('home.paiement_en_attente')}}</span>
                                            @else
                                                <span class="btn btn-not-confirm">{{trans('home.paiment_unpaid')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $orderproduct->num_students }}
                                        </td>
                                        <td>{{ $orderproduct->total }} $</td>
                                        <td>{{ date("Y-m-d",strtotime($orderproduct->order->created_at)) }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            </div>
                            {{ $ordersProducts->links() }}
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


