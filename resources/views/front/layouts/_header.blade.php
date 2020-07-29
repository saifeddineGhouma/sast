<div class="search_website">

    <i class="fa fa-times-circle exit" aria-hidden="true"></i>

    <form>

        <div class="form-group">

            <label>ابحث في الموقع</label>

            <input class="form-control search_input form-control-lg" type="text" placeholder="ادخل كلمة البحث">

        </div>

        <button type="submit" class="btn btn-dark submit_search">بحث</button>

        <button type="button" class="btn btn-light submit_search">الغاء</button>

    </form>

</div>

<div class="container-fluid navbar-info">

    <div class="row top-bar">

        <div class="col-sm-6">

            <ul class="nav cstulnv">

                <!--<li class="nav-item">

                    <a class="nav-link" href="#"><i class="fa fa-search"></i></a>

                </li>-->

                <?php

                $menuPos = App\MenuPos::find(2);

                $menu = $menuPos->menus()->first();

                ?>

                @if(!empty($menu))

                    {!! $menu->links("header") !!}

                @endif

            </ul>
            <ul class="social-icons ulnvhdr">
                @foreach(App('setting')->socials as $social)
                    <a href="{{ $social->link }}" target="_blank">
                        <i id="social-fb" class="{{ $social->font }} fa-2x social"></i>
                    </a>
                @endforeach
            </ul>
        </div>

        <div class="col-sm-6 locaion">

            <ul class="nav">

                <li class="nav-item">

                    <a class="nav-link" href="tel:+46767045506" style="direction:ltr"><i class="fa fa-whatsapp"></i>&ensp;{{ App('setting')->mobile }}</a>

                </li>

                <li class="nav-item">

                    <a class="nav-link" href="https://goo.gl/maps/nYFFMKJEp392" target="_blank" style="direction:ltr"><i class="fa fa-map-marker"></i>&ensp;{{App('setting')->settings_trans(session()->get('locale'))->address}}</a>

                </li>

            </ul>

        </div>
 


    </div>

</div>

<!----  nav    --->

<div class="container-fluid">

<nav class="navbar navbar-expand-md main-nav " dir="{{ $dir}}">


        <button class="navbar-toggler col-xs-1" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="fa fa-bars"></span>

        </button>

        <div class="col-md-2 col-xs-6"><a class="navbar-brand" href="{{ url(App('urlLang')) }}">

                <img src="{{asset('uploads/kcfinder/upload/image/'.App("setting")->settings_trans(App('lang'))->logo)}}" alt="Swedish" title="Swedish">

            </a>

        </div>



        <div class="collapse navbar-collapse n-menu col-md-6" id="navbarSupportedContent">

            <ul class="navbar-nav ml-auto" >

                <?php

                $menuPos = App\MenuPos::find(1);
    
                $menu = $menuPos->menus()->first();
                ?>

                <!-- Souhir multi langauge base de données  -->
 
                @if(!empty($menu))

                    {!!  $menu->links("mainmenu") !!}

                @endif

            </ul>



        </div>

        

        <div class="col-md-2 col-xs-4" >

            <ul class="navbar-nav shop-ul">
                @if(Auth::check())
                    <li class="nav-item p-3 dropdown">
                        <a class="nav-link " id="navbarDropdown" href="#" onclick="return false;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <!--      @if(!empty(Auth::user()->image))
                                <img src="{{ asset('uploads/kcfinder/upload/image/users/'.Auth::user()->image) }}" style="width:30px;border-radius: 20px;"/>
                            @else
                                <img src="{{asset('assets/front/img/user1.jpg')}}"  alt="{{ Auth::user()->{'full_name_'.App('lang')} }}"  style="width: 30px;border-radius: 20px;"/>
                            @endif
 -->
                             @if(empty(Auth::user()->image))
                                @if(Auth::user()->gender =='male')
                                <img src="{{asset('assets/front/img/user_m.png')}}"  alt="{{ Auth::user()->{'full_name_'.App('lang')} }}"  style="width: 30px;"/>
                           
                                @elseif (Auth::user()->gender =='female')
                                    <img src="{{asset('assets/front/img/user_f.png')}}"  alt="{{ Auth::user()->{'full_name_'.App('lang')} }}"  style="width: 30px;"/>
                                @endif     

                            @else

                                <img src="{{ asset('uploads/kcfinder/upload/image/users/'.Auth::user()->image) }}" style="width: 30px;border-radius: 20px;"/>
                               
                            @endif

                            </i><span class="acct">   {{ trans('sentence.bienvenu') }} {{ Auth::user()->username }}<span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{url(App('urlLang').'account')}}"> {{ trans('home.mon_compte_header') }}   </a>
                            <a class="dropdown-item" href="{{url(App('urlLang').'logout')}}"> {{ trans('home.logout') }}  </a>
                        </div>
                    </li>

                @else
                    <li class="nav-item p-3">

                        <a class="nav-ico" href="{{url(App('urlLang').'account')}}"><i class="fa fa-user"></i><span class="acct">{{ trans('home.login') }} </span></a>

                    </li>

                @endif 
                <li class="nav-item p-3"> 

                    <?php

                    $cart = session()->get('cart');

                    $countProducts = 0;

                    $total = 0;

                    if(!is_null($cart)){

                        foreach ($cart as $key=>$cart_pro){

                            $countProducts+=$cart_pro["quantity"];

                            $total+=$cart_pro["total"];

                        }

                        session()->put('cart', $cart);

                    }

                    ?>

                    <a class="nav-ico" href="{{ url(App('urlLang').'cart') }}">

                        <i class="fa fa-shopping-basket"></i><span class="badge bskt">{{ $countProducts }}</span>

                    </a>
                    

                </li>
                
           </ul>

        </div>
        <div class="col-md-2 col-xs-4">

            <ul class="navbar-nav shop-ul">
                    
                <li class="nav-item p-3 dropdown">
                    <a class="nav-link " id="navbarDropdown" href="#" onclick="return false;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <span class="acct"> 
                                @switch($locale)
                                @case('en')
                                <img src="https://lipis.github.io/flag-icon-css/flags/4x3/gb.svg" alt="United kingdom" class="img-size-50 mr-3 img-circle" style="width: 25px">
                                @break
                                
                               
                                @default
                                <img src="https://lipis.github.io/flag-icon-css/flags/4x3/tn.svg" alt="Arabe" class="img-size-50 mr-3 img-circle" style="width: 25px">
                                @endswitch
                            
                            
                            
                            
                                {{ trans('sentence.langue') }}<span>
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdown" style="text-align: {{ $locale === "ar" ? "right" : "left"}}" >
                        <a class="dropdown-item" href="/lang/en">
                            <img src="https://lipis.github.io/flag-icon-css/flags/4x3/gb.svg" alt="United kingdom" class="img-size-50 mr-3" style="width: 25%">
                            {{ trans('sentence.english') }}
                        </a>
                        <a class="dropdown-item" href="/lang/ar">
                            <img src="https://lipis.github.io/flag-icon-css/flags/4x3/tn.svg" alt="Arabe" class="img-size-50 mr-3 " style="width: 25%">
                            {{ trans('sentence.arabe') }}
                        </a>
                        <!--
                        <a class="dropdown-item" href="/lang/fr">
                            <img src="https://lipis.github.io/flag-icon-css/flags/4x3/fr.svg" alt="Frensh" class="img-size-50 mr-3" style="width: 25%">
                            @lang('frensh')
                        </a>-->
                        
                    </div>
                </li>   
            </ul>
    
        </div>

    </nav> 

</div>

